<?php

require_once('func.php');
require_once('consts.php');
require_once('cdlink.php');

class CDlink3600 extends CDlink {

	//---------------------------------SNMP_CHECKS-------------------------------------

	protected function _snmp_port_adm_state($port, $type) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['AdmState'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_adm_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['AdmSpeed'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_adm_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['AdmFlowCtrl'].'.'.$port.'.'.$type);
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

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['Learning'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_status($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['Status'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_speed($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['Speed'].'.'.$port.'.'.$type);
	}

	protected function _snmp_port_flowctrl($port, $type) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!$type) $type = 1; else $type = 2; //if type == 0, then it is cooper, else - fiber

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['PortInfo']['FlowCtrl'].'.'.$port.'.'.$type);
	}

}
?>
