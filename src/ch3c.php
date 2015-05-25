<?php

require_once('func.php');
require_once('consts.php');
require_once('ccisco.php');


class CH3C extends CCisco {

	public function get_self_mac() {
		if (!isset($this->iftable)) $this->make_ifindex_table();
		if (!isset($this->iftable)) return false;
		foreach ($this->iftable as $k => $v) {
			if (preg_match('/Vlan-interface/', $k))
				return ConvertMac($this->_snmp_get_phys_address($v));
		}

		return false;
	}

	public function get_multicast_inbound($port) {
		if (!$port) return false;
		$port = $this->get_ifindex($port);
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_multicast_inbound($port);
		return false;
	}

	public function get_multicast_outbound($port) {
		if (!$port) return false;
		$port = $this->get_ifindex($port);
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_multicast_outbound($port);
		return false;
	}

	public function get_broadcast_inbound($port) {
		if (!$port) return false;
		$port = $this->get_ifindex($port);
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_broadcast_inbound($port);
		return false;
	}

	public function get_broadcast_outbound($port) {
		if (!$port) return false;
		$port = $this->get_ifindex($port);
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_broadcast_outbound($port);
		return false;
	}

	//---------------------------------SNMP_CHECKS-------------------------------------

	protected function _snmp_get_iproute_default() {
		global $snmp_oids;
		$oid = $snmp_oids['H3COM']['ipRouteDefault'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_phys_address($ifindex) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifPhysAddress'].'.'.$ifindex);
	}
}

?>