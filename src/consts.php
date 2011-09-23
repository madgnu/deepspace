<?php

global $consts;

$consts = array();
//----------------PROVIDER SPECIFIC--------------------------------------------------------
$consts['TFTP']['IP']							=	'192.168.0.1';
$consts['TFTP']['FIRMWARE']['DES-3000']					=	'DES-3010-firmw.had';
$consts['TFTP']['FIRMWARE']['DES-3028']					=	'DES-3028.had';
$consts['TFTP']['FIRMWARE']['DES-3200']					=	'DES-3200.had';
$consts['TFTP']['FIRMWARE']['DES-3500']					=	'DES-3526.had';

$consts['TFTP']['BOOT']['DES-3000']					=	'DES-3010-boot.had';

$consts['FIRMWARE']['DES-3000']						=	'Build 4.30.B20';
$consts['FIRMWARE']['DES-3028']						=	'Build 2.52.B02';
$consts['FIRMWARE']['DES-3200']						=	'Build 1.21.B007';
$consts['FIRMWARE']['DES-3500']						=	'Build 6.00.B35';
$consts['FIRMWARE']['DES-3800']						=	'Build 4.61.B21';
$consts['FIRMWARE']['DGS-3000']						=	'Build 4.01-B07';
$consts['FIRMWARE']['DGS-3100']						=	'Build 3.60.38';
$consts['FIRMWARE']['DGS-3400']						=	'Build 2.70.B56';
$consts['FIRMWARE']['DGS-3600']						=	'Build 2.55.B05';

$consts['SNMP']['ROCOMM']						= 	'public';
$consts['SNMP']['RWCOMM']						= 	'private';

$consts['NET']['MANAGMENT'][10][0]					=	'192.168.0.0/24';
$consts['NET']['MANAGMENT'][10][1]					=	'192.168.1.0/24';

$consts['NET']['MANAGMENT'][11][0]					=	'192.168.2.0/24';
$consts['NET']['MANAGMENT'][11][1]					=	'192.168.3.0/24';

$consts['SENSOR']['192.168.0.0/24']					=	'SENSOR1';
$consts['SENSOR']['192.168.1.0/24']					=	'SENSOR1';
$consts['SENSOR']['192.168.2.0/24']					=	'SENSOR2';
$consts['SENSOR']['192.168.3.0/24']					=	'SENSOR2';

$consts['TELNET']['AUTH']['BASIC']['login']				=	'localadmin';
$consts['TELNET']['AUTH']['BASIC']['password']				=	'password';

$consts['TELNET']['AUTH']['TACACS']['login']				=	'tacacsadmin';
$consts['TELNET']['AUTH']['TACACS']['password']				=	'password2';

$consts['TELNET']['AUTH']['OLDBASIC']['login']				=	'oldlocaladmin';
$consts['TELNET']['AUTH']['OLDBASIC']['password']			=	'password3';


//----------------SNMP---------------------------------------------------------------------
$consts['SNMP']['SNMPOID']['SysName']					=	'SNMPv2-MIB::sysName';
$consts['SNMP']['SNMPOID']['SysLocation']				=	'SNMPv2-MIB::sysLocation';
$consts['SNMP']['SNMPOID']['SysContact']				=	'SNMPv2-MIB::sysContact';
$consts['SNMP']['SNMPOID']['SysDescr']					=	'SNMPv2-MIB::sysDescr';
$consts['SNMP']['SNMPOID']['SysUptime']					=	'DISMAN-EVENT-MIB::sysUpTimeInstance';
$consts['SNMP']['SNMPOID']['ifAdminStatus']				=	'IF-MIB::ifAdminStatus';
$consts['SNMP']['SNMPOID']['ifOperStatus']				=	'IF-MIB::ifOperStatus';
$consts['SNMP']['SNMPOID']['ifName']					=	'IF-MIB::ifName';
$consts['SNMP']['SNMPOID']['ifIndex']					=	'IF-MIB::ifIndex';
$consts['SNMP']['SNMPOID']['ifAlias']					=	'IF-MIB::ifAlias';
$consts['SNMP']['SNMPOID']['ifSpeed']					=	'IF-MIB::ifSpeed';
$consts['SNMP']['SNMPOID']['ifInErrors']				=	'IF-MIB::ifInErrors';
$consts['SNMP']['SNMPOID']['ifInDiscards']				=	'IF-MIB::ifInDiscards';
$consts['SNMP']['SNMPOID']['ifHCInOctets']				=	'IF-MIB::ifHCInOctets';
$consts['SNMP']['SNMPOID']['ifHCOutOctets']				=	'IF-MIB::ifHCOutOctets';
$consts['SNMP']['SNMPOID']['ifInNUcastPkts']				=	'IF-MIB::ifInNUcastPkts';
$consts['SNMP']['SNMPOID']['ifOutNUcastPkts']				=	'IF-MIB::ifOutNUcastPkts';
$consts['SNMP']['SNMPOID']['ifInUcastPkts']				=	'IF-MIB::ifInUcastPkts';
$consts['SNMP']['SNMPOID']['ifOutUcastPkts']				=	'IF-MIB::ifOutUcastPkts';

$consts['SNMP']['SNMPOID']['ipArp']					=	'IP-MIB::ipNetToMediaPhysAddress';
$consts['SNMP']['SNMPOID']['ipRouteDefault']				=	'SNMPv2-SMI::mib-2.16.19.12.0';
$consts['SNMP']['SNMPOID']['GVRP']					=	'.1.3.6.1.2.1.17.7.1.4.5.1';
$consts['SNMP']['SNMPOID']['dot1qMacList']				=	'.1.3.6.1.2.1.17.7.1.2.2.1.2';
$consts['SNMP']['SNMPOID']['dot1qVlanStaticTable']			=	'.1.3.6.1.2.1.17.7.1.4.3.1';
$consts['SNMP']['SNMPOID']['MacList']					=	'.1.3.6.1.2.1.17.4.3.1.2';

$consts['SNMP']['SNMPOID']['DLink']['ipRouteDefault']			=	'RFC1213-MIB::ipRouteNextHop.0.0.0.0';
$consts['SNMP']['SNMPOID']['DLink']['FwVer']				=	'SNMPv2-SMI::mib-2.16.19.2';
$consts['SNMP']['SNMPOID']['DLink']['CableDiag']			=	'.1.3.6.1.4.1.171.12.58.1.1.1';
$consts['SNMP']['SNMPOID']['DLink']['MgmVlan']				=	'.2.1.2.5.0';

$consts['SNMP']['SNMPOID']['DLink']['LBD']['GlobalState']		=	'.2.21.1.1.0';
$consts['SNMP']['SNMPOID']['DLink']['LBD']['Interval']			=	'.2.21.1.2.0';
$consts['SNMP']['SNMPOID']['DLink']['LBD']['Recover']			=	'.2.21.1.3.0';
$consts['SNMP']['SNMPOID']['DLink']['LBD']['PortAdmState']		=	'.2.21.2.1.1.2';
$consts['SNMP']['SNMPOID']['DLink']['LBD']['PortStatus']		=	'.2.21.2.1.1.4';

$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['AdmState']		=	'.2.2.2.1.3';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['AdmSpeed']		=	'.2.2.2.1.4';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['AdmFlowCtrl']		=	'.2.2.2.1.5';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['Description']		=	'.2.2.2.1.6';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['Learning']		=	'.2.2.2.1.7';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['Notify']		=	'.2.2.2.1.8';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['MulticastFilter']	=	'.2.2.2.1.9';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['AdmMDI']		=	'.2.2.2.1.10';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['Status']		=	'.2.2.1.1.4';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['Speed']		=	'.2.2.1.1.5';
$consts['SNMP']['SNMPOID']['DLink']['PortInfo']['FlowCtrl']		=	'.2.2.1.1.6';

$consts['SNMP']['SNMPOID']['DLink']['STP']['State']			=	'.1.3.6.1.4.1.171.12.15.1.1.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['Version']			=	'.1.3.6.1.4.1.171.12.15.1.2.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['GlobalMaxAge']		=	'.1.3.6.1.4.1.171.12.15.1.3.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['GlobalHelloTime']		=	'.1.3.6.1.4.1.171.12.15.1.4.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['GlobalForwardDelay']	=	'.1.3.6.1.4.1.171.12.15.1.5.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['MaxHops']			=	'.1.3.6.1.4.1.171.12.15.1.6.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['HoldCount']			=	'.1.3.6.1.4.1.171.12.15.1.7.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['FBPDU']			=	'.1.3.6.1.4.1.171.12.15.1.8.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['LBD']			=	'.1.3.6.1.4.1.171.12.15.1.9.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['LBDRecover']		=	'.1.3.6.1.4.1.171.12.15.1.10.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['NNIBPDUAddress']		=	'.1.3.6.1.4.1.171.12.15.1.11.0';
$consts['SNMP']['SNMPOID']['DLink']['STP']['Priority']			=	'.1.3.6.1.4.1.171.12.15.2.3.1.12';
$consts['SNMP']['SNMPOID']['DLink']['STP']['DesignatedRoot']		=	'.1.3.6.1.4.1.171.12.15.2.3.1.13';
$consts['SNMP']['SNMPOID']['DLink']['STP']['RegionalRoot']		=	'.1.3.6.1.4.1.171.12.15.2.3.1.15';
$consts['SNMP']['SNMPOID']['DLink']['STP']['RegionalRootCost']		=	'.1.3.6.1.4.1.171.12.15.2.3.1.16';
$consts['SNMP']['SNMPOID']['DLink']['STP']['Designated']		=	'.1.3.6.1.4.1.171.12.15.2.3.1.17';
$consts['SNMP']['SNMPOID']['DLink']['STP']['RootPort']			=	'.1.3.6.1.4.1.171.12.15.2.3.1.18';
$consts['SNMP']['SNMPOID']['DLink']['STP']['MaxAge']			=	'.1.3.6.1.4.1.171.12.15.2.3.1.19';
$consts['SNMP']['SNMPOID']['DLink']['STP']['ForwardDelay']		=	'.1.3.6.1.4.1.171.12.15.2.3.1.20';
$consts['SNMP']['SNMPOID']['DLink']['STP']['LastTopologyChange']	=	'.1.3.6.1.4.1.171.12.15.2.3.1.21';
$consts['SNMP']['SNMPOID']['DLink']['STP']['TopologyChangeCount']	=	'.1.3.6.1.4.1.171.12.15.2.3.1.22';
$consts['SNMP']['SNMPOID']['DLink']['STP']['HelloTime']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.2';
$consts['SNMP']['SNMPOID']['DLink']['STP']['AdminHelloTime']		=	'.1.3.6.1.4.1.171.12.15.2.4.1.3';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PortState']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.4';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PathCost']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.5';
$consts['SNMP']['SNMPOID']['DLink']['STP']['AdminEdge']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.7';
$consts['SNMP']['SNMPOID']['DLink']['STP']['OperEdge']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.8';
$consts['SNMP']['SNMPOID']['DLink']['STP']['AdminP2P']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.9';
$consts['SNMP']['SNMPOID']['DLink']['STP']['OperP2P']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.10';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PortLBD']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.11';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PortFBPDU']			=	'.1.3.6.1.4.1.171.12.15.2.4.1.12';
$consts['SNMP']['SNMPOID']['DLink']['STP']['RestrictedRole']		=	'.1.3.6.1.4.1.171.12.15.2.4.1.13';
$consts['SNMP']['SNMPOID']['DLink']['STP']['RestrictedTCN']		=	'.1.3.6.1.4.1.171.12.15.2.4.1.14';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PortFBPDUStatus']		=	'.1.3.6.1.4.1.171.12.15.2.4.1.15';
$consts['SNMP']['SNMPOID']['DLink']['STP']['RecoverFBPDU']		=	'.1.3.6.1.4.1.171.12.15.2.4.1.16';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PortDesignated']		=	'.1.3.6.1.4.1.171.12.15.2.5.1.3';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PortStatus']		=	'.1.3.6.1.4.1.171.12.15.2.5.1.6';
$consts['SNMP']['SNMPOID']['DLink']['STP']['PortRole']			=	'.1.3.6.1.4.1.171.12.15.2.5.1.7';

$consts['SNMP']['SNMPOID']['DLink']['GenMgmnt']['Save']			=	'.1.3.6.1.4.1.171.12.1.2.6.0';
$consts['SNMP']['SNMPOID']['DLink']['GenMgmnt']['SaveProgress']		=	'.1.3.6.1.4.1.171.12.1.1.4.0';
$consts['SNMP']['SNMPOID']['DLink']['GenMgmnt']['Reboot']		=	'.1.3.6.1.4.1.171.12.1.2.3.0';
$consts['SNMP']['SNMPOID']['DLink']['GenMgmnt']['TFTP']			=	'.1.3.6.1.4.1.171.12.1.2.1.1';

$consts['SNMP']['SNMPOID']['DES-3000']['FwVer']				=	'SNMPv2-SMI::enterprises.171.12.1.2.7.1.2.257';
$consts['SNMP']['SNMPOID']['DES-3000']['LBD']['GlobalState']		=	'.2.18.1.1.0';
$consts['SNMP']['SNMPOID']['DES-3000']['LBD']['Interval']		=	'.2.18.1.2.0';
$consts['SNMP']['SNMPOID']['DES-3000']['LBD']['Recover']		=	'.2.18.1.3.0';
$consts['SNMP']['SNMPOID']['DES-3000']['LBD']['PortAdmState']		=	'.2.18.2.1.1.2';
$consts['SNMP']['SNMPOID']['DES-3000']['LBD']['PortStatus']		=	'.2.18.2.1.1.4';

$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['AdmState']		=	'.2.2.2.1.2';
$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['AdmSpeed']		=	'.2.2.2.1.3';
$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['AdmFlowCtrl']	=	'.2.2.2.1.4';
$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['Description']	=	'.2.2.2.1.5';
$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['Notify']		=	'.2.2.2.1.7';
$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['AdmMDI']		=	'.2.2.2.1.9';
$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['Status']		=	'.2.2.1.1.4';
$consts['SNMP']['SNMPOID']['DES-3000']['PortInfo']['Speed']		=	'.2.2.1.1.5';

$consts['SNMP']['SNMPOID']['DES-3000']['STP']['Priority']		=	'SNMPv2-SMI::mib-2.17.2.2';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['LastTopologyChange']	=	'SNMPv2-SMI::mib-2.17.2.3';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['TopologyChangeCount']	=	'SNMPv2-SMI::mib-2.17.2.4';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['RootPort']		=	'SNMPv2-SMI::mib-2.17.2.7';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['Version']		=	'SNMPv2-SMI::mib-2.17.2.16.0';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['State']			=	'.2.1.2.6.0';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['FBPDU']			=	'.2.16.1.0';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['PortStatus']		=	'.2.16.4.1.3';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['PortRole']		=	'.2.16.4.1.4';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['PortFBPDU']		=	'.2.16.4.1.5';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['AdminEdge']		=	'.2.16.4.1.8';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['OperEdge']		=	'.2.16.4.1.9';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['AdminP2P']		=	'.2.16.4.1.10';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['OperP2P']		=	'.2.16.4.1.11';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['PathCost']		=	'.2.16.4.1.12';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['RestrictedRole']		=	'.2.16.4.1.15';
$consts['SNMP']['SNMPOID']['DES-3000']['STP']['RestrictedTCN']		=	'.2.16.4.1.16';

$consts['SNMP']['SNMPOID']['DES-3500']['LBD']['GlobalState']		=	'.2.12.1.1.0';
$consts['SNMP']['SNMPOID']['DES-3500']['LBD']['Interval']		=	'.2.12.1.2.0';
$consts['SNMP']['SNMPOID']['DES-3500']['LBD']['Recover']		=	'.2.12.1.3.0';
$consts['SNMP']['SNMPOID']['DES-3500']['LBD']['PortAdmState']		=	'.2.12.2.1.1.2';
$consts['SNMP']['SNMPOID']['DES-3500']['LBD']['PortStatus']		=	'.2.12.2.1.1.4';

$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['AdmState']		=	'.2.4.5.1.4';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['AdmSpeed']		=	'.2.4.5.1.5';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['AdmFlowCtrl']	=	'.2.4.5.1.6';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['Learning']		=	'.2.4.5.1.7';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['Notify']		=	'.2.4.5.1.8';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['MulticastFilter']	=	'.2.4.5.1.9';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['AdmMDI']		=	'.2.4.5.1.10';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['Status']		=	'.2.4.4.1.5';
$consts['SNMP']['SNMPOID']['DES-3500']['PortInfo']['Speed']		=	'.2.4.4.1.6';

$consts['SNMP']['SNMPOID']['DGS-3000']['PortInfo']['AdmState']		=	'.2.3.2.1.3';
$consts['SNMP']['SNMPOID']['DGS-3000']['PortInfo']['AdmSpeed']		=	'.2.3.2.1.4';
$consts['SNMP']['SNMPOID']['DGS-3000']['PortInfo']['AdmFlowCtrl']	=	'.2.3.2.1.5';
$consts['SNMP']['SNMPOID']['DGS-3000']['PortInfo']['Description']	=	'.2.3.2.1.9';
$consts['SNMP']['SNMPOID']['DGS-3000']['PortInfo']['Notify']		=	'.2.3.2.1.7';
$consts['SNMP']['SNMPOID']['DGS-3000']['PortInfo']['Status']		=	'.2.3.1.1.4';
$consts['SNMP']['SNMPOID']['DGS-3000']['PortInfo']['Speed']		=	'.2.3.1.1.5';

$consts['SNMP']['SNMPOID']['DGS-3400']['MgmVlan']			=	'.2.1.2.7.0';
$consts['SNMP']['SNMPOID']['DGS-3400']['PortInfo']['AdmState']		=	'.2.3.2.1.4';
$consts['SNMP']['SNMPOID']['DGS-3400']['PortInfo']['AdmSpeed']		=	'.2.3.2.1.5';
$consts['SNMP']['SNMPOID']['DGS-3400']['PortInfo']['AdmFlowCtrl']	=	'.2.3.2.1.6';
$consts['SNMP']['SNMPOID']['DGS-3400']['PortInfo']['Notify']		=	'.2.3.2.1.8';
$consts['SNMP']['SNMPOID']['DGS-3400']['PortInfo']['Status']		=	'.2.3.1.1.5';
$consts['SNMP']['SNMPOID']['DGS-3400']['PortInfo']['Speed']		=	'.2.3.1.1.6';

$consts['SNMP']['SNMPOID']['DGS-3400']['LBD']['GlobalState']		=	'.2.18.1.1.0';
$consts['SNMP']['SNMPOID']['DGS-3400']['LBD']['Interval']		=	'.2.18.1.2.0';
$consts['SNMP']['SNMPOID']['DGS-3400']['LBD']['Recover']		=	'.2.18.1.3.0';
$consts['SNMP']['SNMPOID']['DGS-3400']['LBD']['PortAdmState']		=	'.2.18.2.1.1.2';
$consts['SNMP']['SNMPOID']['DGS-3400']['LBD']['PortStatus']		=	'.2.18.2.1.1.4';

$consts['SNMP']['SNMPOID']['DGS-3600']['MgmVlan']			=	'.2.1.2.7.0';
$consts['SNMP']['SNMPOID']['DGS-3600']['PortInfo']['AdmState']		=	'.2.3.2.1.4';
$consts['SNMP']['SNMPOID']['DGS-3600']['PortInfo']['AdmSpeed']		=	'.2.3.2.1.5';
$consts['SNMP']['SNMPOID']['DGS-3600']['PortInfo']['AdmFlowCtrl']	=	'.2.3.2.1.6';
$consts['SNMP']['SNMPOID']['DGS-3600']['PortInfo']['Notify']		=	'.2.3.2.1.8';
$consts['SNMP']['SNMPOID']['DGS-3600']['PortInfo']['Status']		=	'.2.3.1.1.5';
$consts['SNMP']['SNMPOID']['DGS-3600']['PortInfo']['Speed']		=	'.2.3.1.1.6';

$consts['SNMP']['SNMPOID']['DGS-3600']['LBD']['GlobalState']		=	'.2.20.1.1.0';
$consts['SNMP']['SNMPOID']['DGS-3600']['LBD']['Interval']		=	'.2.20.1.2.0';
$consts['SNMP']['SNMPOID']['DGS-3600']['LBD']['Recover']		=	'.2.20.1.3.0';
$consts['SNMP']['SNMPOID']['DGS-3600']['LBD']['PortAdmState']		=	'.2.20.2.1.1.2';
$consts['SNMP']['SNMPOID']['DGS-3600']['LBD']['PortStatus']		=	'.2.20.2.1.1.4';


$consts['SNMP']['SNMPOID']['DLink']['ID']				=	'.1.3.6.1.4.1.171';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DES-3000']		=	'.11.63';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DES-3028']		=	'.11.63';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DES-3200']		=	'.11.113.1';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DES-3500']		=	'.11.64';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DGS-3000']		=	'.11.68';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DES-3800']		=	'.11.69';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DGS-3100']		=	'.10.94';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DXS-3300']		=	'.11.59';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DGS-3400']		=	'.11.70';
$consts['SNMP']['SNMPOID']['DLink']['Series']['DGS-3600']		=	'.11.70';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3010F']		=	'.1.1';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3010G']		=	'.1.2';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3018']		=	'.2';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3026']		=	'.3';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3010FL']		=	'.4';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3016']		=	'.10';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3028']		=	'.6';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3028P']		=	'.7';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3052']		=	'.8';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3052P']		=	'.9';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3028G']		=	'.11';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3200-10']		=	'.1';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3200-18']		=	'.2';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3200-28']		=	'.3';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3200-28F']		=	'.4';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3200-26']		=	'.5';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3526']		=	'.1';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3550']		=	'.2';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3828']		=	'.1';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3828DC']		=	'.2';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3828P']		=	'.3';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3852']		=	'.4';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DES-3852P']		=	'.5';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3024']		=	'.1';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3048']		=	'.2'; //?? May be, or may not be, i dont really sure

$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3100-24']		=	'.89';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DXS-3324SRi']		=	'.4';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DXS-3324SR']		=	'.5';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DXS-3352SR']		=	'.6';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DXS-3326GSR']		=	'.7';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DXS-3350SR']		=	'.8';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3426']		=	'.1';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3427']		=	'.2';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3450']		=	'.3';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3426P']		=	'.7';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3426G']		=	'.11';

$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3650']		=	'.5';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3627']		=	'.6';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3627G']		=	'.8';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3612G']		=	'.9';
$consts['SNMP']['SNMPOID']['DLink']['Models']['DGS-3612']		=	'.10';

$consts['SNMP']['SNMPOID']['DES-3226S']['FwVer']			=	'.1.3.6.1.4.1.171.11.48.1.1.1.1.1.1';
//$consts['SNMP']['SNMPOID']['DES-3226S']['BootVer']			=	'.1.3.6.1.4.1.171.11.48.1.1.1.1.1.2.0';
//$consts['SNMP']['SNMPOID']['DES-3226S']['HwVer']			=	'.1.3.6.1.4.1.171.11.48.1.1.1.1.1.3.0';

//$consts['SNMP']['SNMPOID']['DGS-3400']['FwVer']			=	'.2.1.1.5.0';

$consts['SNMP']['SNMPOID']['DGS-3100']['FwVer']				=	'.1.3.6.1.4.1.171.10.94.89.89.2.4';
$consts['SNMP']['SNMPOID']['DGS-3100']['SelfMac']			=	'.1.3.6.1.2.1.2.2.1.6.100000';
$consts['SNMP']['SNMPOID']['DGS-3100']['ipRouteDefault']		=	'IP-FORWARD-MIB::ipCidrRouteNextHop.0.0.0.0.0.0.0.0.0';

//$consts['SNMP']['SNMPOID']['DGS-3600']['FwVer']			=	'.2.1.1.5.0';
//$consts['SNMP']['SNMPOID']['DGS-3600']['BootVer']			=	'.2.1.1.4.0';

$consts['SNMP']['SNMPOID']['Cisco']['PhysEntry']			=	'SNMPv2-SMI::mib-2.47.1.1.1.1';
$consts['SNMP']['SNMPOID']['Cisco']['MacBridgeEntry']			=	'SNMPv2-SMI::mib-2.17.1.4.1.2';
$consts['SNMP']['SNMPOID']['Cisco']['VlanList']				=	'.1.3.6.1.4.1.9.9.46.1.3.1.1';
$consts['SNMP']['SNMPOID']['Cisco']['TrunkVlans']			=	'.1.3.6.1.4.1.9.9.46.1.6.1.1';
$consts['SNMP']['SNMPOID']['Cisco']['AccessVlans']			=	'.1.3.6.1.4.1.9.9.68.1.2.2.1';


$consts['SNMP']['SNMPOID']['EdgeCore']['ipRouteDefault']		=	'IP-FORWARD-MIB::ipCidrRouteNextHop.0.0.0.0.0.0.0.0.0';

$consts['SNMP']['SNMPOID']['Zyxel']['ipRouteDefault']			=	'RFC1213-MIB::ipRouteNextHop.0.0.0.0';
$consts['SNMP']['SNMPOID']['Zyxel']['SelfMac']				=	'IF-MIB::ifPhysAddress.1';

$consts['SNMP']['SNMPOID']['RMON']['Drops']				=	'.1.3.6.1.2.1.16.1.1.1.3';
$consts['SNMP']['SNMPOID']['RMON']['CRCErr']				=	'.1.3.6.1.2.1.16.1.1.1.8';
$consts['SNMP']['SNMPOID']['RMON']['Undersize']				=	'.1.3.6.1.2.1.16.1.1.1.9';
$consts['SNMP']['SNMPOID']['RMON']['Oversize']				=	'.1.3.6.1.2.1.16.1.1.1.10';
$consts['SNMP']['SNMPOID']['RMON']['Fragment']				=	'.1.3.6.1.2.1.16.1.1.1.11';
$consts['SNMP']['SNMPOID']['RMON']['Jabber']				=	'.1.3.6.1.2.1.16.1.1.1.12';
$consts['SNMP']['SNMPOID']['RMON']['Collision']				=	'.1.3.6.1.2.1.16.1.1.1.13';
$consts['SNMP']['SNMPOID']['RMON']['CollSingle']			=	'.1.3.6.1.2.1.10.7.2.1.4';
$consts['SNMP']['SNMPOID']['RMON']['CollLate']				=	'.1.3.6.1.2.1.10.7.2.1.8';
$consts['SNMP']['SNMPOID']['RMON']['CollExcessive']			=	'.1.3.6.1.2.1.10.7.2.1.9';

$consts['SNMP']['SNMPOID']['LLDP']['RemoteData']			=	'.1.0.8802.1.1.2.1.4.1.1';

$consts['SNMP']['SNMPOUT']['Switch']['AdmStatus'][0]			=	'Disabled';
$consts['SNMP']['SNMPOUT']['Switch']['AdmStatus'][1]			=	'Enabled';

$consts['SNMP']['SNMPOUT']['Switch']['OperStatus'][0]			=	'LinkDown';
$consts['SNMP']['SNMPOUT']['Switch']['OperStatus'][1]			=	'LinkUp';

$consts['SNMP']['SNMPOUT']['Switch']['Speed'][0]			=	'LinkDown';
$consts['SNMP']['SNMPOUT']['Switch']['Speed'][10000000]			=	'10M';
$consts['SNMP']['SNMPOUT']['Switch']['Speed'][100000000]		=	'100M';
$consts['SNMP']['SNMPOUT']['Switch']['Speed'][1000000000]		=	'1G';
$consts['SNMP']['SNMPOUT']['Switch']['Speed'][10000000000]		=	'10G';


$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][0]			=	'OK';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][1]			=	'open';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][2]			=	'short';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][3]			=	'open short';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][4]			=	'crosstalk';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][5]			=	'unknown';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][6]			=	'count';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][7]			=	'no cable';
$consts['SNMP']['SNMPOUT']['DLink']['CableDiag'][8]			=	'other';

$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['State'][1]		= 	'ERROR';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['State'][2]		= 	'Disabled';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['State'][3]		= 	'Enabled';

$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Status'][1]		= 	'ERROR';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Status'][2]		= 	'LinkUp';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Status'][3]		= 	'LinkDown';

$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][1]		=	'LinkDown';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][2]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][3]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][4]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][5]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][6]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][7]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][8]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['Speed'][9]		=	'1G/Full';

$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][1]		=	'Auto';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][2]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][3]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][4]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][5]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][6]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][7]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][8]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DLink']['PortInfo']['AdmSpeed'][9]		=	'1G/Full';

$consts['SNMP']['SNMPOUT']['DLink']['LBD']['GlobalState'][1]		=	'Enabled';
$consts['SNMP']['SNMPOUT']['DLink']['LBD']['GlobalState'][2]		=	'Disabled';

$consts['SNMP']['SNMPOUT']['DLink']['LBD']['PortAdmState'][1]		=	'Enabled';
$consts['SNMP']['SNMPOUT']['DLink']['LBD']['PortAdmState'][2]		=	'Disabled';

$consts['SNMP']['SNMPOUT']['DLink']['LBD']['PortStatus'][1]		=	'Normal';
$consts['SNMP']['SNMPOUT']['DLink']['LBD']['PortStatus'][2]		=	'Loop';
$consts['SNMP']['SNMPOUT']['DLink']['LBD']['PortStatus'][3]		=	'ERROR';
$consts['SNMP']['SNMPOUT']['DLink']['LBD']['PortStatus'][4]		=	'None';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['State'][1]			=	'ERROR';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['State'][2]			=	'Disabled';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['State'][3]			=	'Enabled';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['Version'][0]		=	'STP';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['Version'][1]		=	'RSTP';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['Version'][2]		=	'MSTP';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['FBPDU'][1]			=	'ERROR';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['FBPDU'][2]			=	'Disabled';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['FBPDU'][3]			=	'Enabled';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['RestrictedTCN'][1]		=	'True';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['RestrictedTCN'][2]		=	'False';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['RestrictedRole'][1]		=	'True';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['RestrictedRole'][2]		=	'False';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['AdminEdge'][1]		=	'True';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['AdminEdge'][2]		=	'False';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['AdminEdge'][3]		=	'Auto';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['Edge'][1]			=	'True';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['Edge'][2]			=	'False';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['Edge'][3]			=	'Auto';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortFBPDU'][1]		=	'ERROR';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortFBPDU'][2]		=	'Disabled';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortFBPDU'][3]		=	'Enabled';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortFBPDU'][4]		=	'Bpdufilter';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][0]		=	'Disabled';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][1]		=	'Alternate';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][2]		=	'Backup';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][3]		=	'Root';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][4]		=	'Designated';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][5]		=	'Master';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][6]		=	'NonSTP';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortRole'][7]		=	'Loopback';

$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][1]		=	'ERROR';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][2]		=	'Disabled';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][3]		=	'Discarding';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][4]		=	'Learning';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][5]		=	'Forwarding';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][6]		=	'Broken';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][7]		=	'NonSTP';
$consts['SNMP']['SNMPOUT']['DLink']['STP']['PortStatus'][8]		=	'Err-Disabled';

$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][1]		=	'LinkDown';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][2]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][3]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][4]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][5]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][6]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][7]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][8]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][9]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][10]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][11]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][12]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['Speed'][13]		=	'1G/Half';

$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['AdmSpeed'][1]	=	'Auto';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['AdmSpeed'][2]	=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['AdmSpeed'][3]	=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['AdmSpeed'][4]	=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['AdmSpeed'][5]	=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DES-3000']['PortInfo']['AdmSpeed'][7]	=	'1G/Full';

$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['Version'][0]		=	'STP';
$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['Version'][2]		=	'RSTP';

$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['PortRole'][1]		=	'Disabled';
$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['PortRole'][2]		=	'Alternate';
$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['PortRole'][3]		=	'Backup';
$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['PortRole'][4]		=	'Root';
$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['PortRole'][5]		=	'Designated';
$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['PortRole'][6]		=	'NonSTP';
$consts['SNMP']['SNMPOUT']['DES-3000']['STP']['PortRole'][7]		=	'Loopback';

$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][0]		=	'ERROR';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][1]		=	'Empty';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][2]		=	'LinkDown';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][3]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][4]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][5]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][6]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][7]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][8]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['Speed'][9]		=	'10G/Full';

$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][1]	=	'ERROR';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][2]	=	'Auto';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][3]	=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][4]	=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][5]	=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][6]	=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][7]	=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DES-3500']['PortInfo']['AdmSpeed'][8]	=	'1G/Full';

$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][0]		=	'ERROR';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][1]		=	'Empty';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][2]		=	'LinkDown';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][3]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][4]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][5]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][6]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][7]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['Speed'][8]		=	'1G/Full';

$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][1]	=	'ERROR';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][2]	=	'Auto';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][3]	=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][4]	=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][5]	=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][6]	=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][9]	=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3000']['PortInfo']['AdmSpeed'][10]	=	'1G/Full';

$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][0]		=	'LinkDown';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][1]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][2]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][3]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][4]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][5]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][6]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][7]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][8]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][9]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][10]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][11]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][12]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][13]		=	'10G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][14]		=	'10G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][15]		=	'10G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][16]		=	'10G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][17]		=	'Empty';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['Speed'][18]		=	'LinkDown';

$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][1]	=	'ERROR';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][2]	=	'Auto';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][3]	=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][4]	=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][5]	=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][6]	=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][8]	=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][9]	=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3400']['PortInfo']['AdmSpeed'][10]	=	'1G/Full';

$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][0]		=	'LinkDown';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][1]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][2]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][3]		=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][4]		=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][5]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][6]		=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][7]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][8]		=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][9]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][10]		=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][11]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][12]		=	'1G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][13]		=	'10G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][14]		=	'10G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][15]		=	'10G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][16]		=	'10G/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][17]		=	'Empty';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['Speed'][18]		=	'LinkDown';

$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][1]	=	'ERROR';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][2]	=	'Auto';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][3]	=	'10M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][4]	=	'10M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][5]	=	'100M/Half';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][6]	=	'100M/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][8]	=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][9]	=	'1G/Full';
$consts['SNMP']['SNMPOUT']['DGS-3600']['PortInfo']['AdmSpeed'][10]	=	'1G/Full';

$consts['FEATURES']['GENERAL']['NetDevice']				=	':ping:';
$consts['FEATURES']['GENERAL']['Switch']				=	':snmp:';

$consts['FEATURES']['SNMPRO']['Switch']					=	':ifmib:';
$consts['FEATURES']['SNMPRO']['DLink']					=	'';
$consts['FEATURES']['SNMPRO']['Zyxel']					=	':genmgmt:mac:gvrp:rmon:';
$consts['FEATURES']['SNMPRO']['DES-3000']				=	':vlan:genmgmt:mac:lldp:rmon:fwver:stp:lbd:portinfo:';
$consts['FEATURES']['SNMPRO']['DES-3028']				=	':vlan:genmgmt:mac:lldp:gvrp:rmon:fwver:stp:lbd:portinfo:';
$consts['FEATURES']['SNMPRO']['DES-3200']				=	':vlan:genmgmt:mac:lldp:gvrp:rmon:fwver:stp:lbd:portinfo:';
$consts['FEATURES']['SNMPRO']['DES-3500']				=	':vlan:genmgmt:mac:lldp:gvrp:rmon:fwver:stp:lbd:portinfo:';
$consts['FEATURES']['SNMPRO']['DES-3800']				=	':genmgmt:mac:gvrp:rmon:fwver:';
$consts['FEATURES']['SNMPRO']['DGS-3000']				=	':vlan:genmgmt:mac:gvrp:rmon:fwver:portinfo:';
$consts['FEATURES']['SNMPRO']['DGS-3100']				=	':genmgmt:mac:lldp:gvrp:rmon:fwver:';
$consts['FEATURES']['SNMPRO']['DXS-3300']				=	':genmgmt:mac:gvrp:rmon:';
$consts['FEATURES']['SNMPRO']['DGS-3400']				=	':vlan:genmgmt:mac:lldp:gvrp:rmon:fwver:stp:lbd:portinfo:';
$consts['FEATURES']['SNMPRO']['DGS-3600']				=	':vlan:genmgmt:mac:lldp:gvrp:rmon:fwver:stp:lbd:portinfo:';
$consts['FEATURES']['SNMPRO']['Cisco']					=	':genmgmt:mac:';
$consts['FEATURES']['SNMPRO']['EdgeCore']				=	':genmgmt:mac:';

$consts['FEATURES']['SNMPRW']['DES-3000']				=	':save:reboot:cdiag:';
$consts['FEATURES']['SNMPRW']['DES-3028']				=	':save:reboot:cdiag:';
$consts['FEATURES']['SNMPRW']['DES-3200']				=	':save:reboot:cdiag:';
$consts['FEATURES']['SNMPRW']['DES-3500']				=	':save:reboot:cdiag:';
$consts['FEATURES']['SNMPRW']['DGS-3400']				=	':save:reboot:';
$consts['FEATURES']['SNMPRW']['DGS-3600']				=	':save:reboot:';
$consts['FEATURES']['TELNET']['DES-3000']				=	':ifmgmt:fwmgmt:vlanmgmt:';
$consts['FEATURES']['TELNET']['DES-3028']				=	':ifmgmt:fwmgmt:vlanmgmt:';
$consts['FEATURES']['TELNET']['DES-3200']				=	':ifmgmt:fwmgmt:vlanmgmt:';
$consts['FEATURES']['TELNET']['DES-3500']				=	':ifmgmt:fwmgmt:vlanmgmt:';
$consts['FEATURES']['TELNET']['DGS-3400']				=	':vlanmgmt:';
$consts['FEATURES']['TELNET']['DGS-3600']				=	':vlanmgmt:';



$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3010G']		=	511;			//0111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3010F']		=	511;			//0111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3010FL']		=	511;			//0111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3016']		=	65535;			//1111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3018']		=	65535;			//001111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3026']		=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3028']		=	268435455;		//1111111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3028P']		=	268435455;		//1111111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3028G']		=	268435455;		//1111111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3052']		=	4503599627370495;	//1x52
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3052P']		=	4503599627370495;	//1x52
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3200-28']		=	268435455;		//1111111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3200-26']		=	67108863;		//11111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3200-18']		=	262143;			//111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3200-10']		=	1023;			//1111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3526']		=	67108863;		//11111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3550']		=	1125899906842623;	//1x50
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3828']		=	268435455;		//1111111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3828P']		=	268435455;		//1111111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3828DC']		=	268435455;		//1111111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3852']		=	4503599627370495;	//1x52
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DES-3852P']		=	4503599627370495;	//1x52
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3024']		=	16777215;		//111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3048']		=	281474976710655;	//1x48
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3426']		=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3426G']		=	15728640;		//00111100000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3426P']		=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3427']		=	16777215;		//000111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3450']		=	281474976710655;	//001x48
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3612']		=	4095;			//111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3612G']		=	3840;			//111100000000
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3627']		=	16777215;		//000111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3627G']		=	15728640;		//000111100000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['COOPER']['DGS-3650']		=	281474976710655;	//001x48

$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3010G']		=	512;			//1000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3010F']		=	512;			//1000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3010FL']		=	512;			//1000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3016']		=	0;			//0000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3018']		=	0;			//000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3026']		=	0;			//00000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3028']		=	50331648;		//0011000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3028P']		=	50331648;		//0011000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3028G']		=	251658240;		//1111000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3052']		=	844424930131968;	//00110x48
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3052P']		=	844424930131968;	//00110x48
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3200-28']		=	251658240;		//1111000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3200-26']		=	50331648;		//11000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3200-18']		=	196608;			//110000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3200-10']		=	768;			//1100000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3526']		=	50331648;		//11000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3550']		=	844424930131968;	//110x48
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3828']		=	50331648;		//0011000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3828P']		=	50331648;		//0011000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3828DC']		=	50331648;		//0011000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3852']		=	844424930131968;	//00110x48
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DES-3852P']		=	844424930131968;	//00110x48
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3024']		=	0;			//dirty hack, fix me
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3048']		=	0;			//dirty hack, fix me
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3426']		=	15728640;		//00111100000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3426G']		=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3426P']		=	15728640;		//00111100000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3427']		=	15728640;		//000111100000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3450']		=	263882790666240;	//0011110x44
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3450']		=	263882790666240;	//0011110x44
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3612']		=	3840;			//111100000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3612G']		=	4095;			//111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3627']		=	15728640;		//000111100000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3627G']		=	16777215;		//000111111111111111111111111
$consts['HARDWARE']['SWITCH']['DLINK']['FIBER']['DGS-3650']		=	263882790666240;	//0011110x44

$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3010G']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3010F']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3010FL']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3016']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3018']		=	196608;			//110000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3026']		=	50331648;		//11000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3028']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3028P']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3028G']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3052']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3052P']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3200-28']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3200-26']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3200-18']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3200-10']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DES-3526']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3426']		=	50331648;		//11000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3426G']		=	50331648;		//11000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3426P']		=	50331648;		//11000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3427']		=	117440512;		//111000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3450']		=	844424930131968;	//110x48
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3612']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3612G']		=	0;
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3627']		=	117440512;		//111000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3627G']		=	117440512;		//111000000000000000000000000
$consts['HARDWARE']['SWITCH']['DLINK']['SLOT']['DGS-3650']		=	844424930131968;	//110x48

$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3010G']			=	255;			//0011111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3010F']			=	255;			//0011111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3010FL']			=	255;			//0011111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3016']			=	65535;			//1111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3018']			=	65535;			//001111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3026']			=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3028']			=	16777215;		//0000111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3028P']			=	16777215;		//0000111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3028G']			=	16777215;		//0000111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3052']			=	281474976710655;	//1x48
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3052P']			=	281474976710655;	//1x48
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3200-28']			=	16777215;		//0000111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3200-26']			=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3200-18']			=	65535;			//001111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3200-10']			=	255;			//0011111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3526']			=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DES-3550']			=	281474976710655;	//1x48
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3426']			=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3426G']			=	15728640;		//00111100000000000000000000
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3426P']			=	16777215;		//00111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3427']			=	16777215;		//000111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3450']			=	281474976710655;	//001x48
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3612']			=	4095;			//111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3612G']			=	3840;			//111100000000
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3627']			=	16777215;		//000111111111111111111111111
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3627G']			=	15728640;		//000111100000000000000000000
$consts['HARDWARE']['SWITCH']['CDIAG']['DGS-3650']			=	281474976710655;	//001x48

$consts['HARDWARE']['SERIES']['DES-3010G']				=	'DES-3000';
$consts['HARDWARE']['SERIES']['DES-3010F']				=	'DES-3000';
$consts['HARDWARE']['SERIES']['DES-3010FL']				=	'DES-3000';
$consts['HARDWARE']['SERIES']['DES-3016']				=	'DES-3000';
$consts['HARDWARE']['SERIES']['DES-3018']				=	'DES-3000';
$consts['HARDWARE']['SERIES']['DES-3026']				=	'DES-3000';
$consts['HARDWARE']['SERIES']['DES-3028']				=	'DES-3028';
$consts['HARDWARE']['SERIES']['DES-3028P']				=	'DES-3028';
$consts['HARDWARE']['SERIES']['DES-3028G']				=	'DES-3028';
$consts['HARDWARE']['SERIES']['DES-3052']				=	'DES-3028';
$consts['HARDWARE']['SERIES']['DES-3052P']				=	'DES-3028';
$consts['HARDWARE']['SERIES']['DES-3200-28']				=	'DES-3200';
$consts['HARDWARE']['SERIES']['DES-3200-26']				=	'DES-3200';
$consts['HARDWARE']['SERIES']['DES-3200-18']				=	'DES-3200';
$consts['HARDWARE']['SERIES']['DES-3200-10']				=	'DES-3200';
$consts['HARDWARE']['SERIES']['DES-3526']				=	'DES-3500';
$consts['HARDWARE']['SERIES']['DES-3550']				=	'DES-3500';
$consts['HARDWARE']['SERIES']['DES-3828']				=	'DES-3800';
$consts['HARDWARE']['SERIES']['DES-3828P']				=	'DES-3800';
$consts['HARDWARE']['SERIES']['DES-3828DC']				=	'DES-3800';
$consts['HARDWARE']['SERIES']['DES-3852']				=	'DES-3800';
$consts['HARDWARE']['SERIES']['DES-3852P']				=	'DES-3800';
$consts['HARDWARE']['SERIES']['DGS-3024']				=	'DGS-3000';
$consts['HARDWARE']['SERIES']['DGS-3048']				=	'DGS-3000';
$consts['HARDWARE']['SERIES']['DGS-3100-24']				=	'DGS-3100';
$consts['HARDWARE']['SERIES']['DXS-3324SRi']				=	'DXS-3300';
$consts['HARDWARE']['SERIES']['DXS-3324SR']				=	'DXS-3300';
$consts['HARDWARE']['SERIES']['DXS-3352SR']				=	'DXS-3300';
$consts['HARDWARE']['SERIES']['DXS-3326GSR']				=	'DXS-3300';
$consts['HARDWARE']['SERIES']['DXS-3350SR']				=	'DXS-3300';
$consts['HARDWARE']['SERIES']['DGS-3426']				=	'DGS-3400';
$consts['HARDWARE']['SERIES']['DGS-3426G']				=	'DGS-3400';
$consts['HARDWARE']['SERIES']['DGS-3426P']				=	'DGS-3400';
$consts['HARDWARE']['SERIES']['DGS-3427']				=	'DGS-3400';
$consts['HARDWARE']['SERIES']['DGS-3450']				=	'DGS-3400';
$consts['HARDWARE']['SERIES']['DGS-3612']				=	'DGS-3600';
$consts['HARDWARE']['SERIES']['DGS-3612G']				=	'DGS-3600';
$consts['HARDWARE']['SERIES']['DGS-3627']				=	'DGS-3600';
$consts['HARDWARE']['SERIES']['DGS-3627G']				=	'DGS-3600';
$consts['HARDWARE']['SERIES']['DGS-3650']				=	'DGS-3600';
$consts['HARDWARE']['SERIES']['DIR-100']				=	'NetDevice';


global $snmp_oids;
global $snmp_out;
snmp_set_quick_print(true);
$snmp_oids = &$consts['SNMP']['SNMPOID'];
$snmp_out = &$consts['SNMP']['SNMPOUT'];
?>
