<?php

require_once('func.php');
require_once('consts.php');


define('method_unknown',	0);
define('method_telnet',		1);
define('method_snmp_ro',	2);
define('method_snmp_rw',	4);
define('method_ssh',		8);
define('method_rrcp',		16);

class CNetDevice {
	protected $ip;
	protected $uplink_device;
	protected $uplink_port;
	protected $alive;
	protected $feature_list;
	public function __construct($aIp) { $this->ip = $aIp; $this->alive(); }
	public function alive() { if (ping($this->ip, 1, 3)) $this->alive = true; else $this->alive = false; return $this->alive; }
	public function get_ip() { return $this->ip; }
	public function feature_list() { global $consts; $features = &$consts['FEATURES']; return $features['GENERAL']['NetDevice']; }
	public function mgm_vlan() { return ManagmentVlanFromIP($this->ip); }
	public function check_interface_methods() { $this->interface_method = method_unknown; return $this->interface_method; }
	public function feature($feature) {
		if (!isset($feature)) return false;
		if (strstr($this->feature_list(), ':'.$feature.':')) return true;
		return false;
	}

}


class CSwitch extends CNetDevice {
	protected $interface_method;
	protected $snmp_ro_comm;
	protected $snmp_rw_comm;
	protected $snmp_ro_avail;
	protected $snmp_rw_avail;
	protected $telnet_avail;
	protected $ports;
	protected $model_name;
	protected $series;

	public function __construct($aIp, $vendor = '', $model = '') {
		global $consts;
		parent::__construct($aIp);
		$this->snmp_ro_comm = $consts['SNMP']['ROCOMM'];
		$this->snmp_rw_comm = $consts['SNMP']['RWCOMM'];
		$this->telnet = new telnet($aIp);
		$this->telnet->flag_ins_prompt=true;
		$this->telnet->ListListing=true;
		$this->telnet->setPrompt('/.+:.+#/', PROMPT_REGEXP);

		$this->snmp_ro_avail = false;
		$this->snmp_sw_avail = false;
		$this->telnet_avail = false;
		$this->interface_method = method_unknown;
		$this->ports = array();
		$this->model_name = $model;
		$this->vendor = $vendor;
	}

	public function get_model() {
		return $this->model_name;
	}

	public function feature_list() {
		global $consts;
		$features = &$consts['FEATURES'];
		$r = parent::feature_list();
		$r .= $features['GENERAL']['Switch'];
		if (isset($features['GENERAL'][$this->vendor])) $r .= $features['GENERAL'][$this->vendor];
		if ($this->snmp_ro_avail || $this->snmp_rw_avail) {
			$r .= $features['SNMPRO']['Switch'];
			if (isset($features['SNMPRO'][$this->vendor])) $r .= $features['SNMPRO'][$this->vendor];
		}
		if ($this->snmp_rw_avail) {
			if (isset($features['SNMPRW'][$this->vendor])) $r .= $features['SNMPRW'][$this->vendor];
		}
		return $r;
	}

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
			$this->iftable[$v] = $m[1];
		}
	}

	public function make_bridge_table() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = 0;
		$s = snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['MacBridgeEntry']);
		if (!$s) return false;
		$this->bridge_table = array();
		foreach ($s as $k => $v) {
			if (!preg_match('/\.([0-9]+)$/', $k, $m)) return false;
			$this->bridge_table[$m[1]] = $this->get_ifname($v);
		}
		return true;
	}

	public function get_ifname_by_bridge_index($bridge_index) {
		if (!isset($bridge_index)) return false;

		if (!isset($this->bridge_table)) $this->make_bridge_table();
		if (!isset($this->bridge_table)) return false;
		return $this->bridge_table[$bridge_index];
	}


	public function get_ifindex($ifname) {
		if (!isset($ifname)) return false;
		
		if (!isset($this->iftable)) $this->make_ifindex_table();
		if (!isset($this->iftable)) return false;
		return $this->iftable[$ifname];
	}

	public function get_ifname($index) {
		if (!isset($index)) return false;

		if (!isset($this->iftable)) $this->make_ifindex_table();
		if (!isset($this->iftable)) return false;

		foreach ($this->iftable as $ifName => $ifIndex)
			if ($ifIndex == $index) return $ifName;

		return false;
	}




	public function check_snmp_ro() {
		global $snmp_oids;
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
		if ($this->alive && snmpwalk($this->ip, $this->snmp_ro_comm, $snmp_oids['SysName'])) $this->snmp_ro_avail = true;
		else $this->snmp_ro_avail = false;
		error_reporting(E_ALL & ~E_NOTICE);
		return $this->snmp_ro_avail;
	}

	public function check_snmp_rw() {
		global $snmp_oids;
		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
		if ($this->alive && snmpwalk($this->ip, $this->snmp_rw_comm, $snmp_oids['SysName'])) $this->snmp_rw_avail = true;
		else $this->snmp_rw_avail = false;
		error_reporting(E_ALL & ~E_NOTICE);
		return $this->snmp_rw_avail;
	}

	public function check_telnet() {
		if (!$this->alive) $this->telnet_avail = false;
		if (!$this->telnet->keepAlive())
			$this->telnet_avail = $this->alive && $this->_telnet_reconnect();
		else $this->telnet_avail = true;
		return $this->telnet_avail;
	}


	public function check_interface_methods($try_telnet = false) {
		$this->interface_method = method_unknown;

		if ($this->check_snmp_ro()) $this->interface_method = $this->interface_method | method_snmp_ro;
		if ($this->check_snmp_rw()) $this->interface_method = $this->interface_method | method_snmp_rw;
		if ($try_telnet && $this->check_telnet()) $this->interface_method = $this->interface_method | method_telnet;

		return $this->interface_method;
	}

	public function set_interface_method($method = 2) {
		$this->interface_method = method_unknown;

		if ($method == method_snmp_ro)
			if ($this->check_snmp_ro()) $this->interface_method = $this->interface_method | method_snmp_ro;
		if ($method == method_snmp_rw)
			if ($this->check_snmp_rw()) $this->interface_method = $this->interface_method | method_snmp_rw;
		if ($method == method_telnet)
			if ($this->check_telnet()) $this->interface_method = $this->interface_method | method_telnet;


		return $this->interface_method;
	}

	public function get_name() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_sys_name();
		return false;
	}

	public function get_location() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_sys_location();
		return false;
	}

	public function get_contact() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_sys_contact();
		return false;
	}

	public function get_uptime() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_uptime();
		return false;
	}

	public function get_adm_status($port) {
		global $snmp_out;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $snmp_out['Switch']['AdmStatus'][$this->_snmp_get_adm_status($port)];
		return false;
	}

	public function get_oper_status($port) {
		global $snmp_out;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $snmp_out['Switch']['OperStatus'][$this->_snmp_get_oper_status($port)];
		return false;
	}

	public function get_oper_speed($port) {
		global $snmp_out;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $snmp_out['Switch']['Speed'][$this->_snmp_get_oper_speed($port)];
		return false;
	}

	public function get_description($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_description($port);
		return false;
	}

	public function get_errors($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_errors($port);
		return false;
	}

	public function get_discards($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_discards($port);
		return false;
	}

	public function get_bytes_inbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_bytes_inbound($port);
		return false;
	}

	public function get_bytes_outbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_bytes_outbound($port);
		return false;
	}

	public function get_nonunicast_inbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_nonunicast_inbound($port);
		return false;
	}

	public function get_nonunicast_outbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_nonunicast_outbound($port);
		return false;
	}

	public function get_multicast_inbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_multicast_inbound($port);
		return false;
	}

	public function get_multicast_outbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_multicast_outbound($port);
		return false;
	}

	public function get_broadcast_inbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_broadcast_inbound($port);
		return false;
	}

	public function get_broadcast_outbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_broadcast_outbound($port);
		return false;
	}

	public function get_unicast_inbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_unicast_inbound($port);
		return false;
	}

	public function get_unicast_outbound($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_counters_unicast_outbound($port);
		return false;
	}

	public function get_errors_crc($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_crc($port);
		return false;
	}

	public function get_errors_undersize($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_undersize($port);
		return false;
	}

	public function get_errors_oversize($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_oversize($port);
		return false;
	}

	public function get_errors_fragment($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_fragment($port);
		return false;
	}

	public function get_errors_jabber($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_jabber($port);
		return false;
	}

	public function get_errors_collision($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_collision($port);
		return false;
	}

	public function get_errors_single($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_single($port);
		return false;
	}

	public function get_errors_late($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_late($port);
		return false;
	}

	public function get_errors_excessive($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_errors_excessive($port);
		return false;
	}

	public function get_errors_advanced($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			//RETURN FORMAT (STRING): CRC/UNDERSIZE/OVERSIZE/FRAGMENT/JABBER
			$r = $this->_snmp_get_errors_crc($port).'/'.$this->_snmp_get_errors_undersize($port).'/';
			$r.= $this->_snmp_get_errors_oversize($port).'/'.$this->_snmp_get_errors_fragment($port).'/';
			$r.= $this->_snmp_get_errors_jabber($port);
			return $r;
		}			
		return false;
	}

	public function get_collisions($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			//RETURN FORMAT (STRING): COLLISION/SINGLE/LATE/EXCESSIVE
			$r = $this->_snmp_get_errors_collision($port).'/'.$this->_snmp_get_errors_single($port).'/';
			$r.= $this->_snmp_get_errors_late($port).'/'.$this->_snmp_get_errors_excessive($port);
			return $r;
		}			
		return false;
	}

	public function get_iproute_default() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_iproute_default();
		return false;
	}

	public function get_arp($ip) {
		if (!$ip) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_arp($ip);
		return false;
	}

	public function get_self_mac() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->get_arp($this->ip);
		return false;
	}

	public function check_model() {
		if (!isset($this->model_name)) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			if (strpos($this->_snmp_get_sys_descr(), $this->model_name) !== false) return true;
		return false;
	}


	public function get_port_pvid($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_gvrp_port_pvid($port);
		return false;
	}

	public function get_lldp_remo_chassis($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			if (!isset($this->ports['LLDP']['LocalPorts']) && !$this->_snmp_get_lldp_local_ports()) return false;
			$port_num = $this->ports['LLDP']['LocalPorts'][$port];
			if (!isset($this->ports['LLDP']['Chassis'])) $this->_snmp_get_lldp_chassis();
			if (isset($this->ports['LLDP']['Chassis'][$port_num])) return $this->ports['LLDP']['Chassis'][$port_num];
		}

		return false;
	}

	public function get_lldp_remo_port($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			if (!isset($this->ports['LLDP']['LocalPorts']) && !$this->_snmp_get_lldp_local_ports()) return false;
			$port_num = $this->ports['LLDP']['LocalPorts'][$port];
			if (!isset($this->ports['LLDP']['Ports'])) $this->_snmp_get_lldp_ports();
			if (isset($this->ports['LLDP']['Ports'][$port_num])) return $this->ports['LLDP']['Ports'][$port_num];
		}

		return false;
	}

	public function get_lldp_remo_sysname($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			if (!isset($this->ports['LLDP']['SysNames']) && !$this->_snmp_get_lldp_local_ports()) return false;
			$port_num = $this->ports['LLDP']['LocalPorts'][$port];
			if (!isset($this->ports['LLDP']['SysNames'])) $this->_snmp_get_lldp_sysname();
			if (isset($this->ports['LLDP']['SysNames'][$port_num])) return $this->ports['LLDP']['SysNames'][$port_num];
		}

		return false;
	}

	public function get_port_mac($mac, $vlan = 0) {
		if (!$mac) return false;
		if (!$vlan) $vlan = $this->mgm_vlan();
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_port_of_mac_vlan($mac, $vlan);
	}

	public function get_port_macs($port, $with_multicast_vlan = false) {
		if (!isset($port)) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$vlans = $this->get_port_vlans($port);
			$mac_table_full = array();
			foreach ($vlans as $vlan => $type) {
				$t = $this->get_vlan_macs($vlan);
				if (!isset($t[$vlan])) continue;
				$mac_table_full[$vlan] = $t[$vlan];
			}
			$r = array();
			foreach ($mac_table_full as $vlan => $macs_table) {
				if ($vlan == 998 && !$with_multicast_vlan) continue;
				foreach ($macs_table as $mac => $mac_port)
					if ($mac_port == $port) $r[$vlan][] = $mac;
			}
			return $r;
		}


		return false;
	}

	public function get_vlan_macs($vlan) {
		if (!isset($vlan)) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_mac_table($vlan);

		return false;
	}

	public function fill_mac_table() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$t = $this->_snmp_get_mac_table();
			if (!$t) return false;
			$this->mac_table = $t;
			return true;
		}

	return false;
	}

	public function fill_vlan_table() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$t = $this->_snmp_get_vlan_table();
			if (!$t) return false;
			$this->vlan_table = $t;
			return true;
		}
		return false;
	}

	public function get_port_vlans($port, $get_all = false) {
		if (!$port) return false;
		if (!isset($this->vlan_table)) $this->fill_vlan_table();
		if (!isset($this->vlan_table)) return false;

		$r = array();
		foreach ($this->vlan_table as $vlan => $port_list)
			if ($port_list[$port] || $get_all) $r[$vlan] = $port_list[$port];
		return $r;
	}

	public function uplink() {
		return $this->get_port_mac($this->get_arp($this->get_iproute_default()));
	}



	//---------------------------------SNMP_CHECKS-------------------------------------

	protected function _snmp_get_sys_name() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['SysName'].'.0');

	}

	protected function _snmp_get_sys_location() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['SysLocation'].'.0');

	}

	protected function _snmp_get_sys_contact() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['SysContact'].'.0');

	}

	protected function _snmp_get_uptime() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['SysUptime']);

	}

	protected function _snmp_get_adm_status($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$r = snmpget($this->ip, $comm, $snmp_oids['ifAdminStatus'].'.'.$port);
		if ($r == 'up' || $r == '1') return true; else return false;
	}

	protected function _snmp_get_oper_status($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$r = snmpget($this->ip, $comm, $snmp_oids['ifOperStatus'].'.'.$port);
		if ($r == 'up' || $r == '1') return true; else return false;
	}

	protected function _snmp_get_oper_speed($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifSpeed'].'.'.$port);
	}

	protected function _snmp_get_description($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifAlias'].'.'.$port);
	}

	protected function _snmp_get_counters_errors($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifInErrors'].'.'.$port);
	}

	protected function _snmp_get_counters_discards($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifInDiscards'].'.'.$port);
	}

	protected function _snmp_get_counters_bytes_inbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmp2_get($this->ip, $comm, $snmp_oids['ifHCInOctets'].'.'.$port);
	}

	protected function _snmp_get_counters_bytes_outbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmp2_get($this->ip, $comm, $snmp_oids['ifHCOutOctets'].'.'.$port);
	}

	protected function _snmp_get_counters_nonunicast_inbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifInNUcastPkts'].'.'.$port);
	}

	protected function _snmp_get_counters_nonunicast_outbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifOutNUcastPkts'].'.'.$port);
	}

	protected function _snmp_get_counters_multicast_inbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifInMulticastPkts'].'.'.$port);
	}

	protected function _snmp_get_counters_multicast_outbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifOutMulticastPkts'].'.'.$port);
	}

	protected function _snmp_get_counters_broadcast_inbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifInBroadcastPkts'].'.'.$port);
	}

	protected function _snmp_get_counters_broadcast_outbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifOutBroadcastPkts'].'.'.$port);
	}

	protected function _snmp_get_counters_unicast_inbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifInUcastPkts'].'.'.$port);
	}

	protected function _snmp_get_counters_unicast_outbound($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifOutUcastPkts'].'.'.$port);
	}

	protected function _snmp_get_phys_address($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['ifPhysAddress'].'.'.$port);
	}

	protected function _snmp_get_gvrp_port_pvid($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['GVRP'].'.1.'.$port);
	}

	protected function _snmp_get_gvrp_port_ingress_filtering($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['GVRP'].'.3.'.$port);
	}

	protected function _snmp_get_errors_crc($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['CRCErr'].'.'.$port);
	}

	protected function _snmp_get_errors_undersize($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['Undersize'].'.'.$port);
	}

	protected function _snmp_get_errors_oversize($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['Oversize'].'.'.$port);
	}

	protected function _snmp_get_errors_fragment($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['Fragment'].'.'.$port);
	}

	protected function _snmp_get_errors_jabber($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['Jabber'].'.'.$port);
	}

	protected function _snmp_get_errors_collision($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['Collision'].'.'.$port);
	}

	protected function _snmp_get_errors_single($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['CollSingle'].'.'.$port);
	}

	protected function _snmp_get_errors_late($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['CollLate'].'.'.$port);
	}

	protected function _snmp_get_errors_excessive($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['CollExcessive'].'.'.$port);
	}

	protected function _snmp_get_errors_drops($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['RMON']['Drops'].'.'.$port);
	}

	protected function _snmp_get_iproute_default() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		return snmpget($this->ip, $comm, $snmp_oids['ipRouteDefault']);
	}

	protected function _snmp_get_arp($ip) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$r = snmprealwalk($this->ip, $comm, $snmp_oids['ipArp']);
		foreach ($r as $k => $v) {
			if (preg_match("/$ip$/", $k)) { return ConvertMac($v); }
		}

		return false;
	}

	protected function _snmp_get_port_of_mac_vlan($mac, $vlan) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$snmp_mac = ConvertMac($mac, 2);
		return snmpget($this->ip, $comm, $snmp_oids['dot1qMacList'].'.'.$vlan.'.'.$snmp_mac);
	}

	protected function _snmp_get_mac_table($vlan = 0) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		if ($vlan) $r = snmprealwalk($this->ip, $comm, $snmp_oids['dot1qMacList'].'.'.$vlan);
		else $r = snmprealwalk($this->ip, $comm, $snmp_oids['dot1qMacList']);
		$mac_table = array();
		foreach ($r as $k => $v) {
			if (!preg_match('/(\d+)\.(\d+\.\d+\.\d+\.\d+\.\d+\.\d+)$/', $k, $m)) return false;
			$vlan = $m[1];
			$mac = $m[2];

			$mac_table[$vlan][ConvertMac($mac, 0, 1, '\.', 1)] = $v;
		}
		return $mac_table;
	}


	protected function _snmp_get_sys_descr() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['SysDescr'].'.0');
	}


	protected function _snmp_get_gvrp_state($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $snmp_oids['GVRP'].'.4.'.$port);
	}

	public function _snmp_get_lldp_local_ports() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = 0;
		$s = snmprealwalk($this->ip, $comm, $snmp_oids['LLDP']['LocalData'].'.3');
		if (!$s) return false;
		$this->ports['LLDP']['LocalPorts'] = 0;
		$this->ports['LLDP']['LocalPorts'] = array();

		foreach ($s as $k => $v) {
			$matches = 0;
			preg_match('/\.([0-9]+)$/', $k, $matches);
			if (count($matches) == 2) {
				$port_id = $matches[1];
				$port_name = str_replace('"', '', $v);
				$this->ports['LLDP']['LocalPorts'][$port_name] = (integer)$port_id;
			}
		}
		return true;
	}

	protected function _snmp_get_lldp_chassis() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = 0;
		$s = snmprealwalk($this->ip, $comm, $snmp_oids['LLDP']['RemoteData'].'.5');
		if (!$s) return false;
		$this->ports['LLDP']['Chassis'] = 0;
		$this->ports['LLDP']['Chassis'] = array();

		foreach ($s as $k => $v) {
			$matches = 0;
			preg_match('/[0-9]+\.([0-9]+)\.[0-9]+$/', $k, $matches);
			if (count($matches) == 2) {
				$port = $matches[1];
				$mac = ConvertMac(str_replace('"', '', $v), 0, true, ' ');
				$this->ports['LLDP']['Chassis'][$port] = $mac;
			}
		}
		return true;
	}

	protected function _snmp_get_lldp_ports() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = 0;
		snmp_set_quick_print(0);
		$s = snmprealwalk($this->ip, $comm, $snmp_oids['LLDP']['RemoteData'].'.7');
		snmp_set_quick_print(1);

		if (!$s) return false;
		$this->ports['LLDP']['Ports'] = 0;
		$this->ports['LLDP']['Ports'] = array();

		foreach ($s as $k => $v) {
			$matches = 0;
			preg_match('/[0-9]+\.([0-9]+)\.[0-9]+$/', $k, $matches);
			if (count($matches) == 2) {
				$port = $matches[1];
				if (substr_count($v, 'Hex-STRING:') > 0) {
					$v_hex = explode(' ', trim(str_replace('Hex-STRING:', '', $v)));
					$v = '';
					foreach ($v_hex as $hex_v) {
						$v .= chr(hexdec($hex_v));
					}
				} else $v = str_replace('STRING: ', '', $v);

				$this->ports['LLDP']['Ports'][$port] = str_replace('"', '', $v);
			}
		}
		return true;
	}

	protected function _snmp_get_lldp_sysname() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = 0;
		$s = snmprealwalk($this->ip, $comm, $snmp_oids['LLDP']['RemoteData'].'.9');

		if (!$s) return false;
		$this->ports['LLDP']['SysNames'] = 0;
		$this->ports['LLDP']['SysNames'] = array();

		foreach ($s as $k => $v) {
			$matches = 0;
			preg_match('/[0-9]+\.([0-9]+)\.[0-9]+$/', $k, $matches);
			if (count($matches) == 2) {
				$port = $matches[1];
				$this->ports['LLDP']['SysNames'][$port] = str_replace('"', '', $v);
			}
		}

		return true;
	}

	protected function _snmp_get_vlan_table() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$egress = snmprealwalk($this->ip, $comm, $snmp_oids['dot1qVlanStaticTable'].'.2');
		$ugress = snmprealwalk($this->ip, $comm, $snmp_oids['dot1qVlanStaticTable'].'.4');
		if (!$egress || !$ugress) return false;
		$vlan_table = array();

		foreach ($egress as $k => $v) {
			if (!preg_match('/(\d+)$/', $k, $m)) return false;
			$vlan = $m[1];
			$v = trim($v, '"');
			$vlan_port_table = trim($v, ' ');
			$per8_ports = explode(' ', $vlan_port_table);
			for ($i = 0; $i < count($per8_ports); $i++) {
				$per8_ports[$i] = hexdec($per8_ports[$i]);
				for ($j = 0; $j < 8; $j++) {
					$offset = 1 << (7 - $j);
					$port_num = $i * 8 + $j + 1;
					if ($per8_ports[$i] & $offset) $vlan_table[$vlan][$port_num] = 1;
					else $vlan_table[$vlan][$port_num] = 0;
				}
			}
		}

		foreach ($ugress as $k => $v) {
			if (!preg_match('/(\d+)$/', $k, $m)) return false;
			$vlan = $m[1];
			$v = trim($v, '"');
			$vlan_port_table = trim($v, ' ');
			$per8_ports = explode(' ', $vlan_port_table);
			for ($i = 0; $i < count($per8_ports); $i++) {
				$per8_ports[$i] = hexdec($per8_ports[$i]);
				for ($j = 0; $j < 8; $j++) {
					$offset = 1 << (7 - $j);
					$port_num = $i * 8 + $j + 1;
					if ($per8_ports[$i] & $offset) $vlan_table[$vlan][$port_num] = 2;
				}
			}
		}
		return $vlan_table;
	}

	//---------------------------------TELNET_CHECKS-------------------------------------

	protected function _telnet_reconnect() {
		$this->telnet->disconnect();
		if (!$this->telnet->connect($this->ip)) return false;
		if (!AuthMe($this->telnet)) return false;
		return true;
	}

}

?>
