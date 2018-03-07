<?php

require_once('func.php');
require_once('consts.php');
require_once('cdlink.php');

class CDlink1210 extends CDlink {


	public function get_self_mac() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$ifindex = $this->get_ifindex('System');

		return $this->_snmp_get_phys_address($ifindex);
	}

	//---------------------------------SNMP_CHECKS-------------------------------------

	protected function _snmp_get_stp_state() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['State']);
	}

	protected function _snmp_get_stp_version() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['Version']);
	}

	protected function _snmp_get_stp_fbpdu() {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$snmp_oids[$this->series]['STP']['FBPDU']);
	}

	protected function _snmp_get_stp_root_port($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RootPort'])) $oid = &$snmp_oids['DLink']['STP']['RootPort'];
		else $oid = &$snmp_oids[$this->series]['STP']['RootPort'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$instance);
	}

	protected function _snmp_get_stp_priority($instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['Priority'])) $oid = &$snmp_oids['DLink']['STP']['Priority'];
		else $oid = &$snmp_oids[$this->series]['STP']['Priority'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$instance);
	}

	protected function _snmp_get_stp_last_topology_change($instance = 0) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return 'N/A';
	}

	protected function _snmp_get_stp_topology_change_count($instance = 0) {
		global $snmp_oids;

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return 'N/A';
	}

	protected function _snmp_get_port_restricted_tcn($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RestrictedTCN'])) $oid = &$snmp_oids['DLink']['STP']['RestrictedTCN'];
		else $oid = &$snmp_oids[$this->series]['STP']['RestrictedTCN'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_get_port_restricted_role($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['RestrictedRole'])) $oid = &$snmp_oids['DLink']['STP']['RestrictedRole'];
		else $oid = &$snmp_oids[$this->series]['STP']['RestrictedRole'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_get_stp_adm_edge($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['AdminEdge'])) $oid = &$snmp_oids['DLink']['STP']['AdminEdge'];
		else $oid = &$snmp_oids[$this->series]['STP']['AdminEdge'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_get_stp_edge($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['OperEdge'])) $oid = &$snmp_oids['DLink']['STP']['OperEdge'];
		else $oid = &$snmp_oids[$this->series]['STP']['OperEdge'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_get_port_fbpdu($port) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortFBPDU'])) $oid = &$snmp_oids['DLink']['STP']['PortFBPDU'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortFBPDU'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_get_port_role($port, $instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortRole'])) $oid = &$snmp_oids['DLink']['STP']['PortRole'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortRole'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_get_port_status($port, $instance = 0) {
		global $snmp_oids;

		if (!isset($snmp_oids[$this->series]['STP']['PortStatus'])) $oid = &$snmp_oids['DLink']['STP']['PortStatus'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortStatus'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_get_gvrp_port_pvid($port) {
		global $snmp_oids;

		$oid = &$snmp_oids[$this->series]['GVRP']['PVID'];

		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmpget($this->ip, $comm, $this->snmp_prefix.$oid.'.'.$port);
	}

	protected function _snmp_cable_diag($port) {
		global $snmp_oids;
		global $snmp_out;

		if ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$cdiag_oid = isset($snmp_oids[$this->series]['CableDiag']) ? $this->snmp_prefix . $snmp_oids[$this->series]['CableDiag'] : $snmp_oids['DLink']['CableDiag'];

		$cdiag_ready = false;
		if (!snmpset($this->ip, $comm, $cdiag_oid.'.12.'.$port, 'i', '1')) return false;
		for ($i = 1; $i < 50; $i++) {
			$processing = snmpget($this->ip, $comm, $cdiag_oid.'.12.'.$port);	
			if ($processing ==  2) { usleep(50000); continue; } else { $cdiag_ready =  true; break; }

		}
		if (!$cdiag_ready) return false;

		$cableDiagPortType = snmpget($this->ip, $comm, $cdiag_oid.'.2.'.$port);

		if (!isset($cableDiagPortType) || ($cableDiagPortType != 0 && $cableDiagPortType != 1)) return false;

		$cableDiagLinkStatus  = snmpget($this->ip, $comm, $cdiag_oid.'.3.'.$port);

		$cableDiagPair2Status = snmpget($this->ip, $comm, $cdiag_oid.'.5.'.$port);
		$cableDiagPair3Status = snmpget($this->ip, $comm, $cdiag_oid.'.6.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair1Status = snmpget($this->ip, $comm, $cdiag_oid.'.4.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair4Status = snmpget($this->ip, $comm, $cdiag_oid.'.7.'.$port);

		$cableDiagPair2Length = snmpget($this->ip, $comm, $cdiag_oid.'.9.'.$port);
		$cableDiagPair3Length = snmpget($this->ip, $comm, $cdiag_oid.'.10.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair1Length = snmpget($this->ip, $comm, $cdiag_oid.'.8.'.$port);
		if ($cableDiagPortType == 1) $cableDiagPair4Length = snmpget($this->ip, $comm, $cdiag_oid.'.11.'.$port);

		if ($cableDiagPair2Status != 7) $cP2S = $snmp_out['DLink']['CableDiag'][$cableDiagPair2Status];
		if ($cableDiagPair3Status != 7) $cP3S = $snmp_out['DLink']['CableDiag'][$cableDiagPair3Status];
		if ($cableDiagPortType == 1 && $cableDiagPair1Status != 7) $cP1S = $snmp_out['DLink']['CableDiag'][$cableDiagPair1Status];
		if ($cableDiagPortType == 1 && $cableDiagPair4Status != 7) $cP4S = $snmp_out['DLink']['CableDiag'][$cableDiagPair4Status];


		if (isset($cP1S)) $cDiagRes  = ' Pair 1 '.$cP1S.' at '.$cableDiagPair1Length;
		if (isset($cP2S)) $cDiagRes .= ' Pair 2 '.$cP2S.' at '.$cableDiagPair2Length;
		if (isset($cP3S)) $cDiagRes .= ' Pair 3 '.$cP3S.' at '.$cableDiagPair3Length;
		if (isset($cP4S)) $cDiagRes .= ' Pair 4 '.$cP4S.' at '.$cableDiagPair4Length;

	
		if ($cableDiagLinkStatus == 1 &&
			$cableDiagPair2Status == 0 &&
			$cableDiagPair3Status == 0) $cDiagRes = 'OK, Cable Length: '.$cableDiagPair2Length;
		if ($cDiagRes == '') $cDiagRes = 'No Cable';

		return $cDiagRes;
	}

}
?>