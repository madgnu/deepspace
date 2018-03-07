<?php

require_once('func.php');
require_once('consts.php');
require_once('cswitch.php');

class CCisco extends CSwitch {

	public function feature_list() {
		global $consts;
		$features = &$consts['FEATURES'];
		$r = parent::feature_list();
	
		if ($this->snmp_ro_avail || $this->snmp_rw_avail) $r = $features['SNMPRO']['Cisco'].$r;
	
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

	public function check_model() {
		if (!isset($this->model_name)) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)) {
			$r = $this->_snmp_get_hardware_model_names();
			if (!$r) return false;
			foreach($r as $v)
				if (trim($v, '"') == $this->model_name) return true;
		}
		return false;
	}

	public function port_cable_diag_avail($port) {
		
		global $consts;
		if (!$port) return false;
		if (!$this->feature('cdiag')) return false;
		
		
		$hw = &$consts['HARDWARE']['SWITCH'];
#		$cooper_map = $hw['DLINK']['COOPER'][$this->model_name];
#		$cooper_avail = $cooper_map & (1 << ($port-1));
#		if (!$cooper_avail) return false;
		
		$ifindex = $this->get_ifindex($port);
		$portType = strtoupper(substr($port, 0, 2));
		$portIndexOffset = $hw['PORTINDEXOFFSET'][$this->series][$portType];
		$cdiag_map = $hw['CDIAG'][$this->model_name][$portType];
		$cdiag_avail = $cdiag_map & (1 << ($ifindex-$portIndexOffset-1));
		return $cdiag_avail;
		
	}

	public function cable_diag($port) {
		if (!$port) return false;
		if ($this->interface_method & method_snmp_rw)
			return $this->_snmp_cable_diag($port);
		return false;
	}


	//---------------------------------SNMP_CHECKS-------------------------------------


	protected function _snmp_get_port_of_mac_vlan($mac, $vlan) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		$snmp_mac = ConvertMac($mac, 2);
		$brIndex = snmpget($this->ip, $comm."@$vlan", $snmp_oids['MacList'].'.'.$snmp_mac);
		return $this->get_ifname_by_bridge_index($brIndex);
	}

	protected function _snmp_get_hardware_model_names() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;

		return snmprealwalk($this->ip, $comm, $snmp_oids['Cisco']['PhysEntry'].'.13');
	}

	protected function _snmp_cable_diag($port) {

		global $snmp_oids;
		global $snmp_out;
		
		if (!isset($port)) return false;
		
		if ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		

#		$cdiag_oid = isset($snmp_oids[$this->series]['CableDiag']) ? $this->snmp_prefix . $snmp_oids[$this->series]['CableDiag'] : $snmp_oids['Cisco']['CableDiag']; // may be used in future

		$cdiag_oid = $snmp_oids['Cisco']['CableDiag']; 

		$ifindex = $this->get_ifindex($port);
		if (!$ifindex) return false;
		
		$PortType=strtolower(substr($port, 0, 1));

		if (($PortType != 'f') && ($PortType != 'g')) return false; 
			else {
				$fourPairs = false;				
				if ($PortType == 'g') $fourPairs = 'true';
				}

		
		$prevResult = snmpget($this->ip,$comm, $cdiag_oid.'.1.1.4.'.$ifindex); // 1- true, 2 - false; mod
			if ($prevResult == 1) {
				$clear = snmpset ($this->ip, $comm, $cdiag_oid.'.1.1.1.'.$ifindex, 'i', 2);
				if (!$clear) return false;
				}

		$cdiag_ready = false;
		if (!snmpset($this->ip, $comm, $cdiag_oid.'.1.1.1.'.$ifindex, 'i', '1')) return false;
		for ($i = 1; $i < 50; $i++) {
			$processing = snmpget($this->ip, $comm, $cdiag_oid.'.1.1.1.'.$ifindex);
			if ($processing == 3) { usleep(50000); continue; } else { $cdiag_ready =  true; break; }

		}
		if (!$cdiag_ready) return false;
		

		if (snmpget($this->ip, $comm, $cdiag_oid.'.1.1.2.'.$ifindex) != 1 ) return false; // ccdTdrIfActionStatus
		
		$ifOperStatus = snmpget($this->ip, $comm, $snmp_oids['ifOperStatus'].'.'.$ifindex); // up, down
				
		
		$lengthUnit=array();		
		$lengthUnit[1]='undefined';		
		$lengthUnit[2]='m';
		$lengthUnit[3]='sm';
		$lengthUnit[4]='km';
		$pref=' +/- ';
		$post=' at ';
#Pair1 
			
		
		for ($i = 1; $i < 150; $i++) {
			$pair1Status = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.8.'.$ifindex.'.1');
			if ($pair1Status == 3) { usleep(50000); continue; } else break; // 3 - notCompleted
			}
		if (($ifOperStatus == 'down') && ($pair1Status == 2)) {$cP1S = 'OK'; $cP1L = ''; $cP1A = ''; $cP1M = '';}
			else if (($ifOperStatus == 'up') && ($pair1Status == 2)) {
			$cP1S = 'OK'.$post; 
			$cP1L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.3.'.$ifindex.'.1'); // ccdTdrIfResultPairLength
			$cP1A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.4.'.$ifindex.'.1'); // ccdTdrIfResultPairLenAccuracy
			$cP1M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.1')];
			} else {
			$cP1S = $snmp_out['Cisco']['CableDiag'][$pair1Status].$post;
			$cP1L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.5.'.$ifindex.'.1'); //ccdTdrIfResultPairDistToFault
			$cP1A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.6.'.$ifindex.'.1'); // ccdTdrIfResultPairDistAccuracy
			$cP1M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.1')];
			}

		
#Pair2		
		for ($i = 1; $i < 150; $i++) {
			$pair2Status = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.8.'.$ifindex.'.2');
			if ($pair2Status == 3) { usleep(50000); continue; } else break;
			}

		if (($ifOperStatus == 'down') && ($pair2Status == 2)) {$cP2S = 'OK'; $cP2L = ''; $cP2A = ''; $cP2M = '';}
			else if (($ifOperStatus == 'up') && ($pair2Status == 2)) {
			$cP2S = 'OK'.$post; 
			$cP2L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.3.'.$ifindex.'.2'); // ccdTdrIfResultPairLength
			$cP2A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.4.'.$ifindex.'.2'); // ccdTdrIfResultPairLenAccuracy
			$cP2M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.2')];
			} else {
			$cP2S = $snmp_out['Cisco']['CableDiag'][$pair2Status].$post;
			$cP2L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.5.'.$ifindex.'.2'); //ccdTdrIfResultPairDistToFault
			$cP2A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.6.'.$ifindex.'.2'); // ccdTdrIfResultPairDistAccuracy
			$cP2M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.2')];
			}
		

	if ($fourPairs) {
#Pair3
		for ($i = 1; $i < 150; $i++) {
			$pair3Status = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.8.'.$ifindex.'.3');
			if ($pair3Status == 3) { usleep(50000); continue; } else break;
			}

			if (($ifOperStatus == 'down') && ($pair3Status == 2)) {$cP3S = 'OK'; $cP3L = ''; $cP3A = '';$cP3M='';}
				else if (($ifOperStatus == 'up') && ($pair3Status == 2)) {
				$cP3S = 'OK'.$post; 
				$cP3L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.3.'.$ifindex.'.3'); // ccdTdrIfResultPairLength
				$cP3A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.4.'.$ifindex.'.3'); // ccdTdrIfResultPairLenAccuracy
				$cP3M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.3')];
					} else {
					$cP3S = $snmp_out['Cisco']['CableDiag'][$pair3Status].$post;
					$cP3L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.5.'.$ifindex.'.3'); //ccdTdrIfResultPairDistToFault
					$cP3A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.6.'.$ifindex.'.3'); // ccdTdrIfResultPairDistAccuracy
					$cP3M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.3')];
					}
#Pair4				

		for ($i = 1; $i < 150; $i++) {
			$pair4Status = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.8.'.$ifindex.'.4');
			if ($pair4Status == 3) { usleep(50000); continue; } else break;
			}
			if (($ifOperStatus == 'down') && ($pair4Status == 2)) {$cP4S = 'OK'; $cP4L = ''; $cP4A = ''; $cP4M = '';}
				else if (($ifOperStatus == 'up') && ($pair4Status == 2)) {
				$cP4S = 'OK'.$post; 
				$cP4L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.3.'.$ifindex.'.4'); // ccdTdrIfResultPairLength
				$cP4A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.4.'.$ifindex.'.4'); // ccdTdrIfResultPairLenAccuracy
				$cP4M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.4')];
					} else {
					$cP4S = $snmp_out['Cisco']['CableDiag'][$pair4Status].$post;
					$cP4L = snmpget($this->ip, $comm, $cdiag_oid.'.2.1.5.'.$ifindex.'.4'); //ccdTdrIfResultPairDistToFault
					$cP4A = $pref.snmpget($this->ip, $comm, $cdiag_oid.'.2.1.6.'.$ifindex.'.4'); // ccdTdrIfResultPairDistAccuracy
					$cP4M = $lengthUnit[snmpget($this->ip, $comm, $cdiag_oid.'.2.1.7.'.$ifindex.'.4')];
					}
		}

			$result = 	  'Pair1 is '.$cP1S.$cP1L.$cP1A.$cP1M." ";
			$result = $result.'Pair2 is '.$cP2S.$cP2L.$cP2A.$cP2M." ";
		if ($fourPairs) {
			$result = $result.'Pair3 is '.$cP3S.$cP3L.$cP3A.$cP3M." ";
			$result = $result.'Pair4 is '.$cP4S.$cP4L.$cP4A.$cP4M;
				}
		return $result;
	}



}

?>
