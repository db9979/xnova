<?php
/**
 * unlocalised.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs f�r XNova-Germany
 * http://www.xnova-germany.org
 */

// ----------------------------------------------------------------------------------------------------------------
//
// Routine pour la gestion de flottes a envoyer
//


if (!defined('INSIDE'))
{
    die();
}

// Calcul de la distance entre 2 planetes
function GetTargetDistance ($OrigGalaxy, $DestGalaxy, $OrigSystem, $DestSystem, $OrigPlanet, $DestPlanet) {
	$distance = 0;

	if (($OrigGalaxy - $DestGalaxy) != 0) {
		$distance = abs($OrigGalaxy - $DestGalaxy) * 20000;
	} elseif (($OrigSystem - $DestSystem) != 0) {
		$distance = abs($OrigSystem - $DestSystem) * 5 * 19 + 2700;
	} elseif (($OrigPlanet - $DestPlanet) != 0) {
		$distance = abs($OrigPlanet - $DestPlanet) * 5 + 1000;
	} else {
		$distance = 5;
	}

	return $distance;
}

// Calcul de la durée de vol d'une flotte par rapport a sa vitesse max
function GetMissionDuration ($GameSpeed, $MaxFleetSpeed, $Distance, $SpeedFactor) {
	$Duration = 0;
	if ($GameSpeed== 1) {
    $GameSpeed= 0.1;
} else  {
    $GameSpeed= $GameSpeed- 1;    
}
	$Duration = round(((35000 / $GameSpeed * sqrt($Distance * 10 / $MaxFleetSpeed) + 10) / $SpeedFactor));

	return $Duration;
}

// Retourne la valeur ajustée de vitesse des flottes
function GetGameSpeedFactor () {
	global $game_config;

	return $game_config['fleet_speed'] / 2500;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la vitesse de la flotte par rapport aux technos du joueur
// Avec prise en compte
function GetFleetMaxSpeed ($FleetArray, $Fleet, $Player) {
	global $reslist, $pricelist;

	if ($Fleet != 0) {
		$FleetArray[$Fleet] =  1;
	}
	foreach ($FleetArray as $Ship => $Count) {
		if ($Ship == 202) {
			if ($Player['impulse_motor_tech'] >= 5) {
				$speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
			} else {
				$speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
			}
		}
		if ($Ship == 203 or $Ship == 204 or $Ship == 209 or $Ship == 210) {
			$speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
		}
		if ($Ship == 205 or $Ship == 206 or $Ship == 208) {
			$speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
		}
		if ($Ship == 211) {
			if ($Player['hyperspace_motor_tech'] >= 8) {
				$speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
			} else {
				$speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
			}
		}
		if ($Ship == 207 or $Ship == 213 or $Ship == 214 or $Ship == 215 or $Ship == 216 or $Ship == 217 or $Ship == 218) {
			$speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
		}
	}
	if ($Fleet != 0) {
		$ShipSpeed = $speedalls[$Ship];
		$speedalls = $ShipSpeed;
	}

	return $speedalls;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de base d'un vaisseau au regard des technologies
function GetShipConsumption ( $Ship, $Player ) {
	global $pricelist;
	if ($Player['impulse_motor_tech'] >= 5) {
		$Consumption  = $pricelist[$Ship]['consumption2'];
	} else {
		$Consumption  = $pricelist[$Ship]['consumption'];
	}

	return $Consumption;
}

// ----------------------------------------------------------------------------------------------------------------
// Calcul de la consommation de la flotte pour cette mission
function GetFleetConsumption ($FleetArray, $SpeedFactor, $MissionDuration, $MissionDistance, $FleetMaxSpeed, $Player) {

	$consumption = 0;
	$basicConsumption = 0;

	foreach ($FleetArray as $Ship => $Count) {
		if ($Ship > 0) {
			$ShipSpeed         = GetFleetMaxSpeed ( "", $Ship, $Player );
			$ShipConsumption   = GetShipConsumption ( $Ship, $Player );
			
			if ($MissionDuration < 1) {
 	            $MissionDuration = 1;
	            }
	         if ($MissionDistance < 1) {
 	            $MissionDistance =1;
	            }
 	         if ($ShipSpeed < 1) {
 	            $ShipSpeed = 1;
 	            }
 	         if ($SpeedFactor == 10) {
 	            $SpeedFactor = 11;
	            }
			
			$spd               = 35000 / ($MissionDuration * $SpeedFactor - 10) * sqrt( $MissionDistance * 10 / $ShipSpeed );
			$basicConsumption  = $ShipConsumption * $Count;
			$consumption      += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
		}
	}

	$consumption = round($consumption) + 1;

	return $consumption;
}

// ----------------------------------------------------------------------------------------------------------------
//
// Mise en forme de chaines pour affichage
//

// Mise en forme de la dur�e sous forme xj xxh xxm xxs
function pretty_time ($seconds) {
    $day = floor($seconds / (24 * 3600));
    $hs = floor($seconds / 3600 % 24);
    $ms = floor($seconds / 60 % 60);
    $sr = floor($seconds / 1 % 60);

    if ($hs < 10) { $hh = "0" . $hs; } else { $hh = $hs; }
    if ($ms < 10) { $mm = "0" . $ms; } else { $mm = $ms; }
    if ($sr < 10) { $ss = "0" . $sr; } else { $ss = $sr; }

    $time = '';
    if ($day != 0) { $time .= $day . 'd '; }    # vorher j, jetzt d > Die Korrektur
    if ($hs  != 0) { $time .= $hh . 'h ';  } else { $time .= '00h '; }
    if ($ms  != 0) { $time .= $mm . 'm ';  } else { $time .= '00m '; }
    $time .= $ss . 's';

    return $time;
}
// Mise en forme de la durée sous forme xxxmin
function pretty_time_hour ($seconds) {
	$min = floor($seconds / 60 % 60);

	$time = '';
	if ($min != 0) { $time .= $min . 'min '; }

	return $time;
}

// Mise en forme du temps de construction (avec la phrase de description)
function ShowBuildTime ($time) {
	global $lang;

	return "<br>". $lang['ConstructionTime'] .": " . pretty_time($time);
}

// ----------------------------------------------------------------------------------------------------------------
//
function add_points ($resources, $userid) {
	return false;
}

function remove_points ($resources, $userid) {
	return false;
}

function get_userdata () {
	return '';
}

// ----------------------------------------------------------------------------------------------------------------
//
// Fonction de lecture / ecriture / exploitation de templates
//
function ReadFromFile($filename) {
	$content = @file_get_contents ($filename);
	return $content;
}

function SaveToFile ($filename, $content) {
	$content = @file_put_contents ($filename, $content);
}

function parsetemplate ($template, $array) {
	return preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
}

function gettemplate ($templatename) {
	global $rocketnova_root_path;

	$filename = $rocketnova_root_path . TEMPLATE_DIR . TEMPLATE_NAME . '/' . $templatename . ".tpl";

	return ReadFromFile($filename);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Gestion de la localisation des chaines
//
function includeLang ($filename, $ext = '.mo') {
	global $rocketnova_root_path, $lang, $user;

	if ($user['lang'] != '') {
		$SelLanguage = $user['lang'];
	} else {
		$SelLanguage = DEFAULT_LANG;
	}
	include ($rocketnova_root_path . "language/". $SelLanguage ."/". $filename.$ext);
}


// ----------------------------------------------------------------------------------------------------------------
//
// Affiche une adresse de depart sous forme de lien
function GetStartAdressLink ( $FleetRow, $FleetType ) {
	$Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$FleetRow['fleet_start_galaxy']."&system=".$FleetRow['fleet_start_system']."\" ". $FleetType ." >";
	$Link .= "[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]</a>";
	return $Link;
}

// Affiche une adresse de cible sous forme de lien
function GetTargetAdressLink ( $FleetRow, $FleetType ) {
	$Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$FleetRow['fleet_end_galaxy']."&system=".$FleetRow['fleet_end_system']."\" ". $FleetType ." >";
	$Link .= "[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]</a>";
	return $Link;
}

// Affiche une adresse de planete sous forme de lien
function BuildPlanetAdressLink ( $CurrentPlanet ) {
	$Link  = "<a href=\"galaxy.php?mode=3&galaxy=".$CurrentPlanet['galaxy']."&system=".$CurrentPlanet['system']."\">";
	$Link .= "[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]</a>";
	return $Link;
}

// Création d'un lien pour le joueur hostile
function BuildHostileFleetPlayerLink ( $FleetRow ) {
	global $lang, $dpath;

	$PlayerName = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '". $FleetRow['fleet_owner']."';", 'users', true);
	$Link  = $PlayerName['username']. " ";
	$Link .= "<a href=\"messages.php?mode=write&id=".$FleetRow['fleet_owner']."\">";
	$Link .= "<img src=\"".$dpath."/img/m.gif\" alt=\"". $lang['ov_message']."\" title=\"". $lang['ov_message']."\" border=\"0\"></a>";
	return $Link;
}

function GetNextJumpWaitTime ( $CurMoon ) {
	global $resource;

	$JumpGateLevel  = $CurMoon[$resource[43]];
	$LastJumpTime   = $CurMoon['last_jump_time'];
	if ($JumpGateLevel > 0) {
		$WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
		$NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;
		if ($NextJumpTime >= time()) {
			$RestWait   = $NextJumpTime - time();
			$RestString = " ". pretty_time($RestWait);
		} else {
			$RestWait   = 0;
			$RestString = "";
		}
	} else {
		$RestWait   = 0;
		$RestString = "";
	}
	$RetValue['string'] = $RestString;
	$RetValue['value']  = $RestWait;

	return $RetValue;
}
// ----------------------------------------------------------------------------------------------------------------
//
// Céation du lien avec popup pour la flotte
function CreateFleetPopupedFleetLink ( $FleetRow, $Texte, $FleetType ) {
	global $lang;

	$FleetRec     = explode(";", $FleetRow['fleet_array']);
	$FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
	$FleetPopup  .= "<table width=200>";
	foreach($FleetRec as $Item => $Group) {
		if ($Group  != '') {
			$Ship    = explode(",", $Group);
			$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
		}
	}
	$FleetPopup  .= "</table>";
	$FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";

	return $FleetPopup;

}

// ----------------------------------------------------------------------------------------------------------------
//
// Céation du lien avec popup pour le type de mission avec ou non les ressources si disponibles
function CreateFleetPopupedMissionLink ( $FleetRow, $Texte, $FleetType ) {
	global $lang;

	$FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
	if ($FleetTotalC <> 0) {
		$FRessource   = "<table width=200>";
		$FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Metal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
		$FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Crystal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
		$FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Deuterium'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
		$FRessource  .= "</table>";
	} else {
		$FRessource   = "";
	}

	if ($FRessource <> "") {
		$MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
		$MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
	} else {
		$MissionPopup  = $Texte ."";
	}

	return $MissionPopup;
}

// ----------------------------------------------------------------------------------------------------------------
//check string lenght whit UTF-8 support
//based on post of: http://oviedos.com.mx/index.php/blog/show/PHP-Problemas-con-strlen-y-UTF8.html
function strlen_utf8 ($str)
{
    $i = 0;
    $count = 0;
    $len = strlen($str);
    while($i < $len)
    {
		$chr = ord($str[$i]);
		$count++;
		$i++;
		if($i >= $len)
			break;
		if($chr & 0x80)
		{
			$chr <<= 1;
			while($chr & 0x80)
			{
			$i++;
			$chr <<= 1;
			}
		}
    }
    return$count;
}
?>