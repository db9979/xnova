<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

$dpath     = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

includeLang('fleet');
       $fleet_group_mr = 0;
	   $fleetgroup = 0;
       $fleetgroup = $_POST['fleet_group'];
	   if  (!ctype_digit ($fleetgroup)){
        message ($lang['no_er_ress'] );
       }		
	   

        if($_POST['fleet_group'] > 0){

                if($_POST['mission'] == 2){

                        $target = "g".$_POST["galaxy"]."s".$_POST["system"]."p".$_POST["planet"]."t".$_POST["planettype"];
                        if($_POST['acs_target_mr'] == $target){

                                $aks_count_mr = doquery("SELECT * FROM {{table}} WHERE id = '".$_POST['fleet_group']."'",'aks');
                                if (mysql_num_rows($aks_count_mr) > 0) {
                                        $fleet_group_mr = $_POST['fleet_group'];
                                }
                        }
                }
        }

        if(($_POST['fleet_group'] == 0) && ($_POST['mission'] == 2)){
                $_POST['mission'] = 1;
        }


        $CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."'", 'planets', true);
        $TargetPlanet  = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". $_POST['galaxy'] ."' AND `system` = '". $_POST['system'] ."' AND `planet` = '". $_POST['planet'] ."' AND `planet_type` = '". $_POST['planettype'] ."';", 'planets', true);
        $MyDBRec       = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['id']."';", 'users', true);

        $protection      = $game_config['noobprotection'];
        $protectiontime  = $game_config['noobprotectiontime'];
        $protectionmulti = $game_config['noobprotectionmulti'];
        if ($protectiontime < 1) {
                $protectiontime = 9999999999999999;
        }

        $fleetarray  = unserialize(base64_decode(str_rot13($_POST["usedfleet"])));

        if (!is_array($fleetarray)) {
                message ("<font color=\"red\"><b>". $lang['fl_fleet_err'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        // On verifie s'il y a assez de vaisseaux sur la planete !
        foreach ($fleetarray as $Ship => $Count) {
                if ($Count > $CurrentPlanet[$resource[$Ship]]) {
                        message ("<font color=\"red\"><b>". $lang['fl_fleet_err'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
        }
        // Flottenangaben auf ganze Zahl prüfen
        $error              = 0;
        $galaxy             = ($_POST['galaxy']);
		   if  (!ctype_digit ($galaxy)){
           message ($lang['no_er_ress'] );
		   }
        $system             = ($_POST['system']);
		     if  (!ctype_digit ($system)){
           message ($lang['no_er_ress'] );
		   }
        $planet             = ($_POST['planet']);
		    if  (!ctype_digit ($planet)){
           message ($lang['no_er_ress'] );
		   }
        $planettype         = ($_POST['planettype']);
		    if  (!ctype_digit ($planettype)){
           message ($lang['no_er_ress'] );
		   }
        $fleetmission       = $_POST['mission'];
		    if  (!ctype_digit ($fleetmission)){
           message ($lang['no_er_ress'] );
		   }
 
        // Überprüfung Flotte Ende
		 if ($_POST['resource1'] + $_POST['resource2'] + $_POST['resource3'] + $_POST['resource4']< 1 AND $_POST['mission'] == 3) {
            message("<font color=\"lime\"><b>".$lang['fl_noenoughtgoods']."</b></font>", $lang['type_mission'][3], "fleet." . $phpEx, 1);
           }
        //Recourcenüberprüfung ob nur ganze Zahl
	    $met = 0;
	    $crist = 0;
	    $deut = 0;
		$appol = 0;
				
	    $met = $_POST['resource1']  ;
	    $crist = $_POST['resource2'] ;
	    $deut = $_POST['resource3'] ;
      	$appol = $_POST['resource4'];
		
        if  (!ctype_digit ($met)){
        message ($lang['no_er_ress'] );		
	    }else{
	    round($_POST['resource1']);
	    }
   	    if  (!ctype_digit ($crist)){
        message ($lang['no_er_ress'] );
	    }else{
	    round($_POST['resource2']);
	    }
        if  (!ctype_digit ($deut)){
        message ($lang['no_er_ress'] );
	   }else{
	   round($_POST['resource3']);
       }
	    if  (!ctype_digit ($appol)){
        message ($lang['no_er_ress'] );
	   }else{
	   round($_POST['resource4']);
       }
       //Überprüfung Ende
	


        if ($planettype != 1 && $planettype != 2 && $planettype != 3) {
                message ("<font color=\"red\"><b>". $lang['fl_fleet_err_pl'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        if ($fleetmission == 8) {
                $YourPlanet = false;
                $UsedPlanet = false;
                $select     = doquery("SELECT * FROM {{table}} WHERE galaxy = '". $galaxy ."' AND system = '". $system ."' AND planet = '". $planet ."'", "planets");
        } else {
                $YourPlanet = false;
                $UsedPlanet = false;
                $select     = doquery("SELECT * FROM {{table}} WHERE galaxy = '". $galaxy ."' AND system = '". $system ."' AND planet = '". $planet ."' AND planet_type = '". $planettype ."'", "planets");
        }

        if ($CurrentPlanet['galaxy'] == $galaxy &&
                $CurrentPlanet['system'] == $system &&
                $CurrentPlanet['planet'] == $planet &&
                $CurrentPlanet['planet_type'] == $planettype) {
                message ("<font color=\"red\"><b>". $lang['fl_ownpl_err'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        // Test d'existance de l'enregistrement dans la gaalxie !
        if ($_POST['mission'] != 15) {
                if (mysql_num_rows($select) < 1 && $fleetmission != 7) {
                        message ("<font color=\"red\"><b>". $lang['fl_unknow_target'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                } elseif ($fleetmission == 9 && mysql_num_rows($select) < 1) {
                        message ("<font color=\"red\"><b>". $lang['fl_used_target'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
        } else {
            $EnvoiMaxExpedition = $_POST['maxepedition'];
            $Expedition         = $_POST['curepedition'];

            if       ($EnvoiMaxExpedition == 0 ) {
                        message ("<font color=\"red\"><b>". $lang['fl_expe_notech'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                } elseif ($Expedition >= $EnvoiMaxExpedition ) {
                        message ("<font color=\"red\"><b>". $lang['fl_expe_max'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
        }

        $select = mysql_fetch_array($select);

        if ($select['id_owner'] == $user['id']) {
                $YourPlanet = true;
                $UsedPlanet = true;
        } elseif (!empty($select['id_owner'])) {
                $YourPlanet = false;
                $UsedPlanet = true;
        } else {
                $YourPlanet = false;
                $UsedPlanet = false;
        }

        // Determinons les type de missions possibles par rapport a la planete cible
        if ($fleetmission == 15) {
                // Gestion des Exp�ditions
                $missiontype = array(15 => $lang['type_mission'][15]);
        } else {
                if ($_POST['planettype'] == "2") {
                        if (($_POST['ship209'] >= 1 || $_POST['ship219']) >= 1) {
                                $missiontype = array(8 => $lang['type_mission'][8]);
                        } else {
                                $missiontype = array();
                        }
                } elseif ($_POST['planettype'] == "1" || $_POST['planettype'] == "3") {
                        if ($_POST['ship208'] >= 1 && !$UsedPlanet) {
                                $missiontype = array(7 => $lang['type_mission'][7]);
        } elseif ($_POST['ship202'] == 0 &&
            $_POST['ship203'] == 0 &&
            $_POST['ship204'] == 0 &&
            $_POST['ship205'] == 0 &&
            $_POST['ship206'] == 0 &&
            $_POST['ship207'] == 0 &&
            $_POST['ship208'] == 0 &&
            $_POST['ship209'] == 0 &&
            $_POST['ship210'] >= 1 &&
            $_POST['ship211'] == 0 &&
            $_POST['ship213'] == 0 &&
            $_POST['ship214'] == 0 &&
            $_POST['ship215'] == 0 &&
                        $_POST['ship216'] == 0 &&
                        $_POST['ship217'] == 0 &&
                        $_POST['ship218'] == 0 &&
                        $_POST['ship219'] == 0 &&
             !$YourPlanet) {
            $missiontype = array(6 => $lang['type_mission'][6]);
        }

                        if ($_POST['ship202'] >= 1 ||
                                $_POST['ship203'] >= 1 ||
                                $_POST['ship204'] >= 1 ||
                                $_POST['ship205'] >= 1 ||
                                $_POST['ship206'] >= 1 ||
                                $_POST['ship207'] >= 1 ||
                                $_POST['ship211'] >= 1 ||
                                $_POST['ship213'] >= 1 ||
                                $_POST['ship214'] >= 1 ||
                                $_POST['ship215'] >= 1 ||
                                $_POST['ship216'] >= 1 ||
                                $_POST['ship217'] >= 1 ||
                                $_POST['ship218'] >= 1 ||
                                $_POST['ship219'] >= 1) {
                                if (!$YourPlanet) {
                                        $missiontype[1] = $lang['type_mission'][1];
                                }
                                $missiontype[3] = $lang['type_mission'][3];
                                $missiontype[5] = $lang['type_mission'][5];
                        }


                } elseif ($_POST['ship209'] >= 1 || $_POST['ship208']) {
                        $missiontype[3] = $lang['type_mission'][3];
                }
                if ($YourPlanet)
                        $missiontype[4] = $lang['type_mission'][4];

/*
                if ( $_POST['planettype'] == 3 &&
                        ($_POST['ship214']         ||
                         $_POST['ship213'])        &&
                         !$YourPlanet              &&
                         $UsedPlanet) {
                        $missiontype[2] = $lang['type_mission'][2];
                }
*/
                if (($_POST['planettype'] == 3 || $_POST['planettype'] == 1) && ($fleet_group_mr > 0) && ($UsedPlanet)) {
                        $missiontype[2] = $lang['type_mission'][2];
                }
        if ( $_POST['planettype'] == 3 &&
             (($_POST['ship214'] || $_POST['ship218']) >= 1)    &&
           !$YourPlanet            &&
           $UsedPlanet) {
          $missiontype[9] = $lang['type_mission'][9];
        }
        }

        if (empty($missiontype[$fleetmission])) {
                message ("<font color=\"red\"><b>". $lang['fl_bad_mission'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }
    if($game_config['attack_disabled'] == 1  AND $_POST['mission'] == 1) {
             message ("<font color=\"red\"><b>". $lang['fl_Angriffssperre']  ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
    }
        if($game_config['attack_disabled'] == 1  AND $_POST['mission'] == 2) {
             message ("<font color=\"red\"><b>". $lang['fl_Angriffssperre']  ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
    }
        CheckPlanetUsedFields($CurrentPlanet);

        if ($TargetPlanet['id_owner'] == '') {
                $HeDBRec = $MyDBRec;
        } elseif ($TargetPlanet['id_owner'] != '') {
                $HeDBRec = doquery("SELECT * FROM {{table}} WHERE `id` = '". $TargetPlanet['id_owner'] ."';", 'users', true);
        }

$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $MyDBRec['id'] ."';", 'statpoints', true);
$User2Points   = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $HeDBRec['id'] ."';", 'statpoints', true);
$User2Inaktivitaet  = doquery("SELECT * FROM {{table}} WHERE `inaktivitaet` = '1' AND `id` = '".$HeDBRec['id'] ."';", 'users', true);

$MyGameLevel  = $UserPoints['total_points'];
$HeGameLevel  = $User2Points['total_points'];
$VacationMode = $HeDBRec['urlaubs_modus'];
$Inaktivitaet = $User2Inaktivitaet['inaktivitaet'];
/*
if ($MyGameLevel > ($HeGameLevel * $protectionmulti) AND
$TargetPlanet['id_owner'] != '' AND
$_POST['mission'] == 1  AND
$protection       == 1  AND
$HeGameLevel < ($protectiontime * 1000) AND
$Inaktivitaet == 0) {
message("<font color=\"lime\"><b>".$lang['fl_noob_mess_n']."</b></font>", $lang['fl_noob_title'], "fleet." . $phpEx, 2);
}

if ($MyGameLevel > ($HeGameLevel * $protectionmulti) AND
$TargetPlanet['id_owner'] != '' AND
$_POST['mission'] == 5  AND
$protection       == 1  AND
$HeGameLevel < ($protectiontime * 1000) AND
$Inaktivitaet == 0) {
message("<font color=\"lime\"><b>".$lang['fl_noob_mess_n']."</b></font>", $lang['fl_noob_title'], "fleet." . $phpEx, 2);
}

if ($MyGameLevel > ($HeGameLevel * $protectionmulti) AND
$TargetPlanet['id_owner'] != '' AND
$_POST['mission'] == 6  AND
$protection       == 1  AND
$HeGameLevel < ($protectiontime * 1000) AND
$Inaktivitaet == 0) {
message("<font color=\"lime\"><b>".$lang['fl_noob_mess_n']."</b></font>", $lang['fl_noob_title'], "fleet." . $phpEx, 2);
}

if (($MyGameLevel * $protectionmulti) < $HeGameLevel AND
$TargetPlanet['id_owner'] != '' AND
$_POST['mission'] == 1  AND
$protection       == 1  AND
$MyGameLevel < ($protectiontime * 1000) AND
$Inaktivitaet == 0) {
message("<font color=\"lime\"><b>".$lang['fl_noob_mess_n']."</b></font>", $lang['fl_noob_title'], "fleet." . $phpEx, 2);
}

if (($MyGameLevel * $protectionmulti) < $HeGameLevel AND
$TargetPlanet['id_owner'] != '' AND
$_POST['mission'] == 5  AND
$protection       == 1  AND
$MyGameLevel < ($protectiontime * 1000) AND
$Inaktivitaet == 0) {
message("<font color=\"lime\"><b>".$lang['fl_noob_mess_n']."</b></font>", $lang['fl_noob_title'], "fleet." . $phpEx, 2);
}

if (($MyGameLevel * $protectionmulti) < $HeGameLevel AND
$TargetPlanet['id_owner'] != '' AND
$_POST['mission'] == 6  AND
$protection       == 1  AND
$MyGameLevel < ($protectiontime * 1000) AND
$Inaktivitaet == 0) {
message("<font color=\"lime\"><b>".$lang['fl_noob_mess_n']."</b></font>", $lang['fl_noob_title'], "fleet." . $phpEx, 2);
}
*/
if ($HeDBRec['onlinetime'] >= (time()-60 * 60 * 24 * 7)){
        if ($MyGameLevel > ($HeGameLevel * $protectionmulti) && ($_POST['mission'] == 1 || $_POST['mission'] == 9) &&  $TargetPlanet['id_owner'] != '' && $protection == 1 && $HeGameLevel < ($protectiontime * 1000)) {
            message("<font color=\"lime\"><b>".$lang['fl_noob_mess_n']."</b></font>", $lang['fl_noob_title'], "fleet.php", 2);
        }

        if (($MyGameLevel * $protectionmulti) < $HeGameLevel && ($_POST['mission'] == 1 || $_POST['mission'] == 5 || $_POST['mission'] == 9) &&  $TargetPlanet['id_owner'] != '' && $protection == 1 && $MyGameLevel < ($protectiontime * 1000)) {
            message("<font color=\"lime\"><b>Spieler ist zu stark!</b></font>", $lang['fl_noob_title'], "fleet.php", 2);
        }

    }

        if ($VacationMode AND $_POST['mission'] != 8) {
                message("<font color=\"lime\"><b>".$lang['fl_vacation_pla']."</b></font>", $lang['fl_vacation_ttl'], "fleet." . $phpEx, 2);
        }

        $FlyingFleets = mysql_fetch_assoc(doquery("SELECT COUNT(fleet_id) as Number FROM {{table}} WHERE `fleet_owner`='{$user['id']}'", 'fleets'));
        $ActualFleets = $FlyingFleets["Number"];
     if ((1  + ($user[$resource[108]])  +   ( ($user[$resource[611]]) * 3)) <= $ActualFleets){
        message("Alle Flottenslots belegt!", "Fehler", "fleet." . $phpEx, 1);
    }

        if ($_POST['resource1'] + $_POST['resource2'] + $_POST['resource3']+ $_POST['resource4'] < 1 AND $_POST['mission'] == 3) {
                message("<font color=\"lime\"><b>".$lang['fl_noenoughtgoods']."</b></font>", $lang['type_mission'][3], "fleet." . $phpEx, 1);
        }
        if ($_POST['mission'] != 15) {
                if ($TargetPlanet['id_owner'] == '' AND $_POST['mission'] < 7) {
                        message ("<font color=\"red\"><b>". $lang['fl_bad_planet01'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
                if ($TargetPlanet['id_owner'] != '' AND $_POST['mission'] == 7) {
                        message ("<font color=\"red\"><b>". $lang['fl_bad_planet02'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
                if ($HeDBRec['ally_id'] != $MyDBRec['ally_id'] AND $_POST['mission'] == 4) {
                        message ("<font color=\"red\"><b>". $lang['fl_dont_stay_here'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
                if ($TargetPlanet['ally_deposit'] < 1 AND $HeDBRec != $MyDBRec AND $_POST['mission'] == 5) {
                        message ("<font color=\"red\"><b>". $lang['fl_no_allydeposit'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
                if (($TargetPlanet["id_owner"] == $CurrentPlanet["id_owner"]) AND ($_POST["mission"] == 1)) {
                        message ("<font color=\"red\"><b>". $lang['fl_no_self_attack'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
                if (($TargetPlanet["id_owner"] == $CurrentPlanet["id_owner"]) AND ($_POST["mission"] == 6)) {
                        message ("<font color=\"red\"><b>". $lang['fl_no_self_spy'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }
                if (($TargetPlanet["id_owner"] != $CurrentPlanet["id_owner"]) AND ($_POST["mission"] == 4)) {
                        message ("<font color=\"red\"><b>". $lang['fl_only_stay_at_home'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
                }

        }

        $missiontype = array(
                1 => $lang['type_mission'][1],
                2 => $lang['type_mission'][2],
                3 => $lang['type_mission'][3],
                4 => $lang['type_mission'][4],
                5 => $lang['type_mission'][5],
                6 => $lang['type_mission'][6],
                7 => $lang['type_mission'][7],
                8 => $lang['type_mission'][8],
                9 => $lang['type_mission'][9],
                15 => $lang['type_mission'][15],
                );

        $speed_possible = array(10, 9, 8, 7, 6, 5, 4, 3, 2, 1);

        $AllFleetSpeed  = GetFleetMaxSpeed ($fleetarray, 0, $user);
        $GenFleetSpeed  = $_POST['speed'];
        $SpeedFactor    = $_POST['speedfactor'];
        $MaxFleetSpeed  = min($AllFleetSpeed);

        if (!in_array($GenFleetSpeed, $speed_possible)) {
                message ("<font color=\"red\"><b>". $lang['fl_cheat_speed'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        $CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);

        if ($MaxFleetSpeed != $_POST['speedallsmin']) {
                message ("<font color=\"red\"><b>". $lang['fl_cheat_speed'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        if (!$_POST['planettype']) {
                message ("<font color=\"red\"><b>". $lang['fl_no_planet_type'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        // Test de coherance de la destination (voir si elle se trouve dans les limites de l'univers connu
        $error     = 0;
        $errorlist = "";
        if (!$_POST['galaxy'] || !is_numeric($_POST['galaxy']) || $_POST['galaxy'] > MAX_GALAXY_IN_WORLD|| $_POST['galaxy'] < 1) {
                $error++;
                $errorlist .= $lang['fl_limit_galaxy'];
        }
        if (!$_POST['system'] || !is_numeric($_POST['system']) || $_POST['system'] > MAX_SYSTEM_IN_GALAXY || $_POST['system'] < 1) {
                $error++;
                $errorlist .= $lang['fl_limit_system'];
        }
        if (!$_POST['planet'] || !is_numeric($_POST['planet']) || $_POST['planet'] > MAX_PLANET_IN_SYSTEM || $_POST['planet'] < 1) {
                $error++;
                $errorlist .= $lang['fl_limit_planet'];
        }

        if ($error > 0) {
                message ("<font color=\"red\"><ul>" . $errorlist . "</ul></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        // La flotte part bien de la planete courrante ??
        if ($_POST['thisgalaxy'] != $CurrentPlanet['galaxy'] |
                $_POST['thissystem'] != $CurrentPlanet['system'] |
                $_POST['thisplanet'] != $CurrentPlanet['planet'] |
                $_POST['thisplanettype'] != $CurrentPlanet['planet_type']) {
                message ("<font color=\"red\"><b>". $lang['fl_cheat_origine'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        if (!isset($fleetarray)) {
                message ("<font color=\"red\"><b>". $lang['fl_no_fleetarray'] ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        $distance      = GetTargetDistance ( $_POST['thisgalaxy'], $_POST['galaxy'], $_POST['thissystem'], $_POST['system'], $_POST['thisplanet'], $_POST['planet'] );
        $duration      = GetMissionDuration ( $GenFleetSpeed, $MaxFleetSpeed, $distance, $SpeedFactor );
        $consumption   = GetFleetConsumption ( $fleetarray, $SpeedFactor, $duration, $distance, $MaxFleetSpeed, $user );

     $fleet['start_time'] = $duration + time();
     if ($_POST['mission'] == 15) {
        $StayDuration    = $_POST['expeditiontime'] * 3600;
        $StayTime        = $fleet['start_time'] + $_POST['expeditiontime'] * 3600;
    } elseif ($_POST['mission'] == 5) {
        $StayDuration    = $_POST['holdingtime'] * 3600;
        $StayTime        = $fleet['start_time'] + $_POST['holdingtime'] * 3600;
    } else {
        $StayDuration    = 0;
        $StayTime        = 0;
    }
    $fleet['end_time']   = $StayDuration + (2 * $duration) + time();
    $FleetStorage        = 0;
    $FleetShipCount      = 0;
    $fleet_array         = "";
    $FleetSubQRY         = "";

        foreach ($fleetarray as $Ship => $Count) {
                $FleetStorage    += $pricelist[$Ship]["capacity"] * $Count;
                $FleetShipCount  += $Count;
                $fleet_array     .= $Ship .",". $Count .";";
                $FleetSubQRY     .= "`".$resource[$Ship] . "` = `" . $resource[$Ship] . "` - " . $Count . " , ";
        }

        $FleetStorage        -= $consumption;
        $StorageNeeded        = 0;
        if ($_POST['resource1'] < 1) {
                $TransMetal      = 0;
        } else {
                $TransMetal      = $_POST['resource1'];
                $StorageNeeded  += $TransMetal;
        }
        if ($_POST['resource2'] < 1) {
                $TransCrystal    = 0;
        } else {
                $TransCrystal    = $_POST['resource2'];
                $StorageNeeded  += $TransCrystal;
        }
        if ($_POST['resource3'] < 1) {
                $TransDeuterium  = 0;
        } else {
                $TransDeuterium  = $_POST['resource3'];
                $StorageNeeded  += $TransDeuterium;
        }
        if ($_POST['resource4'] < 1) {
                $TransAppolonium  = 0;
        } else {
                $TransAppolonium  = $_POST['resource4'];
                $StorageNeeded  += $TransAppolonium;
        }
        $StockMetal       = $CurrentPlanet['metal'];
        $StockCrystal     = $CurrentPlanet['crystal'];
        $StockDeuterium   = $CurrentPlanet['deuterium'];
		$StockAppolonium  = $CurrentPlanet['appolonium'];
        $StockDeuterium -= $consumption;

        $StockOk         = false;
        if ($StockMetal >= $TransMetal) {
                if ($StockCrystal >= $TransCrystal) {
                        if ($StockDeuterium >= $TransDeuterium) {
                             if ($StockAppolonium >= $TransAppolonium) {
                                $StockOk         = true;
                              }
                        }
                }
	    }	
        if ( !$StockOk ) {
                message ("<font color=\"red\"><b>". $lang['fl_noressources'] . pretty_number($consumption) ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }
        if ( $StorageNeeded > $FleetStorage) {
                message ("<font color=\"red\"><b>". $lang['fl_nostoragespa'] . pretty_number($StorageNeeded - $FleetStorage) ."</b></font>", $lang['fl_error'], "fleet." . $phpEx, 2);
        }

        if ($TargetPlanet['id_level'] > $user['authlevel']) {
                $Allowed = true;
                switch ($_POST['mission']){
                        case 1:
                        case 2:
                        case 6:
                        case 9:
                                $Allowed = false;
                                break;
                        case 3:
                        case 4:
                        case 5:
                        case 7:
                        case 8:
                        case 15:
                                break;
                        default:
                }
                if ($Allowed == false) {
                        message ("<font color=\"red\"><b>". $lang['fl_adm_attak'] ."</b></font>", $lang['fl_warning'], "fleet." . $phpEx, 2);
                }
        }
        if ($fleet_group_mr != 0) { // Si c'est une AG
        $AksStartTime = mysql_fetch_array(doquery("SELECT MAX(`fleet_start_time`) AS Start, MAX(`fleet_end_time`) AS End FROM {{table}} WHERE `fleet_group` = '". $fleet_group_mr . "';", 'fleets'));

        if ($AksStartTime['Start'] > $fleet['start_time']) {
            $fleet['start_time'] = $AksStartTime['Start'] + 1;
            $fleet['end_time'] = $AksStartTime['End'] + 1;
        } else {
            $AksTime = mysql_fetch_array(doquery("SELECT fleet_start_time, fleet_end_time FROM {{table}} WHERE `fleet_group` = '". $fleet_group_mr . "' AND `fleet_mission` = '1';", 'fleets'));

            if ($AksTime['fleet_start_time'] < $fleet['start_time']) {
                $QryUpdateFleets = "UPDATE {{table}} SET ";
                $QryUpdateFleets .= "`fleet_start_time` = '". $fleet['start_time'] ."', ";
                $QryUpdateFleets .= "`fleet_end_time` = '". $fleet['end_time'] ."' ";
                $QryUpdateFleets .= "WHERE ";
                $QryUpdateFleets .= "`fleet_group` = '". $fleet_group_mr ."' AND ";
                $QryUpdateFleets .= "`fleet_mission` = '1';";
                doquery($QryUpdateFleets, "fleets");
                $SelectFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_group` = '". $fleet_group_mr . "' AND `fleet_mission` = '2' ORDER BY `fleet_id` ASC ;", 'fleets');
                $nb = mysql_num_rows($SelectFleets);
                $i = 0;
                if ($nb > 0) {
                    while ($row = mysql_fetch_array($SelectFleets)) {
                        $i++;
                        $row['fleet_start_time'] = $fleet['start_time'] + $i;
                        $row['fleet_end_time'] = $fleet['end_time'] + $i;
                        $QryUpdateFleets = "UPDATE {{table}} SET ";
                           $QryUpdateFleets .= "`fleet_start_time` = '". $row['fleet_start_time'] ."', ";
                          $QryUpdateFleets .= "`fleet_end_time` = '". $row['fleet_end_time'] ."' ";
                           $QryUpdateFleets .= "WHERE ";
                           $QryUpdateFleets .= "`fleet_id` = '". $row['fleet_id'] ."';";
                           doquery($QryUpdateFleets, "fleets");
                    }
                }

                $fleet['start_time'] = $fleet['start_time'] + $nb + 1;
                $fleet['end_time'] = $fleet['end_time'] + $nb + 1;
            }
        }
    }

     
	  
        $QryInsertFleet  = "INSERT INTO {{table}} SET ";
        $QryInsertFleet .= "`fleet_owner` = '". $user['id'] ."', ";
        $QryInsertFleet .= "`fleet_mission` = '". $_POST['mission'] ."', ";
        $QryInsertFleet .= "`fleet_amount` = '". $FleetShipCount ."', ";
        $QryInsertFleet .= "`fleet_array` = '". $fleet_array ."', ";
        $QryInsertFleet .= "`fleet_start_time` = '". $fleet['start_time'] ."', ";
        $QryInsertFleet .= "`fleet_start_galaxy` = '". intval($_POST['thisgalaxy']) ."', ";
        $QryInsertFleet .= "`fleet_start_system` = '". intval($_POST['thissystem']) ."', ";
        $QryInsertFleet .= "`fleet_start_planet` = '". intval($_POST['thisplanet']) ."', ";
        $QryInsertFleet .= "`fleet_start_type` = '". intval($_POST['thisplanettype']) ."', ";
        $QryInsertFleet .= "`fleet_end_time` = '". $fleet['end_time'] ."', ";
        $QryInsertFleet .= "`fleet_end_stay` = '". $StayTime ."', ";
        $QryInsertFleet .= "`fleet_end_galaxy` = '". intval($_POST['galaxy']) ."', ";
        $QryInsertFleet .= "`fleet_end_system` = '". intval($_POST['system']) ."', ";
        $QryInsertFleet .= "`fleet_end_planet` = '". intval($_POST['planet']) ."', ";
        $QryInsertFleet .= "`fleet_end_type` = '". intval($_POST['planettype']) ."', ";
        $QryInsertFleet .= "`fleet_resource_metal` = '". $TransMetal ."', ";
        $QryInsertFleet .= "`fleet_resource_crystal` = '". $TransCrystal ."', ";
        $QryInsertFleet .= "`fleet_resource_deuterium` = '". $TransDeuterium ."', ";
		$QryInsertFleet .= "`fleet_resource_appolonium` = '". $TransAppolonium ."', ";
        $QryInsertFleet .= "`fleet_target_owner` = '". $TargetPlanet['id_owner'] ."', ";
        $QryInsertFleet .= "`fleet_group` = '". $fleet_group_mr ."', ";
        $QryInsertFleet .= "`start_time` = '". time() ."';";
        doquery( $QryInsertFleet, 'fleets');


        $CurrentPlanet["metal"]     = $CurrentPlanet["metal"] - $TransMetal;
        $CurrentPlanet["crystal"]   = $CurrentPlanet["crystal"] - $TransCrystal;
        $CurrentPlanet["deuterium"] = $CurrentPlanet["deuterium"] - $TransDeuterium;
        $CurrentPlanet["deuterium"] = $CurrentPlanet["deuterium"] - $consumption;
		$CurrentPlanet["appolonium"] = $CurrentPlanet["appolonium"] - $TransAppolonium;

        $QryUpdatePlanet  = "UPDATE {{table}} SET ";
        $QryUpdatePlanet .= $FleetSubQRY;
        $QryUpdatePlanet .= "`metal` = '". $CurrentPlanet["metal"] ."', ";
        $QryUpdatePlanet .= "`crystal` = '". $CurrentPlanet["crystal"] ."', ";
        $QryUpdatePlanet .= "`deuterium` = '". $CurrentPlanet["deuterium"] ."', ";
		$QryUpdatePlanet .= "`appolonium` = '". $CurrentPlanet["appolonium"] ."' ";
        $QryUpdatePlanet .= "WHERE ";
        $QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."'";

        doquery("LOCK TABLE {{table}} WRITE", 'planets');
        doquery ($QryUpdatePlanet, "planets");
        doquery("UNLOCK TABLES", '');

        $page  = "<br><div><center>";
        $page .= "<table border=\"0\" cellpadding=\"0\" cellspacing=\"1\" width=\"519\">";
        $page .= "<tr height=\"20\">";
        $page .= "<td class=\"c\" colspan=\"2\"><span class=\"success\">". $lang['fl_fleet_send'] ."</span></td>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_mission'] ."</th>";
        $page .= "<th>". $missiontype[$_POST['mission']] ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_dist'] ."</th>";
        $page .= "<th>". pretty_number($distance) ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_speed'] ."</th>";
        $page .= "<th>". ($_POST['speedallsmin']) ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_deute_need'] ."</th>";
        $page .= "<th>". pretty_number($consumption) ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_from'] ."</th>";
        $page .= "<th>". $_POST['thisgalaxy'] .":". $_POST['thissystem']. ":". $_POST['thisplanet'] ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_dest'] ."</th>";
        $page .= "<th>". $_POST['galaxy'] .":". $_POST['system'] .":". $_POST['planet'] ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_time_go'] ."</th>";
        $page .= "<th>". date("M D d H:i:s", $fleet['start_time']) ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<th>". $lang['fl_time_back'] ."</th>";
        $page .= "<th>". date("M D d H:i:s", $fleet['end_time']) ."</th>";
        $page .= "</tr><tr height=\"20\">";
        $page .= "<td class=\"c\" colspan=\"2\">". $lang['fl_title'] ."</td>";

        foreach ($fleetarray as $Ship => $Count) {
                $page .= "</tr><tr height=\"20\">";
                $page .= "<th>". $lang['tech'][$Ship] ."</th>";
                $page .= "<th>". pretty_number($Count) ."</th>";
        }
        $page .= "</tr></table></div></center>";

        // Provisoire
        sleep (1);

        $planetrow = doquery ("SELECT * FROM {{table}} WHERE `id` = '". $CurrentPlanet['id'] ."';", 'planets', true);

        display($page, $lang['fl_title']);

// Updated by Chlorel. 16 Jan 2008 (String extraction, bug corrections, code uniformisation
// Updated by -= MoF =- for Deutsches Ugamela Forum
// 06.12.2007 - 08:39
// Open Source
// (c) by MoF

?>