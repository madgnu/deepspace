<?php

require_once('func.php');
require_once('consts.php');
require_once('cswitch.php');

class CZyxel extends CSwitch {
	public function feature_list() {
		global $consts;
		$features = &$consts['FEATURES'];
		$r = parent::feature_list();

		//vendor-specific
		if (isset($features['GENERAL']['Zyxel'])) $r = $features['GENERAL']['Zyxel'].$r;
		if (isset($features['SNMPRO']['Zyxel']) && ($this->snmp_ro_avail || $this->snmp_rw_avail))
			$r = $features['SNMPRO']['Zyxel'].$r;
		if (isset($features['SNMPRW']['Zyxel']) && $this->snmp_rw_avail)
			$r = $features['SNMPRW']['Zyxel'].$r;

		return $r;
	}

	public function check_model() {
		if (!isset($this->model_name)) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			if (strpos($this->_snmp_get_sys_name(), $this->model_name) !== false) return true;
		return false;
	}

	public function get_self_mac() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_self_mac();
		return false;

	}

	public function get_lldp_remo_chassis($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return parent::get_lldp_remo_chassis($port-1);

		return false;
	}

	public function get_lldp_remo_port($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return parent::get_lldp_remo_port($port-1);
		return false;
	}



	//---------------------------------SNMP_CHECKS-------------------------------------

	protected function _snmp_get_iproute_default() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['Zyxel']['ipRouteDefault']);
	}

	public function _snmp_get_self_mac() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return ConvertMac(snmpget($this->ip, $comm, $snmp_oids['Zyxel']['SelfMac']));

		return false;

	}


}

?>
