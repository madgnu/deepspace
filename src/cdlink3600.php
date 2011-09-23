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

	protected function _snmp_get_lldp_chassis() { //Because -Cc option we need :(
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = array();
		exec("snmpwalk -v 2c -Cc -On -c $comm ".$this->ip." ".$snmp_oids['LLDP']['RemoteData'].'.5', $res); //dirty hack
		foreach ($res as $r) {
			$matches = 0;
			preg_match('/([0-9.]+) = STRING: "([0-9A-F\-]+)"/', $r, $matches);
			if (count($matches) == 3)
				$s[$matches[1]] = $matches[2];
		}

		if (!$s) return false;
		$this->ports['LLDP']['Chassis'] = 0;
		$this->ports['LLDP']['Chassis'] = array();

		foreach ($s as $k => $v) {
			$matches = 0;
			preg_match('/[0-9]+\.([0-9]+)\.[0-9]+$/', $k, $matches);
			if (count($matches) == 2) {
				$port = $matches[1];
				$mac = ConvertMac($v, 0, true, '-');
				$this->ports['LLDP']['Chassis'][$port] = $mac;
			}
		}

		return true;
	}

	protected function _snmp_get_lldp_ports() { //Because -Cc option we need :(
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$s = array();
		exec("snmpwalk -v 2c -Cc -On -c $comm ".$this->ip." ".$snmp_oids['LLDP']['RemoteData'].'.7', $res); //dirty hack
		foreach ($res as $r) {
			$matches = 0;
			preg_match('/([0-9.]+) = STRING: (["0-9:\/]+)/', $r, $matches);
			if (count($matches) == 3) {
				$s[$matches[1]] = $matches[2];
			}
		}

		if (!$s) return false;
		$this->ports['LLDP']['Ports'] = 0;
		$this->ports['LLDP']['Ports'] = array();

		foreach ($s as $k => $v) {
			$matches = 0;
			preg_match('/[0-9]+\.([0-9]+)\.[0-9]+$/', $k, $matches);
			if (count($matches) == 2) {
				$port = $matches[1];
				$matches = 0;
				preg_match('/([0-9]+)["]*$/', $v, $matches);
				if (count($matches) == 2) {
					$remo_port = $matches[1];
					$this->ports['LLDP']['Ports'][$port] = $remo_port;
				}
			}
		}

		return true;
	}




}
?>
