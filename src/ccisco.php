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

	public function get_port_vlans($port, $get_all = false) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_port_vlans($port, $get_all);
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

	protected function _snmp_get_mac_table($vlan = 0) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$row_vlan_list = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['VlanList'].'.2.1');
		if ($row_vlan_list === false) return false;

		$vlan_table = array();
		foreach ($row_vlan_list as $k => $v)
			if ($v == 1) {
				$matches = 0;
				preg_match('/\.([0-9]+)$/', $k, $matches);
				$vlan = $matches[1];
				if (($vlan >= 1002) && ($vlan <= 1005)) continue; //dirty hack
				$vlan_table[$vlan] = array(); //vlan in vlan database and active
			}

		
	}

	protected function _snmp_get_vlan_table() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$row_vlan_list = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['VlanList'].'.2.1');
		if ($row_vlan_list === false) return false;
		$row_trunk_mode = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['TrunkVlans'].'.14');
		if ($row_trunk_mode === false) return false;
		$row_port_vlans[0] = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['TrunkVlans'].'.4');
		if ($row_port_vlans[0] === false) return false;
		$row_port_vlans[1] = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['TrunkVlans'].'.17');
		if ($row_port_vlans[1] === false) return false;
		$row_port_vlans[2] = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['TrunkVlans'].'.18');
		if ($row_port_vlans[2] === false) return false;
		$row_port_vlans[3] = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['TrunkVlans'].'.19');
		if ($row_port_vlans[3] === false) return false;
		$row_access_vlans = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['AccessVlans'].'.2');
		if ($row_access_vlans === false) return false;
		$row_native_vlans = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['TrunkVlans'].'.5');
		if ($row_native_vlans === false) return false;

		$vlan_table = array();
		foreach ($row_vlan_list as $k => $v)
			if ($v == 1) {
				$matches = 0;
				preg_match('/\.([0-9]+)$/', $k, $matches);
				$vlan = $matches[1];
				if (($vlan >= 1002) && ($vlan <= 1005)) continue; //dirty hack
				$vlan_table[$vlan] = array(); //vlan in vlan database and active
			}

		$port_in_trunk = array();
		foreach ($row_trunk_mode as $k => $v) {
			$matches = 0;
			preg_match('/\.([0-9]+)$/', $k, $matches);
			if ($v == 1) $port_in_trunk[$matches[1]] = true;
			else $port_in_trunk[$matches[1]] = false;
		}

		for ($m = 0; $m < 4; $m++) {
			foreach ($row_port_vlans[$m] as $k => $v) {
				$matches = 0;
				preg_match('/\.([0-9]+)$/', $k, $matches);
				$ifindex = $matches[1];
				$port_vlan_table = trim($v);
				$per8_vlans = explode(' ', $port_vlan_table);
				for ($i = 0; $i < count($per8_vlans); $i++) {
					$per8_vlans[$i] = hexdec($per8_vlans[$i]);
					for ($j = 0; $j < 8; $j++) {
						if ($i == 0 && $j == 0 && $m == 0) continue; //zero vlan
						$offset = 128 >> $j;
						$vlan = $i * 8 + $j + $m * 1024;
						if (!isset($vlan_table[$vlan])) continue; //there is no vlan in vlan database or it's not active
						if (($per8_vlans[$i] & $offset) && $port_in_trunk[$ifindex]) $vlan_table[$vlan][$ifindex] = 1;
						else $vlan_table[$vlan][$ifindex] = 0;
					}
				}
			}
		}

		foreach ($row_native_vlans as $k => $v) {
			$matches = 0;
			preg_match('/\.([0-9]+)$/', $k, $matches);
			$ifindex = $matches[1];
			if ($port_in_trunk[$ifindex] && isset($vlan_table[$v])) $vlan_table[$v][$ifindex] = 2;
		}

		foreach ($row_access_vlans as $k => $v) {
			$matches = 0;
			preg_match('/\.([0-9]+)$/', $k, $matches);
			$ifindex = $matches[1];
			if (($port_in_trunk[$ifindex] == false) && isset($vlan_table[$v])) $vlan_table[$v][$ifindex] = 2;
		}

		return $vlan_table;
	}

}

?>
