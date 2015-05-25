<?php

require_once('func.php');
require_once('consts.php');
require_once('cswitch.php');

class CCisco extends CSwitch {

	public function get_adm_status($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_adm_status($port);
	}

	public function get_oper_status($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_oper_status($port);
	}

	public function get_oper_speed($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_oper_speed($port);
	}


	public function get_description($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_description($port);
	}

	public function get_errors($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors($port);
	}

	public function get_discards($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_discards($port);
	}

	public function get_bytes_inbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_bytes_inbound($port);
	}

	public function get_bytes_outbound($port) {
		$port = $this->get_ifindex(port);
		if (!$port) return false;
		return parent::get_bytes_outbound($port);
	}

	public function get_nonunicast_inbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_nonunicast_inbound($port);
	}

	public function get_nonunicast_outbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_nonunicast_outbound($port);
	}

	public function get_unicast_inbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_unicast_inbound($port);
	}

	public function get_unicast_outbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_unicast_outbound($port);
	}

	public function check_model() {
		if (!isset($this->model_name)) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$r = $this->_snmp_get_hardware_model_names();
			if (!$r) return false;
			foreach($r as $v)
				if (trim($v, '"') == $this->model_name) return true;
		}
		return false;
	}


	//---------------------------------SNMP_CHECKS-------------------------------------


	protected function _snmp_get_port_of_mac_vlan($mac, $vlan) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$snmp_mac = ConvertMac($mac, 2);
		$brIndex = snmpget($this->ip, $comm."@$vlan", $snmp_oids['MacList'].'.'.$snmp_mac);
		return $this->get_ifname_by_bridge_index($brIndex);
	}

	protected function _snmp_get_hardware_model_names() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['PhysEntry'].'.13');
	}


}

?>
