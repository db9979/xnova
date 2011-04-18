<?php

/**
 * GetBuildingTimeWhithoutTechs
 *
 * @copyright 2009 by Steggi for Xnova-reloaded.de
+
 */

// Zeitberechnung f�r die urspr�ngliche Bau bzw Forschungszeit (die Techwerte werden hierbei nicht ber�cksichtigt)
// $user       -> Der User selber
// $planet     -> Der Planet, wo das Element (Geb�ude, Forschung, Fleet,Deff) hin soll
// $Element    -> Element was man haben will
function GetBuildingTimeWithoutTechs ($user, $planet, $Element) {
	global $pricelist, $resource, $reslist, $game_config;


	$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
	if       (in_array($Element, $reslist['build'])) {
		// F�r Gebaude wird diese Formel benutzt
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$time         = ((($cost_crystal) + ($cost_metal)) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	} elseif (in_array($Element, $reslist['tech'])) {
		//und f�r Forschung diese Formel
		$cost_metal   = floor($pricelist[$Element]['metal']   * pow($pricelist[$Element]['factor'], $level));
		$cost_crystal = floor($pricelist[$Element]['crystal'] * pow($pricelist[$Element]['factor'], $level));
		$time         = (($cost_metal + $cost_crystal) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	} elseif (in_array($Element, $reslist['defense'])) {
		//Feste Bauzeiten f�r Fleet und Deff. Zeitverk�rzung durch Roboterfabrik, und Nanitenfabrik
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	} elseif (in_array($Element, $reslist['fleet'])) {
		$time         = (($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) / ($game_config['game_speed'] * 2500));
		$time         = floor($time * 60 * 60);
	}
	//Wenn die Bauzeit kleiner als 1 ist, ist sie wieder 1, um instantbauten zu verhindern
	if ($time < 1)
	$time = 1;

	return $time;
}
?>