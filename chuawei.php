<?php

require_once('func.php');
require_once('consts.php');
require_once('cswitch.php');


class CHuawei extends CSwitch {

/*Переопределяем методы из-за особенностей порта (в порте используется строка формата E1/1) */

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
	
	public function get_multicast_inbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_multicast_inbound($port);
	}

	public function get_multicast_outbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_multicast_outbound($port);
	}

	public function get_broadcast_inbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_broadcast_inbound($port);
	}

	public function get_broadcast_outbound($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_broadcast_outbound($port);
	}


	public function get_errors_crc($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_crc($port);
	}

	public function get_errors_undersize($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_undersize($port);
	}

	public function get_errors_oversize($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_oversize($port);
	}

	public function get_errors_fragment($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_fragment($port);
	}

	public function get_errors_jabber($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_jabber($port);
	}

	public function get_errors_single($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_single($port);
	}

	public function get_errors_late($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_late($port);
	}

	public function get_errors_excessive($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_excessive($port);
	}

	public function get_errors_advanced($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_advanced($port);
	}

	public function get_collisions($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_errors_advanced($port);
	}

	
	
	/*Конец переопределенных методов из-за особенностей порта (в порте используется строка формата E1/1) */










	public function get_oper_speed($port) {
		global $snmp_out;
		if (!$port) return false;
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		$speed=$this->_snmp_get_oper_speed($port);
		if(isset( $snmp_out['Switch']['Speed'][$speed])) return $snmp_out['Switch']['Speed'][$this->_snmp_get_oper_speed($port)];
		return $speed." Bit's";
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
	
	public function get_port_adm_state($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_port_adm_state($port);
		}
	}

	public function get_port_adm_speed($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_port_adm_speed($port);
		}
	}

	public function get_port_status($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_port_status($port);
		}
	}

	public function get_port_speed($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_port_speed($port);
		}
	}


	/*LBD работает всегда*/
	public function get_lbd_state() {
		return "On";
	}

	public function get_lbd_interval() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_lbd_interval();	
		
	}
	
	public function get_lbd_recover() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_lbd_recover();	
		
	}

	public function get_lbd_port_status($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_lbd_port_status($port);	
		}
	}

	public function get_lbd_port_adm_state($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_lbd_port_adm_state($port);	
		}
	}

	public function get_stp_state() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_state();
		return false;
	}
	
	
	public function get_stp_version() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_version();
		return false;
	}


	public function get_stp_port_fbpdu($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_stp_port_fbpdu($port);	
		}
	}


	public function get_stp_port_role($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_stp_port_role($port);	
		}
	}


	public function get_stp_port_status($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_stp_port_status($port);	
		}
	}

	public function get_stp_adm_port_status($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_stp_adm_port_status($port);	
		}
	}

	public function get_stp_last_topology_change() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_last_topology_change();
		return false;
	}

	public function get_stp_topology_changes_count() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_topology_changes_count();
		return false;
	}

	public function get_port_pvid($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_port_pvid($port);	
		}
	}


	//---------------------------------SNMP_CHECKS-------------------------------------


	protected function _snmp_get_iproute_default() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['ipRouteDefault'])) return FALSE;
		$oid = $snmp_oids['Huawei']['ipRouteDefault'];
		return snmpget($this->ip, $comm, $oid);
	}
	
	protected function _snmp_get_port_of_mac_vlan($mac, $vlan) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['macList']))return FALSE;
		 $oid = &$snmp_oids['Huawei']['macList'];
		$snmp_mac = ConvertMac($mac, 2);
		$r=snmpget($this->ip, $comm, $oid.".".$snmp_mac.".".$vlan.".1.48");
		return $r;
	}

	protected function _snmp_get_fwver() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['FwVer']))return FALSE;
		$oid = $snmp_oids['Huawei']['FwVer'];
		$r = snmpget($this->ip, $comm, $oid);
		$matches = 0;
		preg_match('/([^"]+)/', $r, $matches);
		if (count($matches) == 2) $this->fwver1 = $matches[1];
		else $this->fwver1 = $r;
		return true;
	}


	protected function _snmp_get_errors_crc($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['RMON']['CRCErr'])) return FALSE;
		$oid = $snmp_oids['Huawei']['RMON']['CRCErr'];
		return snmp2_get($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_errors_undersize($port){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['RMON']['Undersize'])) return FALSE;
		$oid = $snmp_oids['Huawei']['RMON']['Undersize'];
		return snmp2_get($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_errors_oversize($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['RMON']['Oversize'])) return FALSE;
		$oid = $snmp_oids['Huawei']['RMON']['Oversize'];
		return snmp2_get($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_errors_fragment($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['RMON']['Fragment'])) return FALSE;
		$oid = $snmp_oids['Huawei']['RMON']['Fragment'];
		return snmp2_get($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_errors_jabber($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['RMON']['Jabber'])) return FALSE;
		$oid = $snmp_oids['Huawei']['RMON']['Jabber'];
		return snmp2_get($this->ip, $comm, $oid.'.'.$port);
	}

	protected function _snmp_get_errors_collision($port) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['RMON']['Collision'])) return FALSE;
		$oid = $snmp_oids['Huawei']['RMON']['Collision'];
		return snmp2_get($this->ip, $comm, $oid.'.'.$port);
	}

	

	protected function _snmp_lbd_interval() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($snmp_oids['Huawei']['LBD']['Interval'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['LBD']['Interval'];
		if (!isset($comm)) return false;
		return snmpget($this->ip, $comm, $oid.".0");
	}
	
	protected function _snmp_lbd_recover() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($snmp_oids['Huawei']['LBD']['Recover'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['LBD']['Recover'];
		if (!isset($comm)) return false;
		return snmpget($this->ip, $comm, $oid);
	}

	protected function _snmp_lbd_port_status($port) {
		global $snmp_oids;
		if (!isset($snmp_oids['Huawei']['LBD']['PortStatus'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['LBD']['PortStatus'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_id= snmpget($this->ip, $comm, $oid.".".$port);
		global $snmp_out;
		$status="";
		if (!isset($snmp_out['Huawei']['LBD']['PortStatus'][$r_id])) return FALSE;
		$status = $snmp_out['Huawei']['LBD']['PortStatus'][$r_id];
		return $status;
	}
	
	protected function _snmp_lbd_port_adm_state($port) {
		global $snmp_oids;
		if (!isset($snmp_oids['Huawei']['LBD']['PortAdmStatus'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['LBD']['PortAdmStatus'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_id= snmpget($this->ip, $comm, $oid.".".$port);
		global $snmp_out;
		$status="";
		if (!isset($snmp_out['Huawei']['LBD']['PortAdmStatus'][$r_id])) return FALSE;
		$status = $snmp_out['Huawei']['LBD']['PortAdmStatus'][$r_id];
		return $status;
	}

	protected function _snmp_port_adm_state($port) {
		global $snmp_oids;
		if (!isset($snmp_oids['ifAdminStatus'])) return FALSE;
		$oid = $snmp_oids['ifAdminStatus'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid.".".$port);	
		return 	$r;
	}

	protected function _snmp_port_status($port) {
		global $snmp_oids;
		if (!isset($snmp_oids['ifOperStatus'])) return FALSE;
		$oid = $snmp_oids['ifAdminStatus'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid.".".$port);	
		return 	$r;
	}
	protected function _snmp_port_speed($port) {
		global $snmp_oids;
		if (!isset($snmp_oids['Huawei']['ifHighSpeed'])) return FALSE;
		$oid = $snmp_oids['Huawei']['ifHighSpeed'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid.".".$port);	
		return 	$r;
	}


	protected function _snmp_stp_state(){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['State'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['State'];
		$r_id= snmpget($this->ip, $comm, $oid);
		global $snmp_out;
		$status="";
		if (!isset($snmp_out['Huawei']['STP']['State'][$r_id])) return FALSE;
		$status = $snmp_out['Huawei']['STP']['State'][$r_id];
		return $status;
	}

	protected function _snmp_stp_version(){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['Version'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['Version'];
		$r_id= snmp2_get($this->ip, $comm, $oid.".0");
		global $snmp_out;
		$status="";
		if (!isset($snmp_out['Huawei']['STP']['Version'][$r_id])) return FALSE;
		$status = $snmp_out['Huawei']['STP']['Version'][$r_id];
		return $status;
	}
	
	protected function _snmp_stp_port_fbpdu($port){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['PortFBPDU'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['PortFBPDU'];
		$r_id= snmp2_get($this->ip, $comm, $oid.".0.".$port);
		global $snmp_out;
		if (!isset($snmp_out['Huawei']['STP']['PortFBPDU'][$r_id])) return FALSE;
		$r = $snmp_out['Huawei']['STP']['PortFBPDU'][$r_id];
		return $r;
	}


	protected function _snmp_stp_port_role($port){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['PortRole'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['PortRole'];
		$r_id= snmp2_get($this->ip, $comm, $oid.".0.".$port);
		global $snmp_out;
		if (!isset($snmp_out['Huawei']['STP']['PortRole'][$r_id])) return FALSE;
		$r = $snmp_out['Huawei']['STP']['PortRole'][$r_id];
		return $r;
	}

	protected function _snmp_stp_port_status($port){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['PortStatus'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['PortStatus'];
		$r_id= snmp2_get($this->ip, $comm, $oid.".0.".$port);
		global $snmp_out;
		if (!isset($snmp_out['Huawei']['STP']['PortStatus'][$r_id])) return FALSE;
		$r = $snmp_out['Huawei']['STP']['PortStatus'][$r_id];
		return $r;
	}

	protected function _snmp_stp_adm_port_status($port){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['AdmPortStatus'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['AdmPortStatus'];
		$r_id= snmp2_get($this->ip, $comm, $oid.".0.".$port);
		global $snmp_out;
		if (!isset($snmp_out['Huawei']['STP']['AdmPortStatus'][$r_id])) return FALSE;
		$r = $snmp_out['Huawei']['STP']['AdmPortStatus'][$r_id];
		return $r;
	}


	protected function _snmp_stp_last_topology_change(){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['LastTopologyChange'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['LastTopologyChange'];
		$r= snmp2_get($this->ip, $comm, $oid.".0");
		return $r;
	}

	protected function _snmp_stp_topology_changes_count(){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['STP']['TopologyChangeCount'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['STP']['TopologyChangeCount'];
		$r= snmp2_get($this->ip, $comm, $oid.".0");
		return $r;
	}


	protected function _snmp_port_pvid($port){
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids['Huawei']['PVID'])) return FALSE;
 		$oid = $snmp_oids['Huawei']['PVID'];
		$r= snmp2_get($this->ip, $comm, $oid.".".$port);
		return $r;
	}



}

?>
