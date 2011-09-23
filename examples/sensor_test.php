#! /usr/bin/php

<?php
/*
	Example of using sensor class. It was created for add managment to dlink switches.
	Sensor - is a direct-connected pc to l2-segment.
*/
require_once('../src/csensor.php');

$sensor = new CSensor('eth1', 'localhost');
$mac		= '00:19:5c:89:f1:f5';
$default_ip	= '10.90.90.90';
$default_net	= '10.90.90.89/30';
$vlan		= '10';
if ($sensor->create_vlan_interface($vlan)) echo "Interface-vlan $vlan created\n";
else {echo "Interface to vlan $vlan NOT created\n"; die(); }
if ($sensor->add_addr_to_vlan_interface($default_net, $vlan)) echo "Address $default_net added to interface-vlan $vlan\n";
else { echo "Address $default_net NOT added to vlan $vlan interface\n"; die(); }
if ($sensor->set_arp($default_ip, $mac)) echo "arp $default_ip/$mac created\n";
else { echo "arp $default_ip/$mac NOT created\n"; die(); }
if ($sensor->destroy_vlan_interface($vlan)) echo "Interface-vlan $vlan destroyed\n";
else {echo "Interface-vlan $vlan NOT destroyed\n"; die(); }
?>
