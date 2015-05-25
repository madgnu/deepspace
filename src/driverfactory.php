<?php

require_once('consts.php');
require_once('cswitch.php');
require_once('cdlink.php');
require_once('cdlinkdes3000.php');
require_once('cdlinkdgs3000.php');
require_once('cdlink3100.php');
require_once('cdlink3226s.php');
require_once('cdlink3500.php');
require_once('cdlink3600.php');
require_once('cdlink1210.php');
require_once('ccisco.php');
require_once('czyxel.php');
require_once('ch3c.php');
require_once('cedgecore.php');


class CSwitchDriverFactory {

	protected function create_driver($ip, $model, $vendor = 0) {
		global $consts;
		$hw_ser = &$consts['HARDWARE']['SERIES'];
		$series = 0;
		if (isset($hw_ser[$model])) $series = $hw_ser[$model];
		if ($vendor == 'D-link') $vendor = 'D-Link'; //Дерти хак, чо (из-за DXS)

		if ($vendor == 'D-Link') {
			switch ($series) {
				case 'DES-3000': return new CDlinkDes3000($ip, $series, $model); break;
				case 'DES-3500': return new CDlink3500($ip, $series, $model); break;
				case 'DGS-3024': return new CDlinkDes3000($ip, $series, $model); break;
				case 'DGS-3100': return new CDlink3100($ip, $series, $model); break;
				case 'DGS-3000': return new CDlinkDgs3000($ip, $series, $model); break;
				case 'DGS-3400': return new CDlink3600($ip, $series, $model); break;
				case 'DGS-3600': return new CDlink3600($ip, $series, $model); break;
				case 'DGS-3200': return new CDlink3600($ip, $series, $model); break;
				case 'DES-1210': return new CDlink1210($ip, $series, $model); break;
				case 'DGS-1210': return new CDlink1210($ip, $series, $model); break;
				case 'NetDevice': return new CNetDevice($ip); break;
				default: return new CDlink($ip, $series, $model); break;
			}
		} elseif ($vendor == 'Cisco') {
			return new CCisco($ip, $series, $model);
		} elseif ($vendor == 'Zyxel') {
			return new CZyxel($ip, $vendor, $model);
		} elseif ($vendor == 'Edge-Core') {
			return new CEdgeCore($ip, $vendor, $model);
		} elseif ($vendor == 'H3COM') {
			return new CH3C($ip, $vendor, $model);
		} else {
			return new CSwitch($ip);
		}
		
	}

	public function get_driver($ip, $model, $vendor) {
		return $this->create_driver($ip, $model, $vendor); //for future use
	}

}

global $switch_drivers;
$switch_drivers = new CSwitchDriverFactory;

?>
