#! /usr/bin/php

<?php
/*
	It's trash, but it may be usefull for understanding deepspace
*/

	require_once('../src/driverfactory.php');
	global $switch_drivers;
	$dev = $switch_drivers->get_driver('192.168.0.3', 'D-Link', 'DES-3200-28');
	$port = '2';
	echo 'OnCreate features:'.$dev->feature_list()."\n";
	if ($dev->alive()) echo "alive\n"; else echo "not alive\n";
/*	if ($dev->check_snmp_ro()) echo "snmp ro avail\n"; else echo "snmp ro not avail\n";
	echo 'RO features:'.$dev->feature_list()."\n";
	if ($dev->check_snmp_rw()) echo "snmp rw avail\n"; else echo "snmp rw not avail\n";
	echo 'RW features:'.$dev->feature_list()."\n";
	if ($dev->check_telnet()) echo "telnet avail\n"; else echo "telnet not avail\n";*/
	if (!$dev->check_interface_methods(false)) { echo "don't have interface method\n"; return 0; }

	echo "IP: ".$dev->get_ip()."\n";
	echo "Uptime: ".$dev->get_uptime()."\n";
	echo "SysName: ".$dev->get_name()."\n";
	echo "SysLocation: ".$dev->get_location()."\n";
	echo "SysContact: ".$dev->get_contact()."\n";

	if ($dev->check_model()) echo "This is ".$dev->get_model()."\n"; else echo "This is not ".$dev->get_model()."\n";
	$gateway_ip = $dev->get_iproute_default();
	$gateway_mac = $dev->get_arp($gateway_ip);
	echo "Default gateway arp: $gateway_ip/$gateway_mac\n";
	echo "Self mac: ".$dev->get_self_mac()."\n";
	echo "Mgm vlan is: ".$dev->mgm_vlan()."\n";
	echo "Uplink: ".$dev->uplink()."\n";

	echo "Port $port admin state: ".$dev->get_adm_status($port)."\n";
	echo "Port $port oper state: ".$dev->get_oper_status($port)."\n";
	echo "Port $port speed: ".$dev->get_oper_speed($port)."\n";
	echo "Description of ports $port is: ".$dev->get_description($port)."\n";
	echo "Errors of port $port: ".$dev->get_errors($port)."\n";
	echo "Discards of port $port: ".$dev->get_errors($port)."\n";
	echo "Nonunicast of port $port: ".$dev->get_nonunicast_inbound($port).'/'.$dev->get_nonunicast_outbound($port)."\n";
	echo "Unicast of port $port: ".$dev->get_unicast_inbound($port).'/'.$dev->get_unicast_outbound($port)."\n";
	echo "MAC/vlan find: ".$dev->get_port_mac('00:26:5d:cc:5c:cf', 10)."\n";
	echo 'FW VER: '.$dev->get_fw_ver()."\n";
	echo "Full Errors of port $port: ".$dev->get_errors_advanced($port)."\n";
	echo "Full Collisions of port $port: ".$dev->get_collisions($port)."\n";
	echo 'Cable diag: '.$dev->cable_diag($port)."\n";
	echo "LBD global state: ".$dev->get_lbd_state()."\n";
	echo "LBD interval: ".$dev->get_lbd_interval()."\n";
	echo "LBD recover: ".$dev->get_lbd_recover()."\n";
	echo "LBD port $port status: ".$dev->get_lbd_port_adm_state($port)."\n";
	echo "LBD port $port status: ".$dev->get_lbd_port_status($port)."\n";
	$adm_port_state = $dev->get_port_adm_state($port);
	$adm_port_speed = $dev->get_port_adm_speed($port);
	$port_status = $dev->get_port_status($port);
	$port_speed = $dev->get_port_speed($port);



	if (count($adm_port_speed) == 2) $combo = 1; else $combo = 0;
	foreach ($adm_port_speed as $port_type => $v) {
		$port_print = $port;

		if (!strcmp($port_type, 'cooper') && $combo) $port_print = $port." (C)";
		if (!strcmp($port_type, 'fiber') && $combo) $port_print = $port." (F)";

		echo "Adm port state of port ".$port_print." is: ".$adm_port_state[$port_type]."\n";
		echo "Adm port speed of port ".$port_print." is: ".$adm_port_speed[$port_type]."\n";
		echo "Port status of port ".$port_print." is: ".$port_status[$port_type]."\n";
		echo "Port speed of port ".$port_print." is: ".$port_speed[$port_type]."\n";

	}

	echo 'STP Global state: '.$dev->get_stp_state()."\n";
	echo 'STP Version: '.$dev->get_stp_version()."\n";
	echo 'STP FBPDU: '.$dev->get_stp_fbpdu()."\n";
	echo 'STP Root port: '.$dev->get_stp_root_port()."\n";
	echo 'STP Priority: '.$dev->get_stp_priority()."\n";
	echo 'STP Last topology change: '.$dev->get_stp_last_topology_change()."\n";
	echo 'STP Topology changes count: '.$dev->get_stp_topology_changes_count()."\n";
	echo "STP Port $port restricted tcn: ".$dev->get_stp_port_restricted_tcn($port)."\n";
	echo "STP Port $port restricted role: ".$dev->get_stp_port_restricted_role($port)."\n";
	echo "STP Port $port admin edge: ".$dev->get_stp_adm_edge($port)."\n";
	echo "STP Port $port edge status: ".$dev->get_stp_edge($port)."\n";
	echo "STP Port $port fbpdu: ".$dev->get_stp_port_fbpdu($port)."\n";
	echo "STP Port $port role: ".$dev->get_stp_port_role($port)."\n";
	echo "STP Port $port status: ".$dev->get_stp_port_status($port)."\n";
	echo "Port $port PVID: ".$dev->get_port_pvid($port)."\n";
//	if (!$dev->check_fw()) //{
//		echo "Old FW ver\n";
//		if ($dev->save()) echo "Saving success\n"; else { echo "Saving failed\n"; die(); }
//		if ($dev->update()) echo "Update success\n"; else {echo "Update failed\n"; die(); }
//		if ($dev->reboot()) echo "Reboot success\n"; else { echo "Reboot faild\n"; die(); }
//	}
//	if ($dev->download_fw('DES-3526.had')) 	echo "Downloading firmware starting success\n"; else echo "Downloading firmware starting failed\n";
	if ($dev->get_lldp_remo_chassis($port)) echo "LLDP port $port remote chassis ".$dev->get_lldp_remo_chassis($port)."\n";
	if ($dev->get_lldp_remo_port($port)) echo "LLDP port $port remote port ".$dev->get_lldp_remo_port($port)."\n";
	if ($dev->create_vlan(4000)) echo "Vlan 4000 created\n"; else echo "Vlan 4000 not created\n";
	if ($dev->add_vlan_to_port(4000, '1-2,25-26')) echo "Vlan 4000 added tagged to 1-2,25-26\n"; else echo "Vlan 4000 not added tagged to 1-2,25-26\n";
	if ($dev->add_vlan_to_port(4000, 3, 1)) echo "Vlan 4000 added untagged to 3\n"; else echo "Vlan 4000 not added untagged to 3\n";
	if ($dev->delete_vlan_from_port(4000, '1-3')) echo "Vlan 4000 deleted from 1-3\n"; else echo "Vlan 4000 not deleted from 1-3\n";
	if ($dev->delete_vlan(4000)) echo "Vlan 4000 deleted\n"; else echo "Vlan 4000 not deleted\n";
//	if ($dev->config_system_ipif('192.168.0.3/24', 10)) echo "Switch ip changed to 192.168.0.3\n"; else echo "Switch failed\n";
?>
