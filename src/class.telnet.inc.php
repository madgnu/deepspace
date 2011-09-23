<?php

DEFINE('PROMPT_REGEXP',1);
DEFINE('PROMPT_SUBSTR',2);

class telnet 
 {
  var $host;
  var $port;
  var $timeout;
  var $ListListing;
  var $ListNextPage;  
  var $ListSend;  
  var $goodbye;
  var $login_prompts;
  var $pass_prompts;
  var $socket;
  var $buffer;
  var $prompt;
  var $flag_ins_prompt;
  var $errno;
  var $errstr;
  var $regexp_len;
  var $prompt_type;
  var $allow_negotiate;
  var $dump;

  var $NULL;
  var $DC1;
  var $WILL;
  var $WONT;
  var $DO;
  var $DONT;
  var $IAC;

  function telnet($host, $port = 23, $timeout = 5)
   {
    if (!preg_match('/([0-9]{1,3}\\.){3,3}[0-9]{1,3}/', $host))
     {
      $ip = gethostbyname($host);
      if($this->host == $ip)
       {
        $this->errstr='Cannot resolve '.$this->host;
        return false;
       } else { $this->host = $ip; }
     }
    else { $this->host = $host; }
    $this->port=$port;
    $this->timeout=$timeout;
    if ($this->socket) { fclose($this->socket); $this->socket=NULL; }
    $this->buffer='';
    $this->prompt='';
    $this->flag_ins_prompt=false;
    $this->errno='-1';
    $this->errmsg='';
    $this->NULL=chr(0);
    $this->DC1=chr(17);
    $this->WILL=chr(251);
    $this->WONT=chr(252);
    $this->DO=chr(253);
    $this->DONT=chr(254);
    $this->IAC=chr(255);
    $this->allow_negotiate=false;
    $this->ListListing=false;
    $this->ListNextPage='Next Page';
    $this->ListSend='a';
    $this->goodbye='logout';
    $this->regexp_len=20;	//FIXME: Last N chars in buffer for regexp check
    $this->login_prompts=array('login:','username:','user name:');
    $this->pass_prompts=array('pass:','password:');
    $this->prompt_type=PROMPT_SUBSTR;
   }

  function connect()
   {
    $this->socket = fsockopen($this->host, $this->port, $this->errno, $this->errstr, $this->timeout);
    if (!$this->socket) { $this->errstr='Cannot connect to '.$this->host.' on port '.$this->port; return false; }
    return true;
   }

  function disconnect($goodbye=false)
   {
    if ($this->socket)
     {
      if ($goodbye) $sw->write($this->goodbye);
      if (!fclose($this->socket))
       { $this->errstr='Error while closing telnet socket'; return false; }
      $this->socket = $this->NULL;
     }
    return true;
   }

  function clearBuffer()
   { $this->buffer=''; }

  function setPrompt($s = '$', $prompt = PROMPT_SUBSTR)
   { $this->prompt=$s; $this->prompt_type=$prompt;}

  function getc()
   { return fgetc($this->socket); }

  function gen_bitmask($submask,$len)
   {
    $submask=substr($submask,0,$len);
    if (!preg_match('/^[0-1]*$/',$submask)) $submask=NULL;
    return str_pad($submask,$len,'0');
   }

  function readTo($waitfor,$waitfor_bitmask = 0)
   {
    if (!is_array($waitfor)) { $waitfor_bitmask=$this->gen_bitmask($waitfor_bitmask,1); }
    else { $waitfor_bitmask=$this->gen_bitmask($waitfor_bitmask,count($waitfor)); }

    if (!$this->socket)
     { $this->errstr='Telnet connection closed'; return false; }
    stream_set_timeout($this->socket, $this->timeout); 
    stream_set_blocking($this->socket, true);
    $this->clearBuffer();
    do
     {
      $minibuf = $this->getc();
      if ($minibuf === false)
       { $this->errstr="Couldn't find the requested : '" . $waitfor . "', it was not in the data returned from server : '" . $this->buffer . "'"; return false; }

      // Interpreted As Command
      if ($minibuf == $this->IAC && $this->allow_negotiate)
       if ($this->negotiateTelnetOptions()) continue;

      $this->dump.=$minibuf;
      $this->buffer.=$minibuf;
      if (!is_array($waitfor))
       {
        if (
            (!$waitfor_bitmask &&
             ((substr($this->buffer, strlen($this->buffer) - strlen($waitfor))) == $waitfor) ||
             ($this->flag_ins_prompt && (strtolower((substr($this->buffer, strlen($this->buffer) - strlen($waitfor)))) == strtolower($waitfor)))
            ) ||
            ($waitfor_bitmask && preg_match($waitfor,substr($this->buffer, (0-$this->regexp_len))))
           )
         { return true; }
       }
      else
       {
        for($i=0;$i < count($waitfor); $i++)
         {
          if (!array_key_exists($i,$waitfor)) { $this->errstr="Array to find mustbe NOT assoc with ONLY keys 0,1,2,3....N without spaces"; return false; }
          if (
              (!$waitfor_bitmask[$i] &&
               ((substr($this->buffer, strlen($this->buffer) - strlen($waitfor[$i]))) == $waitfor[$i]) ||
               ($this->flag_ins_prompt && (strtolower((substr($this->buffer, strlen($this->buffer) - strlen($waitfor[$i])))) == strtolower($waitfor[$i])))
              ) ||
              ($waitfor_bitmask[$i] && preg_match($waitfor[$i],substr($this->buffer, (0-$this->regexp_len))))
             )
           { return $i; }
         }
       }

      if (
          ($this->ListListing) &&
          (
           ((substr($this->buffer, strlen($this->buffer) - strlen($this->ListNextPage))) == $this->ListNextPage) ||
           ($this->flag_ins_prompt && (strtolower((substr($this->buffer, strlen($this->buffer) - strlen($this->ListNextPage)))) == strtolower($this->ListNextPage)))
          )
         )
       { $this->write($this->ListSend,false,false); }
      $sockinfo = stream_get_meta_data($this->socket); 
     } while (($minibuf != NULL) && ($minibuf != $this->DC1) && (!$sockinfo['timed_out']));
   return false; 
  }

  function getBuffer()
   {
    $buf = explode("\n", $this->buffer);
    unset($buf[count($buf)-1]);
    $buf = implode("\n",$buf);
    return trim($buf);
   }

  function write($buffer, $addNewLine = true, $clearBuff=true)
   {
    if (!$this->socket) { $this->errstr="Telnet connection closed"; return false; }
    if ($clearBuff) $this->clearBuffer();
    if ($addNewLine == true) $buffer .= "\n";
    if (!fwrite($this->socket, $buffer) < 0) { $this->errstr="Error writing to socket"; return false; }
    return true;
   }

  function waitPrompt()
   {
    if ($this->prompt_type==PROMPT_SUBSTR) { return $this->readTo($this->prompt); }
    elseif ($this->prompt_type==PROMPT_REGEXP) { return $this->readTo($this->prompt,1); }
    else return false;
   }

  function exec($command)
   {
    if ($this->write($command) && $this->waitPrompt()) return $this->getBuffer();
    return false;
   }

  function login($logpassarr)
   {
    if (!$this->socket) { $this->errstr="Telnet connection closed"; return false; }
    $logged_in=false;
    $ak=array_keys($logpassarr);
    $av=array_values($logpassarr);
    for($i=0; $i<=count($logpassarr); $i++)
     {
      if ($this->prompt_type==PROMPT_SUBSTR)
       { $res=$this->readTo(array_merge(array($this->prompt),$this->login_prompts)); }
      elseif($this->prompt_type==PROMPT_REGEXP)
       { $res=$this->readTo(array_merge(array($this->prompt),$this->login_prompts),1); }
      if ($res===false) { $k=$this->buffer; $this->errstr="Can not find username prompt"; $this->clearBuffer(); return false; }
      if ($res==0) { $this->clearBuffer(); return $ak[($i-1)]; }
      if ($i>=count($logpassarr)) break;
      $res=$this->write($av[$i]['login']);
      if ($res===false) { $this->errstr="Can not send username"; $this->clearBuffer(); return false; }
      $res=$this->readTo($this->pass_prompts);
      if ($res===false) { $this->errstr="Can not find password prompt"; $this->clearBuffer(); return false; }
      $res=$this->write($av[$i]['password']);
      if ($res===false) { $this->errstr="Can not send password"; $this->clearBuffer(); return false; }
     }
    $this->errstr="Invalid User/Pass combinations";
    return false;
   }

  function negotiateTelnetOptions()
   {
    $c = $this->getc();
    if ($c != $this->IAC)
     {
      if (($c == $this->DO) || ($c == $this->DONT))
       {
        $opt = $this->getc();
        fwrite($this->socket, $this->IAC . $this->WONT . $opt);
       }
      else
       if (($c == $this->WILL) || ($c == $this->WONT))
        {
         $opt = $this->getc();
         fwrite($this->socket, $this->IAC . $this->DONT . $opt);
        }
       else
        {
         $this->errstr='Error: unknown control character '.ord($c); $this->clearBuffer(); return false;
        }
     }
    else
     {
      $this->errstr='Error: Something Wicked Happened'; $this->clearBuffer(); return false;
     }
    return true;
   }

   function keepAlive()
    {
     if ($this->exec('') === false) return false;
     return true;
    }

 }



?>

