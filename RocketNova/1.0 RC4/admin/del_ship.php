<?php

/**
 * del_ship.php
 *
 * @version 1.0
 * @Copyright 2008 by Xire -AlteGarde-
 */


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);


	if ($user['authlevel'] >= 2) {
		includeLang('admin');
		$mode      = $_POST['mode'];
		$PageTpl   = gettemplate("admin/del_ship");
		$parse     = $lang;
		if ($mode == 'addit') {
			$id          = $_POST['id'];
			$light_hunter       = $_POST['light_hunter'];
			$heavy_hunter    = $_POST['heavy_hunter'];
			$small_ship_cargo        = $_POST['small_ship_cargo'];
			$big_ship_cargo        = $_POST['big_ship_cargo'];
			$crusher    = $_POST['crusher'];
			$battle_ship        = $_POST['battle_ship'];
			$colonizer      = $_POST['colonizer'];
			$recycler        = $_POST['recycler'];
			$spy_sonde       = $_POST['spy_sonde'];
			$bomber_ship      = $_POST['bomber_ship'];
	    		$solar_satelit     = $_POST['solar_satelit'];
	    		$destructor       = $_POST['destructor'];
	    		$dearth_star       = $_POST['dearth_star'];
	    		$battleship      = $_POST['battleship'];
	    		$ownshipname       = $_POST['ownshipname'];
	    		$ev_transporter       = $_POST['ev_transporter'];
	    		$star_crasher      = $_POST['star_crasher'];
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` - '". $small_ship_cargo ."', ";
			$QryUpdatePlanet .= "`battleship` = `battleship` - '". $battleship ."', ";
			$QryUpdatePlanet .= "`dearth_star` = `dearth_star` - '". $dearth_star ."', ";
			$QryUpdatePlanet .= "`destructor` = `destructor` - '". $destructor ."', ";
			$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` - '". $solar_satelit ."', ";
			$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` - '". $bomber_ship ."', ";
			$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` - '". $spy_sonde ."', ";
			$QryUpdatePlanet .= "`recycler` = `recycler` - '". $recycler ."', ";
			$QryUpdatePlanet .= "`colonizer` = `colonizer` - '". $colonizer ."', ";
			$QryUpdatePlanet .= "`battle_ship` = `battle_ship` - '". $battle_ship ."', ";
			$QryUpdatePlanet .= "`crusher` = `crusher` - '". $crusher ."', ";
			$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` - '". $heavy_hunter ."', ";
			$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` - '". $big_ship_cargo ."', ";
			$QryUpdatePlanet .= "`light_hunter` = `light_hunter` - '". $light_hunter ."', ";
			$QryUpdatePlanet .= "`ownshipname` = `ownshipname` - '". $ownshipname."', ";
			$QryUpdatePlanet .= "`ev_transporter` = `ev_transporter` - '". $ev_transporter."', ";
			$QryUpdatePlanet .= "`star_crasher` = `star_crasher` - '". $star_crasher."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( $lang['adm_delship2'], $lang['adm_delship1'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>