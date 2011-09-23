<?php
require_once('func.php');
require_once('consts.php');
require_once('class.telnet.inc.php');
require_once('cdlink.php');

class CDlink3226S extends CDlink {

	public function get_fw_ver($id = nil) {
		$f = 0;
		if (!isset($this->fwver1)) $f = $this->check_fw_ver();
		else $f = 1;
		if (!$f) return false;
		return $this->fwver1;
	}

	public function check_fw_ver() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_fwver();
		return false;
	}



	//---------------------------------SNMP_CHECKS-------------------------------------


}
?>
