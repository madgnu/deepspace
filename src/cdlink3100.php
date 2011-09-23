<?php

require_once('func.php');
require_once('consts.php');
require_once('cdlink.php');

class CDlink3100 extends CDlink {

	public function get_self_mac() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_self_mac();
		return false;

	}


	//---------------------------------SNMP_CHECKS-------------------------------------

	public function _snmp_get_self_mac() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return ConvertMac(trim(snmpget($this->ip, $comm, $snmp_oids['DGS-3100']['SelfMac']), '"'));

		return false;

	}

	protected function _snmp_get_iproute_default() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$r = 0;
		$r = snmprealwalk($this->ip, $comm, $snmp_oids['DGS-3100']['ipRouteDefault']);
		if (!$r) return false;

		foreach ($r as $ret) return $ret;

	}

	protected function _snmp_get_fwver() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		if (isset($snmp_oids[$this->series]['FwVer'])) $oid = $snmp_oids[$this->series]['FwVer'];
		else $oid = $snmp_oids['DLink']['FwVer'];

		$r = snmpget($this->ip, $comm, $oid.'.0');
		$matches = 0;
		preg_match('/([^"]+)/', $r, $matches);
		if (count($matches) == 2) $this->fwver1 = 'Build '.$matches[1];
		else $this->fwver1 = 'Build '.$r;

		return true;
	}


}
?>
