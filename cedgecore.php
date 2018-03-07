<?php

require_once('func.php');
require_once('consts.php');
require_once('cswitch.php');

class CEdgeCore extends CSwitch {

	public function make_ifindex_table() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = 0;
		$s = snmprealwalk($this->ip, $comm, $snmp_oids['ifName']);
		if (!$s) return false;
		$this->iftable = array();
		foreach ($s as $k => $v) {
			if (!preg_match('/\.([0-9]+)$/', $k, $m)) return false;
			$v = preg_replace('/Port(\d+)/', '1/$1', $v);
			$this->iftable[$v] = $m[1];
		}

		return true;
	}

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

	public function get_port_mac($mac, $vlan = 0) {
		if (!$mac) return false;
		$ifindex = parent::get_port_mac($mac, $vlan);
		if (!$ifindex) return false;
		return $this->get_ifname($ifindex);
	}


	//---------------------------------SNMP_CHECKS-------------------------------------

	protected function _snmp_get_iproute_default() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$r = 0;
		$r = snmprealwalk($this->ip, $comm, $snmp_oids['EdgeCore']['ipRouteDefault']);
		if (!$r) return false;

		foreach ($r as $ret) return $ret;

	}


}
?>
