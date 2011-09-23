<?php

require_once('func.php');
require_once('consts.php');
require_once('cdlink.php');

class CDlink3500 extends CDlink {


	//---------------------------------SNMP_CHECKS-------------------------------------



	protected function _snmp_port_adm_state($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DES-3500']['PortInfo']['AdmState'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_adm_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DES-3500']['PortInfo']['AdmSpeed'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_adm_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DES-3500']['PortInfo']['AdmFlowCtrl'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_description($port, $type) {
		return $this->get_description($port);
	}

	protected function _snmp_port_learning($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DES-3500']['PortInfo']['Learning'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_status($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DES-3500']['PortInfo']['Status'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DES-3500']['PortInfo']['Speed'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids['DES-3500']['PortInfo']['FlowCtrl'].'.'.$port.'.'.$type);
	}

		protected function _snmp_save() {
		global $snmp_oids;
		//save
		if (!isset($snmp_oids[$this->series]['GenMgmnt']['Save'])) $oid = &$snmp_oids['DLink']['GenMgmnt']['Save'];
		else $oid = &$snmp_oids[$this->series]['GenMgmnt']['Save'];

		if ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
		snmpset($this->ip, $comm, $oid, 'i', '3', 5000000, 1); //1 retry, 5 seconds

		//save progress, waiting for save completing
		if (!isset($snmp_oids[$this->series]['GenMgmnt']['SaveProgress'])) $oid = &$snmp_oids['DLink']['GenMgmnt']['SaveProgress'];
		else $oid = &$snmp_oids[$this->series]['GenMgmnt']['SaveProgress'];

		for ($i = 0; $i < 10; $i++) {
			$process = snmpget($this->ip, $comm, $oid);
			if (!$process) { usleep(50000); continue; }
			if ($process == 2) { usleep(50000); continue; } else break; //if still saveing then wait, else get the fuck out of here
		}

		error_reporting(E_ALL & ~E_NOTICE);
		if ($process == 3) return true;
		return false;
	}



}
?>
