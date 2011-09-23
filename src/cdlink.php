<?php

require_once('func.php');
require_once('consts.php');
require_once('cswitch.php');

class CDlink extends CSwitch {
	protected $fwver1;

	protected $snmp_prefix;

	public function feature_list() {
		global $consts;
		$features = &$consts['FEATURES'];
		$r = parent::feature_list();

		if ($this->snmp_ro_avail || $this->snmp_rw_avail) $r = $features['SNMPRO']['DLink'].$r;

		//series-specific
		if (isset($features['GENERAL'][$this->series])) $r = $features['GENERAL'][$this->series].$r;
		if (isset($features['SNMPRO'][$this->series]) && ($this->snmp_ro_avail || $this->snmp_rw_avail))
			$r = $features['SNMPRO'][$this->series].$r;
		if (isset($features['SNMPRW'][$this->series]) && $this->snmp_rw_avail)
			$r = $features['SNMPRW'][$this->series].$r;
		if (isset($features['TELNET'][$this->series]) && $this->snmp_rw_avail)
			$r = $features['TELNET'][$this->series].$r;


		return $r;
	}

	public function __construct($aIp, $series = null, $model = null) {
		parent::__construct($aIp);
		$this->model_name = $model;
		$this->series = $series;
		$this->make_prefix($series, $model);
	}

	protected function make_prefix($series, $model) {
		global $snmp_oids;
		if ($series == null || $model == null) return false;

		$this->snmp_prefix = $snmp_oids['DLink']['ID'].$snmp_oids['DLink']['Series'][$series].$snmp_oids['DLink']['Models'][$model];
		return $this->snmp_prefix;
	}

	public function get_drops($port) {
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return _snmp_get_errors_drops($port);
		return false;
	}

	public function port_cable_diag_avail($port) {
		global $consts;
		if (!$port) return false;
		if (!$this->feature('cdiag')) return false;
		$hw = &$consts['HARDWARE']['SWITCH'];
		$cooper_map = $hw['DLINK']['COOPER'][$this->model_name];
		$cooper_avail = $cooper_map & (1 << ($port-1));
		if (!$cooper_avail) return false;
		$cdiag_map = $hw['CDIAG'][$this->model_name];
		$cdiag_avail = $cdiag_map & (1 << ($port-1));
		return $cdiag_avail;
	}

	public function cable_diag($port) {
		if (!$port) return false;
		if ($this->interface_method & method_snmp_rw)
			return $this->_snmp_cable_diag($port);
		return false;
	}

	public function get_lbd_state() {
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['LBD']['GlobalState'])) $out = &$snmp_out['DLink']['LBD']['GlobalState'];
		else $out = &$snmp_out[$this->series]['LBD']['GlobalState'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_lbd_global_state()];
		return false;
	}

	public function get_lbd_interval() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_lbd_interval($port);
		return false;
	}

	public function get_lbd_recover() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_lbd_recover($port);
		return false;
	}

	public function get_lbd_port_adm_state($port) {
		global $snmp_out;

		if (!$port) return false;

		if (!isset($snmp_out[$this->series]['LBD']['PortAdmState'])) $out = &$snmp_out['DLink']['LBD']['PortAdmState'];
		else $out = &$snmp_out[$this->series]['LBD']['PortAdmState'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_lbd_port_adm_state($port)];

		return false;
	}

	public function get_lbd_port_status($port) {
		global $snmp_out;

		if (!$port) return false;

		if (!isset($snmp_out[$this->series]['LBD']['PortStatus'])) $out = &$snmp_out['DLink']['LBD']['PortStatus'];
		else $out = &$snmp_out[$this->series]['LBD']['PortStatus'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_lbd_port_status($port)];

		return false;
	}


	public function get_port_adm_state($port, $type = 2) {
		global $consts;
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['PortInfo']['State'])) $out = &$snmp_out['DLink']['PortInfo']['State'];
		else $out = &$snmp_out[$this->series]['PortInfo']['State'];

		if ($type == 0 || $type == 2) $use_cooper = 1;
		if ($type == 1 || $type == 2) $use_fiber = 1;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$hw = &$consts['HARDWARE']['SWITCH']['DLINK'];
			$cooper_map = $hw['COOPER'][$this->model_name];
			$cooper_avail = $cooper_map & (1 << ($port-1));
			$fiber_map = $hw['FIBER'][$this->model_name];
			$fiber_avail = $fiber_map & (1 << ($port-1));

			if (!$fiber_avail && !$cooper_avail) return false;
			if (isset($use_cooper) && $cooper_avail)
				$r['cooper'] = $out[$this->_snmp_port_adm_state($port, 0)];
			if (isset($use_fiber) && $fiber_avail)
				$r['fiber'] = $out[$this->_snmp_port_adm_state($port, 1)];

			return $r;
		}
		return false;
	}

	public function get_port_adm_speed($port, $type = 2) {
		global $consts;
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['PortInfo']['AdmSpeed'])) $out = &$snmp_out['DLink']['PortInfo']['AdmSpeed'];
		else $out = &$snmp_out[$this->series]['PortInfo']['AdmSpeed'];

		if ($type == 0 || $type == 2) $use_cooper = 1;
		if ($type == 1 || $type == 2) $use_fiber = 1;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$hw = &$consts['HARDWARE']['SWITCH']['DLINK'];
			$cooper_map = $hw['COOPER'][$this->model_name];
			$cooper_avail = $cooper_map & (1 << ($port-1));
			$fiber_map = $hw['FIBER'][$this->model_name];
			$fiber_avail = $fiber_map & (1 << ($port-1));

			if (!$fiber_avail && !$cooper_avail) return false;
			if (isset($use_cooper) && $cooper_avail)
				$r['cooper'] = $out[$this->_snmp_port_adm_speed($port, 0)];
			if (isset($use_fiber) && $fiber_avail)
				$r['fiber'] = $out[$this->_snmp_port_adm_speed($port, 1)];
			return $r;
		}
		return false;
	}

	public function get_port_status($port, $type = 2) {
		global $consts;
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['PortInfo']['Status'])) $out = &$snmp_out['DLink']['PortInfo']['Status'];
		else $out = &$snmp_out[$this->series]['PortInfo']['Status'];

		if ($type == 0 || $type == 2) $use_cooper = 1;
		if ($type == 1 || $type == 2) $use_fiber = 1;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$hw = &$consts['HARDWARE']['SWITCH']['DLINK'];
			$cooper_map = $hw['COOPER'][$this->model_name];
			$cooper_avail = $cooper_map & (1 << ($port-1));
			$fiber_map = $hw['FIBER'][$this->model_name];
			$fiber_avail = $fiber_map & (1 << ($port-1));

			if (!$fiber_avail && !$cooper_avail) return false;
			if (isset($use_cooper) && $cooper_avail)
				$r['cooper'] = $out[$this->_snmp_port_status($port, 0)];
			if (isset($use_fiber) && $fiber_avail)
				$r['fiber'] = $out[$this->_snmp_port_status($port, 1)];
			return $r;
		}
		return false;
	}

	public function get_port_speed($port, $type = 2) {
		global $consts;
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['PortInfo']['Speed'])) $out = &$snmp_out['DLink']['PortInfo']['Speed'];
		else $out = &$snmp_out[$this->series]['PortInfo']['Speed'];

		if ($type == 0 || $type == 2) $use_cooper = 1;
		if ($type == 1 || $type == 2) $use_fiber = 1;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$hw = &$consts['HARDWARE']['SWITCH']['DLINK'];
			$cooper_map = $hw['COOPER'][$this->model_name];

			$cooper_avail = $cooper_map & (1 << ($port-1));
			$fiber_map = $hw['FIBER'][$this->model_name];
			$fiber_avail = $fiber_map & (1 << ($port-1));

			if (!$fiber_avail && !$cooper_avail) return false;
			if (isset($use_cooper) && $cooper_avail)
				$r['cooper'] = $out[$this->_snmp_port_speed($port, 0)];
			if (isset($use_fiber) && $fiber_avail)
				$r['fiber'] = $out[$this->_snmp_port_speed($port, 1)];
			return $r;
		}
		return false;
	}

	public function get_stp_state() {
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['STP']['State'])) $out = &$snmp_out['DLink']['STP']['State'];
		else $out = &$snmp_out[$this->series]['STP']['State'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_stp_state()];

		return false;
	}

	public function get_stp_version() {
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['STP']['Version'])) $out = &$snmp_out['DLink']['STP']['Version'];
		else $out = &$snmp_out[$this->series]['STP']['Version'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_stp_version()];

		return false;
	}

	public function get_stp_fbpdu() {
		global $snmp_out;

		if (!isset($snmp_out[$this->series]['STP']['FBPDU'])) $out = &$snmp_out['DLink']['STP']['FBPDU'];
		else $out = &$snmp_out[$this->series]['STP']['FBPDU'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_stp_fbpdu()];

		return false;
	}

	public function get_stp_root_port($instance = 0) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_stp_root_port($instance);

		return false;
	}

	public function get_stp_last_topology_change($instance = 0) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_stp_last_topology_change($instance);

		return false;
	}

	public function get_stp_topology_changes_count($instance = 0) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_stp_topology_change_count($instance);

		return false;
	}

	public function get_stp_priority($instance = 0) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_stp_priority($instance);

		return false;
	}

	public function get_stp_port_restricted_tcn($port) {
		global $snmp_out;

		if (!$port) return false;
		if (!isset($snmp_out[$this->series]['STP']['RestrictedTCN'])) $out = &$snmp_out['DLink']['STP']['RestrictedTCN'];
		else $out = &$snmp_out[$this->series]['STP']['RestrictedTCN'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_port_restricted_tcn($port)];

		return false;
	}

	public function get_stp_port_restricted_role($port) {
		global $snmp_out;

		if (!$port) return false;
		if (!isset($snmp_out[$this->series]['STP']['RestrictedRole'])) $out = &$snmp_out['DLink']['STP']['RestrictedRole'];
		else $out = &$snmp_out[$this->series]['STP']['RestrictedRole'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_port_restricted_tcn($port)];

		return false;
	}

	public function get_stp_adm_edge($port) {
		global $snmp_out;

		if (!$port) return false;
		if (!isset($snmp_out[$this->series]['STP']['AdminEdge'])) $out = &$snmp_out['DLink']['STP']['AdminEdge'];
		else $out = &$snmp_out[$this->series]['STP']['AdminEdge'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_stp_adm_edge($port)];

		return false;
	}

	public function get_stp_edge($port) {
		global $snmp_out;

		if (!$port) return false;
		if (!isset($snmp_out[$this->series]['STP']['Edge'])) $out = &$snmp_out['DLink']['STP']['Edge'];
		else $out = &$snmp_out[$this->series]['STP']['Edge'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_stp_edge($port)];

		return false;
	}

	public function get_stp_port_fbpdu($port) {
		global $snmp_out;

		if (!$port) return false;
		if (!isset($snmp_out[$this->series]['STP']['PortFBPDU'])) $out = &$snmp_out['DLink']['STP']['PortFBPDU'];
		else $out = &$snmp_out[$this->series]['STP']['PortFBPDU'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_port_fbpdu($port)];

		return false;
	}

	public function get_stp_port_role($port, $instance = 0) {
		global $snmp_out;

		if (!$port) return false;
		if (!isset($snmp_out[$this->series]['STP']['PortRole'])) $out = &$snmp_out['DLink']['STP']['PortRole'];
		else $out = &$snmp_out[$this->series]['STP']['PortRole'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_port_role($port, $instance)];

		return false;
	}

	public function get_stp_port_status($port, $instance = 0) {
		global $snmp_out;

		if (!$port) return false;
		if (!isset($snmp_out[$this->series]['STP']['PortStatus'])) $out = &$snmp_out['DLink']['STP']['PortStatus'];
		else $out = &$snmp_out[$this->series]['STP']['PortStatus'];

		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $out[$this->_snmp_get_port_status($port, $instance)];

		return false;
	}

	public function save() {
		if ($this->interface_method & method_snmp_rw)
			return $this->_snmp_save();

		return false;
	}

	public function reboot() {
		if ($this->interface_method & method_snmp_rw)
			if (!$this->_snmp_reboot()) return false;
		for ($i = 1; $i < 300; $i++) {
			sleep(1);
			if ($this->alive()) return true;
		}
		$this->interface_method = method_unknown;
		return false;
	}

	public function download_fw($filename, $tftp = '') {
		/*if ($this->interface_method & method_snmp_rw)
			return $this->_snmp_download_fw($filename, $tftp, $id);*/
		if (!isset($filename)) return false;
		global $consts;
		if (!$tftp) $tftp = $consts['TFTP']['IP'];
		if ($this->interface_method & method_telnet)
			return $this->_telnet_download_fw($filename, $tftp);

		return false;
	}

	public function get_fw_ver() {
		$f = false;
		if (!isset($this->fwver1)) $f = $this->check_fw_ver();
		else $f = true;
		if (!$f)  return false;
		return $this->fwver1;
	}

	public function check_fw_ver() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_fwver();
		return false;
	}

	public function check_fw() {
		global $consts;
		if (!isset($consts['FIRMWARE'][$this->series])) return true;
		if ($this->get_fw_ver() == $consts['FIRMWARE'][$this->series]) return true;
		return false;
	}

	public function update() {
		global $consts;
		if (!isset($consts['TFTP']['FIRMWARE'][$this->series])) return false;

		if (!$this->download_fw($consts['TFTP']['FIRMWARE'][$this->series])) return false;
		if (!$this->reboot()) return false;
		return true;
	}

	public function create_vlan($vid, $vname = false) {
		if (!isset($vid)) return false;
		if ($this->interface_method & method_telnet)
			return $this->_telnet_create_vlan($vid, $vname);

		return false;
	}

	public function delete_vlan($vid) {
		if (!isset($vid)) return false;
		if ($this->interface_method & method_telnet)
			return $this->_telnet_delete_vlan($vid);

		return false;
	}

	public function add_vlan_to_port($vid, $portlist, $type = 0) {
		if (!isset($vid) || !isset($portlist)) return false;
		if ($this->interface_method & method_telnet)
			return $this->_telnet_add_vlan_to_port($vid, $portlist, $type);

		return false;
	}

	public function delete_vlan_from_port($vid, $portlist) {
		if (!isset($vid) || !isset($portlist)) return false;
		if ($this->interface_method & method_telnet)
			return $this->_telnet_delete_vlan_from_port($vid, $portlist);

		return false;
	}

	public function create_default($default_route) {
		if (!isset($default_route)) return false;
		if ($this->interface_method & method_telnet)
			return $this->_telnet_create_iproute_default($default_route);

		return false;
	}

	public function config_system_ipif($CIDR, $vid) {
		if (!isset($CIDR) || !isset($vid)) return false;
		if ($this->interface_method & method_telnet) {
			$ipif_changed = $this->_telnet_config_system_ipif($CIDR, $vid);
			if (!$ipif_changed) return false;
			$new_ip = explode('/', $CIDR);
			$new_ip = $new_ip[0];
			$this->ip = $new_ip;
			$this->telnet = new telnet($new_ip);
			$this->telnet->flag_ins_prompt=true;
			$this->telnet->ListListing=true;
			$this->telnet->setPrompt('/.+:.+#/', PROMPT_REGEXP);
			if (!$this->alive()) $this->interface_method = method_unknown;
			return $this->alive;
		}

		return false;
	}

	public function add_snmp_ro() {
		if ($this->interface_method & method_telnet)
			return $this->_telnet_add_snmp_ro();

		return false;
	}

	public function add_snmp_rw() {
		if ($this->interface_method & method_telnet)
			return $this->_telnet_add_snmp_rw();

		return false;
	}

	public function add_snmp() {
		return $this->add_snmp_ro() && $this->add_snmp_rw();
	}




	//---------------------------------SNMP_CHECKS-------------------------------------

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
		if (count($matches) == 2) $this->fwver1 = $matches[1];
		else $this->fwver1 = $r;

		return true;
	}

	protected function _snmp_cable_diag($port) {
		global $snmp_oids;
		global $snmp_out;

		if ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$cdiag_ready = false;
		if (!snmpset($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.12.'.$port, 'i', '1')) return false;
		for ($i = 1; $i < 50; $i++) {
			$processing = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.12.'.$port);
			if ($processing ==  2) { usleep(50000); continue; } else { $cdiag_ready =  true; break; }

		}
		if (!$cdiag_ready) return false;

		$cableDiagPortType = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.2.'.$port);

		if (!isset($cableDiagPortType) || ($cableDiagPortType != 0 && $cableDiagPortType != 1)) return false;

		$cableDiagLinkStatus  = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.3.'.$port);

		$cableDiagPair1Status = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.4.'.$port);
		$cableDiagPair2Status = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.5.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair3Status = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.6.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair4Status = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.7.'.$port);

		$cableDiagPair1Length = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.8.'.$port);
		$cableDiagPair2Length = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.9.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair3Length = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.10.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair4Length = snmpget($this->ip, $comm, $snmp_oids['DLink']['CableDiag'].'.11.'.$port);

		if ($cableDiagPair1Status != 7) $cP1S = $snmp_out['DLink']['CableDiag'][$cableDiagPair1Status];
		if ($cableDiagPair2Status != 7) $cP2S = $snmp_out['DLink']['CableDiag'][$cableDiagPair2Status];
		if ($cableDiagPortType == 1 && $cableDiagPair3Status != 7) $cP3S = $snmp_out['DLink']['CableDiag'][$cableDiagPair3Status];
		if ($cableDiagPortType == 1 && $cableDiagPair4Status != 7) $cP4S = $snmp_out['DLink']['CableDiag'][$cableDiagPair4Status];


		if (isset($cP1S)) $cDiagRes  = ' Pair 1 '.$cP1S.' at '.$cableDiagPair1Length;
		if (isset($cP2S)) $cDiagRes .= ' Pair 2 '.$cP2S.' at '.$cableDiagPair2Length;
		if (isset($cP3S)) $cDiagRes .= ' Pair 3 '.$cP3S.' at '.$cableDiagPair3Length;
		if (isset($cP4S)) $cDiagRes .= ' Pair 4 '.$cP4S.' at '.$cableDiagPair4Length;

		if ($cableDiagLinkStatus == 0 && $cableDiagPair1Status == 0 && $cableDiagPair2Status == 0) $cDiagRes = 'OK';
		if ($cableDiagLinkStatus == 1 &&
			$cableDiagPair1Status == 0 &&
			$cableDiagPair2Status == 0) $cDiagRes = 'OK, Cable Length: '.$cableDiagPair1Length;
		if ($cDiagRes == '') $cDiagRes = 'No Cable';

		return $cDiagRes;
	}

	protected function _snmp_lbd_global_state() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['LBD']['GlobalState'])) $oid = &$snmp_oids['DLink']['LBD']['GlobalState'];
		else $oid = &$snmp_oids[$this->series]['LBD']['GlobalState'];


		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid);
	}

	protected function _snmp_lbd_interval() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['LBD']['Interval'])) $oid = &$snmp_oids['DLink']['LBD']['Interval'];
		else $oid = &$snmp_oids[$this->series]['LBD']['Interval'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid);
	}

	protected function _snmp_lbd_recover() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['LBD']['Recover'])) $oid = &$snmp_oids['DLink']['LBD']['Recover'];
		else $oid = &$snmp_oids[$this->series]['LBD']['Recover'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid);
	}

	protected function _snmp_lbd_port_adm_state($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['LBD']['PortAdmState'])) $oid = &$snmp_oids['DLink']['LBD']['PortAdmState'];
		else $oid = &$snmp_oids[$this->series]['LBD']['PortAdmState'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_lbd_port_status($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['LBD']['PortStatus'])) $oid = &$snmp_oids['DLink']['LBD']['PortStatus'];
		else $oid = &$snmp_oids[$this->series]['LBD']['PortStatus'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_port_adm_state($port, $type) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['AdmState'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_adm_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['AdmSpeed'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_adm_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['AdmFlowCtrl'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_description($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['Description'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_learning($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['Learning'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_status($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['Status'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['Speed'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 100; else $type = 101; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DLink']['PortInfo']['FlowCtrl'].'.'.$port.'.'.$type);
	}

	protected function _snmp_get_iproute_default() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['ipRouteDefault'])) $oid = &$snmp_oids['DLink']['ipRouteDefault'];
		else $oid = &$snmp_oids[$this->series]['ipRouteDefault'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_state() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['State'])) $oid = &$snmp_oids['DLink']['STP']['State'];
		else $oid = &$snmp_oids[$this->series]['STP']['State'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}


	protected function _snmp_get_stp_version() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['Version'])) $oid = &$snmp_oids['DLink']['STP']['Version'];
		else $oid = &$snmp_oids[$this->series]['STP']['Version'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_global_max_age() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['GlobalMaxAge'])) $oid = &$snmp_oids['DLink']['STP']['GlobalMaxAge'];
		else $oid = &$snmp_oids[$this->series]['STP']['GlobalMaxAge'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_global_hello_time() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['GlobalHelloTime'])) $oid = &$snmp_oids['DLink']['STP']['GlobalHelloTime'];
		else $oid = &$snmp_oids[$this->series]['STP']['GlobalHelloTime'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_global_forward_delay() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['GlobalForwardDelay'])) $oid = &$snmp_oids['DLink']['STP']['GlobalForwardDelay'];
		else $oid = &$snmp_oids[$this->series]['STP']['GlobalForwardDelay'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_max_hops() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['MaxHops'])) $oid = &$snmp_oids['DLink']['STP']['MaxHops'];
		else $oid = &$snmp_oids[$this->series]['STP']['MaxHops'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_maxhops() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['HoldCount'])) $oid = &$snmp_oids['DLink']['STP']['HoldCount'];
		else $oid = &$snmp_oids[$this->series]['STP']['HoldCount'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_fbpdu() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['FBPDU'])) $oid = &$snmp_oids['DLink']['STP']['FBPDU'];
		else $oid = &$snmp_oids[$this->series]['STP']['FBPDU'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_lbd() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['LBD'])) $oid = &$snmp_oids['DLink']['STP']['LBD'];
		else $oid = &$snmp_oids[$this->series]['STP']['LBD'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_lbd_recover() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['LBDRecover'])) $oid = &$snmp_oids['DLink']['STP']['LBDRecover'];
		else $oid = &$snmp_oids[$this->series]['STP']['LBDRecover'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_get_stp_priority($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['Priority'])) $oid = &$snmp_oids['DLink']['STP']['Priority'];
		else $oid = &$snmp_oids[$this->series]['STP']['Priority'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_designated_root($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['DesignatedRoot'])) $oid = &$snmp_oids['DLink']['STP']['DesignatedRoot'];
		else $oid = &$snmp_oids[$this->series]['STP']['DesignatedRoot'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_regional_root($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RegionalRoot'])) $oid = &$snmp_oids['DLink']['STP']['RegionalRoot'];
		else $oid = &$snmp_oids[$this->series]['STP']['RegionalRoot'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_regional_root_cost($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RegionalRootCost'])) $oid = &$snmp_oids['DLink']['STP']['RegionalRootCost'];
		else $oid = &$snmp_oids[$this->series]['STP']['RegionalRootCost'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_root_port($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RootPort'])) $oid = &$snmp_oids['DLink']['STP']['RootPort'];
		else $oid = &$snmp_oids[$this->series]['STP']['RootPort'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_max_age($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['MaxAge'])) $oid = &$snmp_oids['DLink']['STP']['MaxAge'];
		else $oid = &$snmp_oids[$this->series]['STP']['MaxAge'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_forward_delay($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['ForwardDelay'])) $oid = &$snmp_oids['DLink']['STP']['ForwardDelay'];
		else $oid = &$snmp_oids[$this->series]['STP']['ForwardDelay'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_last_topology_change($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['LastTopologyChange'])) $oid = &$snmp_oids['DLink']['STP']['LastTopologyChange'];
		else $oid = &$snmp_oids[$this->series]['STP']['LastTopologyChange'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_topology_change_count($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['TopologyChangeCount'])) $oid = &$snmp_oids['DLink']['STP']['TopologyChangeCount'];
		else $oid = &$snmp_oids[$this->series]['STP']['TopologyChangeCount'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$instance);
	}

	protected function _snmp_get_stp_hello_time($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['HelloTime'])) $oid = &$snmp_oids['DLink']['STP']['HelloTime'];
		else $oid = &$snmp_oids[$this->series]['STP']['HelloTime'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_stp_admin_hello_time($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['AdminHelloTime'])) $oid = &$snmp_oids['DLink']['STP']['AdminHelloTime'];
		else $oid = &$snmp_oids[$this->series]['STP']['AdminHelloTime'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_stp_port_state($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortState'])) $oid = &$snmp_oids['DLink']['STP']['PortState'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortState'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_stp_path_cost($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PathCost'])) $oid = &$snmp_oids['DLink']['STP']['PathCost'];
		else $oid = &$snmp_oids[$this->series]['STP']['PathCost'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_stp_adm_edge($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['AdminEdge'])) $oid = &$snmp_oids['DLink']['STP']['AdminEdge'];
		else $oid = &$snmp_oids[$this->series]['STP']['AdminEdge'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_stp_edge($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['OperEdge'])) $oid = &$snmp_oids['DLink']['STP']['OperEdge'];
		else $oid = &$snmp_oids[$this->series]['STP']['OperEdge'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_stp_adm_p2p($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['AdminP2P'])) $oid = &$snmp_oids['DLink']['STP']['AdminP2P'];
		else $oid = &$snmp_oids[$this->series]['STP']['AdminP2P'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_stp_p2p($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['OperP2P'])) $oid = &$snmp_oids['DLink']['STP']['OperP2P'];
		else $oid = &$snmp_oids[$this->series]['STP']['OperP2P'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_port_lbd($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortLBD'])) $oid = &$snmp_oids['DLink']['STP']['PortLBD'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortLBD'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_port_fbpdu($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortFBPDU'])) $oid = &$snmp_oids['DLink']['STP']['PortFBPDU'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortFBPDU'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_port_restricted_role($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RestrictedRole'])) $oid = &$snmp_oids['DLink']['STP']['RestrictedRole'];
		else $oid = &$snmp_oids[$this->series]['STP']['RestrictedRole'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_port_restricted_tcn($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RestrictedTCN'])) $oid = &$snmp_oids['DLink']['STP']['RestrictedTCN'];
		else $oid = &$snmp_oids[$this->series]['STP']['RestrictedTCN'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_port_fbpdu_status($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortFBPDUStatus'])) $oid = &$snmp_oids['DLink']['STP']['PortFBPDUStatus'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortFBPDUStatus'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_port_designated($port, $instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortFBPDUStatus'])) $oid = &$snmp_oids['DLink']['STP']['PortFBPDUStatus'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortFBPDUStatus'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port.'.'.$instance);
	}

	protected function _snmp_get_port_status($port, $instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortStatus'])) $oid = &$snmp_oids['DLink']['STP']['PortStatus'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortStatus'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port.'.'.$instance);
	}

	protected function _snmp_get_port_role($port, $instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortRole'])) $oid = &$snmp_oids['DLink']['STP']['PortRole'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortRole'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $oid.'.'.$port.'.'.$instance);
	}

	protected function _snmp_get_mgm_vlan() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['MgmVlan'])) $oid = &$snmp_oids['DLink']['MgmVlan'];
		else $oid = &$snmp_oids[$this->series]['MgmVlan'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid);

	}

	protected function _snmp_save() {
		global $snmp_oids;
		//save
		if (!isset($snmp_oids[$this->series]['GenMgmnt']['Save'])) $oid = &$snmp_oids['DLink']['GenMgmnt']['Save'];
		else $oid = &$snmp_oids[$this->series]['GenMgmnt']['Save'];

		if ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

		snmpset($this->ip, $comm, $oid, 'i', '5', 5000000, 1); //1 retry, 5 seconds

		//save progress, waiting for save completing
		if (!isset($snmp_oids[$this->series]['GenMgmnt']['SaveProgress'])) $oid = &$snmp_oids['DLink']['GenMgmnt']['SaveProgress'];
		else $oid = &$snmp_oids[$this->series]['GenMgmnt']['SaveProgress'];

		for ($i = 0; $i < 20; $i++) {
			$process = snmpget($this->ip, $comm, $oid);
			if (!$process) { usleep(50000); continue; }
			if ($process == 2) { usleep(50000); continue; } else break; //if still saveing then wait, else get the fuck out of here
		}

		error_reporting(E_ALL & ~E_NOTICE);
		if ($process == 3 || $process == 1) return true;
		return false;
	}

	protected function _snmp_reboot() {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['GenMgmnt']['Reboot'])) $oid = &$snmp_oids['DLink']['GenMgmnt']['Reboot'];
		else $oid = &$snmp_oids[$this->series]['GenMgmnt']['Reboot'];

		if ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
		snmpset($this->ip, $comm, $oid, 'i', '3', 1000000, 2); //2 retry, 1 second
		error_reporting(E_ALL & ~E_NOTICE);
		return true;
	}

	protected function _snmp_download_fw($filename, $tftp) {
		global $snmp_oids;
		global $consts;

		if (!isset($snmp_oids[$this->series]['GenMgmnt']['TFTP'])) $oid = &$snmp_oids['DLink']['GenMgmnt']['TFTP'];
		else $oid = &$snmp_oids[$this->series]['GenMgmnt']['TFTP'];

		if ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		snmpset($this->ip, $comm, $oid.'.3.1', 'a', $tftp);	//set TFTP server ip address
		snmpset($this->ip, $comm, $oid.'.4.1', 'i', 2);		//use network loading
		snmpset($this->ip, $comm, $oid.'.5.1', 's', $filename);	//set filename at tftp server
		snmpset($this->ip, $comm, $oid.'.7.1', 'i', 3);		//use download, not upload
		snmpset($this->ip, $comm, $oid.'.9.1', 'i', 2);		//erase old firmware, not try to increment ;-)
		snmpset($this->ip, $comm, $oid.'.10.1', 'i', 0);	//image id, for id = 0 will be used id, marked as boot-up
		snmpset($this->ip, $comm, $oid.'.8.1', 'i', 3);		//start

		return true;
	}



	//---------------------------------TELNET_CHECKS-------------------------------------

	protected function _telnet_create_vlan($vlanid, $vlan_name = false) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		if (!$vlan_name) $vlan_name = $vlanid;
		$r = $this->telnet->exec("create vlan $vlan_name tag $vlanid");
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (preg_match('/Success/i', $output)) return true;
		return false;
	}

	protected function _telnet_delete_vlan($vlan) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		$r = $this->telnet->exec("delete vlan $vlan");
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (preg_match('/Success/i', $output)) return true;
		return false;
	}

	protected function _telnet_add_vlan_to_port($vlan, $portlist, $type = 0) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		if (!$type) $type = 'tagged'; else $type = 'untagged';
		$r = $this->telnet->exec("config vlan $vlan add $type $portlist");
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (preg_match('/Success/i', $output)) return true;
		return false;
	}

	protected function _telnet_delete_vlan_from_port($vlan, $portlist) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		$r = $this->telnet->exec("config vlan $vlan delete $portlist");
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (preg_match('/Success/i', $output)) return true;
		return false;
	}

	protected function _telnet_create_iproute_default($default) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		$r = $this->telnet->exec("create iproute default $default");
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (preg_match('/Success/i', $output)) return true;
		return false;
	}

	protected function _telnet_config_system_ipif($CIDR, $vlanid) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		$this->telnet->write("config ipif System vlan $vlanid ipaddress $CIDR state enable");
		return true;
	}

	protected function _telnet_add_snmp_ro() {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		global $consts;
		$ro_comm = $consts['SNMP']['ROCOMM'];
		$r = $this->telnet->exec("create snmp community $ro_comm view CommunityView read_only");
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (!preg_match('/Success/i', $output)) return false;
		$r = $this->telnet->exec("enable snmp");
		if ($r) return true;

		return false;
	}

	protected function _telnet_add_snmp_rw() {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		global $consts;
		$rw_comm = $consts['SNMP']['RWCOMM'];
		$r = $this->telnet->exec("create snmp community $rw_comm view CommunityView read_write");
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (!preg_match('/Success/i', $output)) return false;
		$r = $this->telnet->exec("enable snmp");
		if ($r) return true;

		return false;
	}


	protected function _telnet_download_fw($fw_name, $tftp) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		$tmp_timeout = $this->telnet->timeout;
		$this->telnet->timeout = 360;
		$r = $this->telnet->exec("download firmware $tftp $fw_name i 1");
		$this->telnet->timeout = $tmp_timeout;
		if (!$r) return false;
		$output = $this->telnet->getBuffer();
		if (preg_match('/Done.$/i', $output)) return true;
		if (preg_match('/Success/i', $output)) return true;

		return false;
	}



}
?>
