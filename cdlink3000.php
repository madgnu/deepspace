<?php

require_once('func.php');
require_once('consts.php');
require_once('cdlink.php');

class CDlink3000 extends CDlink {

	public function update() {
		global $consts;
		if (!isset($consts['TFTP']['BOOT'][$this->series]) || (!isset($consts['TFTP']['FIRMWARE'][$this->series]))) return false;

		if (!$this->download_fw($consts['TFTP']['BOOT'][$this->series])) return false;
		if (!$this->download_fw($consts['TFTP']['FIRMWARE'][$this->series])) return false;
		return true;
	}



	//---------------------------------SNMP_CHECKS-------------------------------------

	protected function _snmp_get_fwver() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		if (isset($snmp_oids[$this->series]['FwVer'])) $oid = $snmp_oids[$this->series]['FwVer'];
		else $oid = $snmp_oids['DLink']['FwVer'];

		$r = snmpget($this->ip, $comm, $oid);
		$matches = 0;
		preg_match('/([^"]+)/', $r, $matches);
		if (count($matches) == 2) $this->fwver1 = $matches[1];
		else $this->fwver1 = $r;

		return true;
	}


	protected function _snmp_port_adm_state($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['AdmState'].'.'.$port);
	}

	protected function _snmp_port_adm_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['AdmSpeed'].'.'.$port);
	}

	protected function _snmp_port_adm_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['AdmFlowCtrl'].'.'.$port);
	}

	protected function _snmp_port_description($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['Description'].'.'.$port);
	}

	protected function _snmp_port_learning($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['Learning'].'.'.$port);
	}

	protected function _snmp_port_status($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['Status'].'.'.$port);
	}

	protected function _snmp_port_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['Speed'].'.'.$port);
	}

	protected function _snmp_port_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['FlowCtrl'].'.'.$port);
	}

	protected function _snmp_get_stp_state() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['State']);
	}

	protected function _snmp_get_stp_fbpdu() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['FBPDU']);
	}

	protected function _snmp_get_stp_lbd() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['LBD']);
	}

	protected function _snmp_get_stp_lbd_recover() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['LBDRecover']);
	}

	protected function _snmp_get_stp_port_state($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['PortState'].'.'.$port);
	}

	protected function _snmp_get_stp_path_cost($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['PathCost'].'.'.$port);
	}

	protected function _snmp_get_stp_adm_edge($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['AdminEdge'].'.'.$port);
	}

	protected function _snmp_get_stp_edge($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['OperEdge'].'.'.$port);
	}

	protected function _snmp_get_stp_adm_p2p($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['AdminP2P'].'.'.$port);
	}

	protected function _snmp_get_stp_p2p($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['OperP2P'].'.'.$port);
	}

	protected function _snmp_get_port_lbd($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['PortLBD'].'.'.$port);
	}

	protected function _snmp_get_port_fbpdu($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['PortFBPDU'].'.'.$port);
	}

	protected function _snmp_get_port_restricted_role($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['RestrictedRole'].'.'.$port);
	}

	protected function _snmp_get_port_restricted_tcn($port) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['RestrictedTCN'].'.'.$port);
	}

	protected function _snmp_get_port_status($port, $instance = 0) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['PortStatus'].'.'.$port);
	}

	protected function _snmp_get_port_role($port, $instance = 0) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['PortRole'].'.'.$port);
	}

	protected function _telnet_download_fw($fw_name, $tftp) {
		if (!$this->telnet->keepAlive())
			if (!$this->_telnet_reconnect()) return false;

		$tmp_timeout = $this->telnet->timeout;
		$tmp_prompt = $this->telnet->prompt;
		$tmp_prompt_type = $this->telnet->prompt_type;

		$this->telnet->timeout = 360;

		$this->telnet->setPrompt('/[ a-zA-Z0-9]+rebooting...[ ]+/i', PROMPT_REGEXP);
		$r = $this->telnet->exec("download firmware $tftp $fw_name");

		$this->telnet->prompt = $tmp_prompt;
		$this->telnet->prompt_type = $tmp_prompt_type;
		$this->telnet->timeout = $tmp_timeout;
		if (!$r) return false;

		sleep(5);
		for ($i = 1; $i < 300; $i++) {
			sleep(1);
			if ($this->alive()) return true;
		}
		$this->interface_method = method_unknown;
		return false;
	}

}
?>
