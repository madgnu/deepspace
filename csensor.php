<?php

require_once('consts.php');
require_once('func.php');

class CSensor {

	public function __construct($base_interface, $sensor_name) {
		$this->name = $sensor_name;
		$this->base_interface = $base_interface;
	}

	public function create_vlan_interface($vlan) {
		if (!isset($vlan)) return false;
		$base_interface = $this->base_interface;
		exec('vconfig set_name_type DEV_PLUS_VID_NO_PAD');
		$r = 0;
		exec("vconfig add $base_interface $vlan", $r);
		if (preg_match('/ERROR/i', $r[0])) return false;
		$r = 0;
		exec("ifconfig $base_interface.$vlan up", $r);
		if (count($r)) return false;
		return true;
	}

	public function add_addr_to_vlan_interface($CIDR, $vlan) {
		if (!isset($vlan) || !isset($CIDR)) return false;
		$base_interface = $this->base_interface;
		$r = 0;
		exec("ifconfig | grep $base_interface.$vlan", $r);
		if (count($r) != 1) return false;
		$r = 0;
		exec("ip addr add $CIDR dev $base_interface.$vlan", $r);
		if (count($r)) return false;
		return true;
	}

	public function set_arp($ip, $mac) {
		if (!isset($ip) || !isset($mac)) return false;
		$r = 0;
		exec("arp -s $ip $mac", $r);
		if (count($r)) return false;
		return true;
	}

	public function ping($ip) {
		if (!isset($ip)) return false;
		return ping($ip, 1, 3);
	}

	public function destroy_vlan_interface($vlan) {
		if (!isset($vlan)) return false;
		$base_interface = $this->base_interface;
		exec("vconfig rem $base_interface.$vlan", $r);
		if (preg_match('/ERROR/i', $r[0])) return false;
		return true;
	}
}
?>
