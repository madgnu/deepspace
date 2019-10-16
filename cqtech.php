<?php

require_once('func.php');
require_once('consts.php');
require_once('cswitch.php');

class CQtech extends CSwitch {


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
	
	public function get_lldp_remo_chassis($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_lldp_remo_chassis($port);
	}

	public function get_lldp_remo_port($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent::get_lldp_remo_port($port);
	}


	public function get_lldp_remo_sysname($port) {
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		return parent:: get_lldp_remo_sysname($port);
	}


	
	/*Конец переопределенных методов из-за особенностей порта (в порте используется строка формата E1/1) */


	public function cable_diag($port) {
		if (!$port) return false;
		if ($this->interface_method & method_snmp_rw)
			return $this->_snmp_cable_diag($port);
		return false;
	}
	
	public function convert_mac_str($mac)
	{
		$arrStr=explode(":", $mac);
		$strMac="";
		foreach($arrStr as $key => $value)
		{
			if(strlen($value)<2) $value='0'.$value;
			if($strMac!="")$strMac.=':';
			$strMac=$strMac.$value;
		}
		return $strMac;
	}

	public function get_self_mac() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->convert_mac_str($this->_snmp_get_self_mac());
		return false;
	}

	public function get_port_mac($mac, $vlan = 0) {
		if (!$mac) return false;
		if (!$vlan) $vlan = $this->mgm_vlan();
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_get_port_of_mac_vlan($mac, $vlan);
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

	public function get_lbd_port_adm_state($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_lbd_port_adm_state($port);	
		}
		
	}

	public function get_lbd_port_status($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_lbd_port_status($port);	
		}
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

	public function get_stp_state() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_state();	
		
	}

	public function get_stp_version() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_version();	
		
	}


	public function get_stp_root_port() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_root_port();	
		
	}
	
	public function get_stp_priority() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_priority();	
		
	}

	public function get_stp_last_topology_change() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_last_topology_change();	
		
	}

	public function get_stp_topology_changes_count() {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro))
			return $this->_snmp_stp_topology_changes_count();	
		
	}



	public function get_stp_port_role($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_stp_port_role($port);	
		}
	}
	public function get_stp_port_pvid($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_stp_port_pvid($port);	
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



	public function get_stp_port_fbpdu($port) {
		if (($this->interface_method & method_snmp_rw) or ($this->interface_method & method_snmp_ro)){
			$port = $this->get_ifindex($port);
			if (!$port) return false;
			return $this->_snmp_stp_port_fbpdu($port);	
		}
	}

	
	public function port_cable_diag_avail($port) {
		global $consts;
		$port = $this->get_ifindex($port);
		if (!$port) return false;
		if (!$this->feature('cdiag')) return false;

		$hw = &$consts['HARDWARE']['SWITCH'];
		$cooper_map = $hw['QTECH']['COOPER'][$this->model_name];
		$cooper_avail = $cooper_map & (1 << ($port-1));
		if (!$cooper_avail) return false;
		$cdiag_map = $hw['CDIAG'][$this->model_name];
		$cdiag_avail = $cdiag_map & (1 << ($port-1));
		return $cdiag_avail;
	}

	//---------------------------------SNMP_CHECKS-------------------------------------



	protected function _snmp_get_port_of_mac_vlan($mac, $vlan) {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$snmp_mac = ConvertMac($mac, 2);
		$brIndex = snmpget($this->ip, $comm, $snmp_oids['MacList'].'.'.$snmp_mac);
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
		if(!isset($snmp_oids[$this->series]['CableDiag'])) $cdiag_oid = $snmp_oids['Qtech']['CableDiag']; 
		else $cdiag_oid = $snmp_oids[$this->series]['CableDiag']; 
		$ifindex = $this->get_ifindex($port);
		if (!$ifindex) return false;
		$prevResponse=snmpget($this->ip,$comm, $cdiag_oid.'.18.'.$ifindex);
		$response = snmpget($this->ip,$comm, $cdiag_oid.'.19.'.$ifindex);
		/*Разбиваем ответ на массив строк*/
		$tempArrStr=explode("\n", $response);
		$strResult="";
		foreach($tempArrStr as $key => $value)
		{
			if(trim($value)=="")continue;
			/*'(' указывает, что строка со значением*/
			if($value[0]=='(')
			{
				$strResult.=", [".$value."]";
			/*3 это позиция заголовка*/
			}elseif($key==3)
			{
				$strResult.="[".$value."]";
			}		
		}
		/*Преобразуем в удобный для чтения вид*/
		$strResult=str_replace("		",", ",$strResult);
		$strResult=str_replace("	",", ",$strResult);
		return $strResult;
	}


	/*SNMP для выдергивания mac адреса */
	protected function _snmp_get_self_mac() {
		global $snmp_oids;
		/*Проверка на наличие данной константы в памяти*/
		if (!isset($snmp_oids[$this->series]['macDefault']))  $oid = &$snmp_oids['Qtech']['macDefault'];
		else $oid = &$snmp_oids[$this->series]['macDefault'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		return snmpget($this->ip, $comm, $oid);
	}
	
	/*SNMP для выдергивания ip адрес роутера */
	protected function _snmp_get_iproute_default() {
		global $snmp_oids;
		/*Проверка на наличие данной константы в памяти*/
		if (!isset($snmp_oids[$this->series]['ipRouteDefault'])) $oid = &$snmp_oids['Qtech']['ipRouteDefault'];
		else $oid = &$snmp_oids[$this->series]['ipRouteDefault'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		return snmpget($this->ip, $comm, $oid);
	}
	
	/*SNMP для определения версии прошивки*/
	protected function _snmp_get_fwver() {
		global $snmp_oids;
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		if (!isset($snmp_oids[$this->series]['FwVer'])) $oid = &$snmp_oids['Qtech']['FwVer'];
		else $oid = $snmp_oids[$this->series]['FwVer'];
		$r = snmpget($this->ip, $comm, $oid);
		$matches = 0;
		preg_match('/([^"]+)/', $r, $matches);
		if (count($matches) == 2) $this->fwver1 = $matches[1];
		else $this->fwver1 = $r;
		return true;
	}

	protected function _snmp_lbd_interval() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['LBD']['Interval'])) $oid = &$snmp_oids['Qtech']['LBD']['Interval'];
		else $oid = &$snmp_oids[$this->series]['LBD']['Interval'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		return snmpget($this->ip, $comm, $oid);
	}
	
	protected function _snmp_lbd_recover() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['LBD']['Recover'])) $oid = &$snmp_oids['Qtech']['LBD']['Recover'];
		else $oid = &$snmp_oids[$this->series]['LBD']['Recover'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		return snmpget($this->ip, $comm, $oid);
	}
	
	
	protected function _snmp_lbd_port_adm_state($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['LBD']['PortAdmState'])) $oid = &$snmp_oids['Qtech']['LBD']['PortAdmState'];
		else $oid = &$snmp_oids[$this->series]['LBD']['PortAdmState'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r = snmpget($this->ip, $comm, $oid.".".$port);
		if(preg_match('/[0-9]/',$r)) return "On";
		return "Off";
	}

	protected function _snmp_lbd_port_status($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['LBD']['PortStatus'])) $oid = &$snmp_oids['Qtech']['LBD']['PortStatus'];
		else $oid = &$snmp_oids[$this->series]['LBD']['PortStatus'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_id= snmpget($this->ip, $comm, $oid.".".$port);
		global $snmp_out;
		$status="";
		if (!isset($snmp_out[$this->series]['LBD']['PortStatus'][$r_id])) $status = &$snmp_out[$this->series]['LBD']['PortStatus'][$r_id];
		else  $status = &$snmp_out['Qtech']['LBD']['PortStatus'][$r_id];
		return $status;
	}


	protected function _snmp_port_adm_state($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['PortInfo']['AdmState'])) $oid = &$snmp_oids['Qtech']['PortInfo']['AdmState'];
		else $oid = &$snmp_oids[$this->series]['PortInfo']['AdmState'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid.".".$port);	
		return 	$r;
	}

	protected function _snmp_port_adm_speed($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['PortInfo']['AdmSpeed'])) $oid = &$snmp_oids['Qtech']['PortInfo']['AdmSpeed'];
		else $oid = &$snmp_oids[$this->series]['PortInfo']['AdmSpeed'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_id= snmpget($this->ip, $comm, $oid.".".$port);
		global $snmp_out;
		$speed="";
		if (isset($snmp_out[$this->series]['PortInfo']['AdmSpeed'][$r_id])) $speed = &$snmp_out[$this->series]['PortInfo']['AdmSpeed'][$r_id];
		else  $speed = &$snmp_out['Qtech']['PortInfo']['AdmSpeed'][$r_id];
		return $speed;
	}
	
	protected function _snmp_port_status($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['PortInfo']['Status'])) $oid = &$snmp_oids['Qtech']['PortInfo']['Status'];
		else $oid = &$snmp_oids[$this->series]['PortInfo']['Status'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid.".".$port);	
		return 	$r;
	}

	protected function _snmp_port_speed($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['PortInfo']['Speed'])) $oid = &$snmp_oids['Qtech']['PortInfo']['Speed'];
		else $oid = &$snmp_oids[$this->series]['PortInfo']['Speed'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_speed= snmpget($this->ip, $comm, $oid.".".$port);	
		global $snmp_out;
		$speed="";
		if (isset($snmp_out['Switch']['Speed'][$r_speed])) $speed = &$snmp_out['Switch']['Speed'][$r_speed];
		return $speed;
	}


	protected function _snmp_stp_state() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['State'])) $oid = &$snmp_oids['Qtech']['STP']['State'];
		else $oid = &$snmp_oids[$this->series]['STP']['State'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid);	
		return $r;
	}

	protected function _snmp_stp_version() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['Version'])) $oid = &$snmp_oids['Qtech']['STP']['Version'];
		else $oid = &$snmp_oids[$this->series]['STP']['Version'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid);	
		return $r;
	}


	protected function _snmp_stp_root_port() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['PortRole'])) $oid = &$snmp_oids['Qtech']['STP']['PortRole'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortRole'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$response= snmprealwalk($this->ip, $comm, $oid);
		$result="";
		foreach ($response as $key=>$value)
		{
			if($value=="2")
			{
				if($result!="") $result=$result.", ";
				$arr_oid=explode('.', $key);
				$result=$result.$arr_oid[count($arr_oid)-1];
			}
		}

		return $result;
	}


	protected function _snmp_stp_priority() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['Priority']))  $oid = &$snmp_oids['Qtech']['STP']['Priority'];
		else $oid = &$snmp_oids[$this->series]['STP']['Priority'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid);	
		return $r;
	}


	protected function _snmp_stp_last_topology_change() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['LastTopologyChange'])) $oid = &$snmp_oids['Qtech']['STP']['LastTopologyChange'];
		else $oid = &$snmp_oids[$this->series]['STP']['LastTopologyChange'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid);	
		return $r;
	}


	protected function _snmp_stp_topology_changes_count() {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['TopologyChangeCount'])) $oid = &$snmp_oids['Qtech']['STP']['TopologyChangeCount'];
		else $oid = &$snmp_oids[$this->series]['STP']['TopologyChangeCount'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid);	
		return $r;
	}





	protected function _snmp_stp_port_role($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['PortRole'])) $oid = &$snmp_oids['Qtech']['STP']['PortRole'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortRole'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_port= snmpget($this->ip, $comm, $oid.".0.".$port);
		global $snmp_out;
		$port_role="";
		if (isset($snmp_out['Qtech']['STP']['PortRole'][$r_port])) $port_role = &$snmp_out['Qtech']['STP']['PortRole'][$r_port];
		return $port_role;
	}

	protected function _snmp_stp_port_pvid($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['PVID'])) $oid = &$snmp_oids['Qtech']['STP']['PVID'];
		else $oid = &$snmp_oids[$this->series]['STP']['PVID'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r= snmpget($this->ip, $comm, $oid.".".$port);
		return $r;
	}

	protected function _snmp_stp_port_status($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['PortStatus'])) $oid = &$snmp_oids['Qtech']['STP']['PortStatus'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortRole'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_port= snmpget($this->ip, $comm, $oid.".0.".$port);
		global $snmp_out;
		$port_status="";
		if (isset($snmp_out['Qtech']['STP']['PortStatus'][$r_port])) $port_status = &$snmp_out['Qtech']['STP']['PortStatus'][$r_port];
		return $port_status;
	}


	protected function _snmp_stp_adm_port_status($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['AdmPortStatus'])) $oid = &$snmp_oids['Qtech']['STP']['AdmPortStatus'];
		else $oid = &$snmp_oids[$this->series]['STP']['AdmPortStatus'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_port= snmpget($this->ip, $comm, $oid.".".$port);
		global $snmp_out;
		$adm_port_status="";
		if (isset($snmp_out['Qtech']['STP']['AdmPortStatus'][$r_port])) $adm_port_status = &$snmp_out['Qtech']['STP']['AdmPortStatus'][$r_port];
		return $adm_port_status;
	}
	
	protected function _snmp_stp_port_fbpdu($port) {
		global $snmp_oids;
		if (!isset($snmp_oids[$this->series]['STP']['PortFBPDU'])) $oid = &$snmp_oids['Qtech']['STP']['PortFBPDU'];
		else $oid = &$snmp_oids[$this->series]['STP']['PortFBPDU'];
		if ($this->interface_method & method_snmp_ro) $comm = $this->snmp_ro_comm;
		elseif ($this->interface_method & method_snmp_rw) $comm = $this->snmp_rw_comm;
		if (!isset($comm)) return false;
		$r_port= snmpget($this->ip, $comm, $oid.".".$port);
		global $snmp_out;
		$port_FBPDU="";
		if (isset($snmp_out['Qtech']['STP']['PortFBPDU'][$r_port])) $port_FBPDU = &$snmp_out['Qtech']['STP']['PortFBPDU'][$r_port];
		return $port_FBPDU;
	}





}

?>
