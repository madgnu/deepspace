<?php

require_once('consts.php');

//NETWORK UTILS---------------------------------------------
/*function ping($host, $timeout = 1, $attempts = 1) {
	// ICMP ping packet with a pre-calculated checksum 
	$package = "\x08\x00\x7d\x4b\x00\x00\x00\x00PingHost";
	$socket  = socket_create(AF_INET, SOCK_RAW, 1);
	socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => $timeout, 'usec' => 0));
	socket_connect($socket, $host, null);


	for ($i = 1; $i <= $attempts; $i++) {
		$ts = microtime(true);
		socket_send($socket, $package, strLen($package), 0);
		if (socket_read($socket, 255)) {
			$result = microtime(true) - $ts;
			break;
		}
		else $result = false;
	}
	socket_close($socket);

	return $result;
}*/

function ping($host, $timeout = 1, $attempts = 1) {
	require_once('Net/Ping.php');
	$ping = Net_Ping::factory();
	$ping->setArgs(array('count'=>1, 'timeout'=>$timeout));
	for ($i = 1; $i <= $attempts; $i++) {
		$r = 0;
		$r = $ping->ping($host);
		if (!$r) return false;
		if ($r->getReceived()) return true;
	}
	return false;
}

function ConvertMac($mac, $style = 0, $use_delimetr = 1, $delimetr = '[^0-9a-f]', $dex = 0) {
	$mac = trim($mac);
	if ($use_delimetr) {
		$pcre = '/([0-9a-f]+)'.$delimetr.
			'([0-9a-f]+)'.$delimetr.
			'([0-9a-f]+)'.$delimetr.
			'([0-9a-f]+)'.$delimetr.
			'([0-9a-f]+)'.$delimetr.
			'([0-9a-f]+)/i';
		preg_match($pcre, trim($mac), $mp);
		if (count($mp)!=7) return false;
		for ($i = 1; $i < 7; $i++) {
			if ($dex) $mp[$i] = dechex($mp[$i]);
			if (strlen($mp[$i]) == 1) $mp[$i] = '0'.$mp[$i];
		}
		$mac = $mp[1].$mp[2].$mp[3].$mp[4].$mp[5].$mp[6];
	}
	unset($mp);
	preg_match_all('/[0-9a-f]{1}/i',trim($mac),$mp); //mp is array, contains part of pure mac (0-9a-zA-Z)
	if (count($mp[0])!=12) return false;
	switch($style) {
		case 0:
			$newformat = strtolower($mp[0][0].$mp[0][1].':'. //billing
				$mp[0][2].$mp[0][3].':'.
				$mp[0][4].$mp[0][5].':'.
				$mp[0][6].$mp[0][7].':'.
				$mp[0][8].$mp[0][9].':'.
				$mp[0][10].$mp[0][11]); break;
		case 1:
			$newformat = strtoupper($mp[0][0].$mp[0][1].'-'. //dlink
				$mp[0][2].$mp[0][3].'-'.
				$mp[0][4].$mp[0][5].'-'.
				$mp[0][6].$mp[0][7].'-'.
				$mp[0][8].$mp[0][9].'-'.
				$mp[0][10].$mp[0][11]); break;
		case 2:
			$newformat = hexdec($mp[0][0].$mp[0][1]).'.'. //snmp
				hexdec($mp[0][2].$mp[0][3]).'.'.
				hexdec($mp[0][4].$mp[0][5]).'.'.
				hexdec($mp[0][6].$mp[0][7]).'.'.
				hexdec($mp[0][8].$mp[0][9]).'.'.
				hexdec($mp[0][10].$mp[0][11]); break;
		default:
			$newformat = strtolower($mp[0][0].$mp[0][1].':'. //default is billing
				$mp[0][2].$mp[0][3].':'.
				$mp[0][4].$mp[0][5].':'.
				$mp[0][6].$mp[0][7].':'.
				$mp[0][8].$mp[0][9].':'.
				$mp[0][10].$mp[0][11]); break;
	}
	return $newformat;
}

function IpCIDRCheck($ip, $cidr) {
	list ($net, $mask) = explode("/", $cidr);
	$ip_net = ip2long ($net);
	$ip_mask = ~((1 << (32 - $mask)) - 1);
	$ip_ip = ip2long ($ip);
	$ip_ip_net = $ip_ip & $ip_mask;
	return ($ip_ip_net == $ip_net);
}

function ManagmentVlanFromIP($ip) {
	global $consts;
	if (!isset($ip)) return false;
	$net_list = $consts['NET']['MANAGMENT'];
	foreach ($net_list as $vlan => $nets_array)
		foreach ($nets_array as $net)
			if (IpCIDRCheck($ip, $net)) return $vlan;
	return false;
}

function AuthMe(&$telnet) {
	global $consts;
	$auths=&$consts['TELNET']['AUTH'];

	$r=$telnet->login($auths);
	if ($r) return true;

	return false;
}

?>
