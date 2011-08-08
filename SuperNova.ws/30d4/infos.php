<?php

/**
 * infos.php
 *
 * Information about every aspect of in-game objects: buildings, officiers, techs etc
 *
 * @version 1.1st Security checks & tests by Gorlum for http://supernova.ws
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */
include('common.' . substr(strrchr(__FILE__, '.'), 1));

// ----------------------------------------------------------------------------------------------------------
// Creation de la Liste de flotte disponible sur la lune
//
function BuildFleetListRows($CurrentPlanet)
{
  global $sn_data, $lang;

  $RowsTPL = gettemplate('gate_fleet_rows');
  $CurrIdx = 1;
  $Result = "";
  for ($Ship = 300; $Ship > 200; $Ship--)
  {
    if ($sn_data[$Ship]['name'] != "")
    {
      if ($CurrentPlanet[$sn_data[$Ship]['name']] > 0)
      {
        $bloc['idx'] = $CurrIdx;
        $bloc['fleet_id'] = $Ship;
        $bloc['fleet_name'] = $lang['tech'][$Ship];
        $bloc['fleet_max'] = pretty_number($CurrentPlanet[$sn_data[$Ship]['name']]);
        $bloc['gate_ship_dispo'] = $lang['gate_ship_dispo'];
        $Result .= parsetemplate($RowsTPL, $bloc);
        $CurrIdx++;
      }
    }
  }
  return $Result;
}

// ----------------------------------------------------------------------------------------------------------
// Creation de la combo de selection de Lune d'arrivé
//
function BuildJumpableMoonCombo($CurrentUser, $CurrentPlanet)
{
  global $sn_data;
  $QrySelectMoons = "SELECT * FROM {{planets}} WHERE `planet_type` = '3' AND `id_owner` = '" . $CurrentUser['id'] . "';";
  $MoonList = doquery($QrySelectMoons);
  $Combo = "";
  while ($CurMoon = mysql_fetch_assoc($MoonList))
  {
    if ($CurMoon['id'] != $CurrentPlanet['id'])
    {
      $RestString = GetNextJumpWaitTime($CurMoon);
      if ($CurMoon[$sn_data[43]['name']] >= 1)
      {
        $Combo .= "<option value=\"" . $CurMoon['id'] . "\">[" . $CurMoon['galaxy'] . ":" . $CurMoon['system'] . ":" . $CurMoon['planet'] . "] " . $CurMoon['name'] . $RestString['string'] . "</option>\n";
      }
    }
  }
  return $Combo;
}

// ----------------------------------------------------------------------------------------------------------
// Creation du tableau de production de ressources
// Tient compte du parametrage de la planete (si la production n'est pas affectée a 100% par exemple
// Tient compte aussi du multiplicateur de ressources
//
function ShowProductionTable($CurrentUser, $CurrentPlanet, $BuildID, $Template)
{
  global $sn_data, $config;

  $unit_data = $sn_data[$BuildID];

  $config_resource_multiplier = $config->resource_multiplier;

  $BuildLevelFactor = $CurrentPlanet[$unit_data['name'] . "_porcent"];
  $BuildTemp = $CurrentPlanet['temp_max'];
  $BuildEnergyTech = $CurrentUser['energy_tech'];
  $CurrentBuildtLvl = $CurrentPlanet[$unit_data['name']];

  $BuildLevel = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;


  $Prod[1] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_GEOLOGIST, $config_resource_multiplier * eval($unit_data['metal_perhour'])));
  $Prod[2] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_GEOLOGIST, $config_resource_multiplier * eval($unit_data['crystal_perhour'])));
  $Prod[3] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_GEOLOGIST, $config_resource_multiplier * eval($unit_data['deuterium_perhour'])));
  $Prod[4] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_POWERMAN, /* $config_resource_multiplier * */ eval($unit_data['energy_perhour'])));

  $ActualProd = floor($Prod[$BuildID]);
  if ($BuildID != 12)
  {
    $ActualNeed = floor($Prod[4]);
  }
  else
  {
    $ActualNeed = floor($Prod[3]);
  }

  $BuildStartLvl = $CurrentBuildtLvl - 2;
  if ($BuildStartLvl < 1)
  {
    $BuildStartLvl = 1;
  }
  $Table = "";
  $ProdFirst = 0;
  for ($BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 10; $BuildLevel++)
  {
    if ($BuildID != 42)
    {
      $Prod[1] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_GEOLOGIST, $config_resource_multiplier * eval($unit_data['metal_perhour'])));
      $Prod[2] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_GEOLOGIST, $config_resource_multiplier * eval($unit_data['crystal_perhour'])));
      $Prod[3] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_GEOLOGIST, $config_resource_multiplier * eval($unit_data['deuterium_perhour'])));
      $Prod[4] = floor(mrc_modify_value($CurrentUser, $CurrentPlanet, MRC_POWERMAN, /* $config_resource_multiplier * */ eval($unit_data['energy_perhour'])));

      $bloc['build_lvl'] = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">" . $BuildLevel . "</font>" : $BuildLevel;
      if ($ProdFirst > 0)
      {
        if ($BuildID != 12)
        {
          $bloc['build_gain'] = "<font color=\"lime\">(" . pretty_number(floor($Prod[$BuildID] - $ProdFirst)) . ")</font>";
        }
        else
        {
          $bloc['build_gain'] = "<font color=\"lime\">(" . pretty_number(floor($Prod[4] - $ProdFirst)) . ")</font>";
        }
      }
      else
      {
        $bloc['build_gain'] = "";
      }
      if ($BuildID != 12)
      {
        $bloc['build_prod'] = pretty_number(floor($Prod[$BuildID]));
        $bloc['build_prod_diff'] = pretty_number(floor($Prod[$BuildID] - $ActualProd), true, true);
        $bloc['build_need'] = pretty_number(floor($Prod[4]), true, true);
        $bloc['build_need_diff'] = pretty_number(floor($Prod[4] - $ActualNeed), true, true);
      }
      else
      {
        $bloc['build_prod'] = pretty_number(floor($Prod[4]));
        $bloc['build_prod_diff'] = pretty_number(floor($Prod[4] - $ActualProd), true, true);
        $bloc['build_need'] = pretty_number(floor($Prod[3]), true, true);
        $bloc['build_need_diff'] = pretty_number(floor($Prod[3] - $ActualNeed), true, true);
      }
      if ($ProdFirst == 0)
      {
        if ($BuildID != 12)
        {
          $ProdFirst = floor($Prod[$BuildID]);
        }
        else
        {
          $ProdFirst = floor($Prod[4]);
        }
      }
    }
    else
    {
      // Cas particulier de la phalange
      $bloc['build_lvl'] = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">" . $BuildLevel . "</font>" : $BuildLevel;
      $bloc['build_range'] = ($BuildLevel * $BuildLevel) - 1;
    }
    $Table .= parsetemplate($Template, $bloc);
  }

  return $Table;
}

function eco_render_rapid_fire($unit_id)
{
  global $lang, $sn_data;

  $unit_data = $sn_data[$unit_id];
  $unit_durability = $unit_data['shield'] + $unit_data['armor'];

  $str_rapid_from = '';
  $str_rapid_to = '';
  foreach (array_merge($sn_data[groups]['fleet'], $sn_data[groups]['defense_active']) as $enemy_id)
  {
    $enemy_data = $sn_data[$enemy_id];
    $enemy_durability = $enemy_data['shield'] + $enemy_data['armor'];

    $rapid = floor($unit_data['attack'] * $unit_data['amplify'][$enemy_id] / $enemy_durability);
    if ($rapid > 1)
    {
      $str_rapid_to .= "{$lang['nfo_rf_again']} {$lang['tech'][$enemy_id]} <font color=\"#00ff00\">{$rapid}</font><br>";
    }

    $rapid = floor($enemy_data['attack'] * $enemy_data['amplify'][$unit_id] / $unit_durability);
    if ($rapid > 1)
    {
      $str_rapid_from .= "{$lang['tech'][$enemy_id]} {$lang['nfo_rf_from']} <font color=\"#ff0000\">{$rapid}</font><br>";
    }
  }

  if ($str_rapid_to && $str_rapid_from)
  {
    $str_rapid_to .= '<hr>';
  }

  return array('to' => $str_rapid_to, 'from' => $str_rapid_from);
}

// ----------------------------------------------------------------------------------------------------------
// Construit la page par rapport a l'information demandée ...
// Permet de faire la differance entre les divers types et les pages speciales
//
function ShowBuildingInfoPage($CurrentUser, $CurrentPlanet, $BuildID)
{
  global $dpath, $lang, $sn_data;

  $sn_groups = &$sn_data['groups'];
  $unit_data = &$sn_data[$BuildID];

  lng_include('infos');

  $GateTPL = '';
  $DestroyTPL = '';
  $TableHeadTPL = '';

  $parse = $lang;
  // Données de base
  $parse['dpath'] = $dpath;
  $parse['name'] = $lang['tech'][$BuildID];
  $parse['image'] = $BuildID;
  $parse['description'] = $lang['info'][$BuildID]['description'];

  if ($BuildID >= 1 && $BuildID <= 3)
  {
    // Cas des mines
    $PageTPL = gettemplate('info_buildings_table');
    $DestroyTPL = gettemplate('info_buildings_destroy');
    $TableHeadTPL = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_p_hour}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
    $TableTPL = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
  }
  elseif ($BuildID == 4)
  {
    // Centrale Solaire
    $PageTPL = gettemplate('info_buildings_table');
    $DestroyTPL = gettemplate('info_buildings_destroy');
    $TableHeadTPL = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td></tr>";
    $TableTPL = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th></tr>";
  }
  elseif ($BuildID == 12)
  {
    // Centrale Fusion
    $PageTPL = gettemplate('info_buildings_table');
    $DestroyTPL = gettemplate('info_buildings_destroy');
    $TableHeadTPL = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_prod_energy}</td><td class=\"c\">{nfo_difference}</td><td class=\"c\">{nfo_used_deuter}</td><td class=\"c\">{nfo_difference}</td></tr>";
    $TableTPL = "<tr><th>{build_lvl}</th><th>{build_prod} {build_gain}</th><th>{build_prod_diff}</th><th>{build_need}</th><th>{build_need_diff}</th></tr>";
  }
  elseif ($BuildID >= 14 && $BuildID <= 32)
  {
    // Batiments Generaux
    $PageTPL = gettemplate('info_buildings_general');
    $DestroyTPL = gettemplate('info_buildings_destroy');
  }
  elseif ($BuildID == 33)
  {
    // Batiments Terraformer
    $PageTPL = gettemplate('info_buildings_general');
  }
  elseif ($BuildID == 34)
  {
    // Dépot d'alliance
    $PageTPL = gettemplate('info_buildings_general');
    $DestroyTPL = gettemplate('info_buildings_destroy');
  }
  elseif ($BuildID == 35)
  {
    // nano
    $PageTPL = gettemplate('info_buildings_general');
    $DestroyTPL = gettemplate('info_buildings_destroy');
  }
  elseif ($BuildID == 44)
  {
    // Silo de missiles
    $PageTPL = gettemplate('info_buildings_general');
    $DestroyTPL = gettemplate('info_buildings_destroy');
  }
  elseif ($BuildID == 41)
  {
    // Batiments lunaires
    $PageTPL = gettemplate('info_buildings_general');
  }
  elseif ($BuildID == 42)
  {
    // Phalange
    $PageTPL = gettemplate('info_buildings_table');
    $TableHeadTPL = "<tr><td class=\"c\">{nfo_level}</td><td class=\"c\">{nfo_range}</td></tr>";
    $TableTPL = "<tr><th>{build_lvl}</th><th>{build_range}</th></tr>";
    $DestroyTPL = gettemplate('info_buildings_destroy');
  }
  elseif ($BuildID == 43)
  {
    // Porte de Saut
    $PageTPL = gettemplate('info_buildings_general');
    $GateTPL = gettemplate('gate_fleet_table');
    $DestroyTPL = gettemplate('info_buildings_destroy');
  }
  elseif (in_array($BuildID, $sn_data['groups']['tech']))
  {
    // Laboratoire
    $PageTPL = gettemplate('info_buildings_general');
  }
  elseif (in_array($BuildID, $sn_data['groups']['fleet']))
  {
    // Flotte
    $PageTPL = gettemplate('info_buildings_fleet');
    $parse['element_typ'] = $lang['tech'][SHIP_FLEET];
    $rapid_fire = eco_render_rapid_fire($BuildID);
    $parse['rf_info_to'] = $rapid_fire['to'];   // Rapid Fire vers
    $parse['rf_info_fr'] = $rapid_fire['from']; // Rapid Fire de

    $parse['hull_pt'] = pretty_number(($sn_data[$BuildID]['metal'] + $sn_data[$BuildID]['crystal']) / 10); // Points de Structure
    $parse['shield_pt'] = pretty_number($sn_data[$BuildID]['shield']);  // Points de Bouclier
    $parse['attack_pt'] = pretty_number($sn_data[$BuildID]['attack']);  // Points d'Attaque
    $parse['capacity_pt'] = pretty_number($sn_data[$BuildID]['capacity']); // Capacitée de fret
    $parse['base_speed'] = pretty_number($sn_data[$BuildID]['speed']);    // Vitesse de base
    $parse['base_conso'] = pretty_number($sn_data[$BuildID]['consumption']);  // Consommation de base
    if ($BuildID == SHIP_CARGO_SMALL)
    {
      $parse['upd_speed'] = "<font color=\"yellow\">(" . pretty_number($sn_data[$BuildID]['speed2']) . ")</font>";       // Vitesse rééquipée
      $parse['upd_conso'] = "<font color=\"yellow\">(" . pretty_number($sn_data[$BuildID]['consumption2']) . ")</font>"; // Consommation apres rééquipement
    }
    elseif ($BuildID == SHIP_BOMBER)
    {
      $parse['upd_speed'] = "<font color=\"yellow\">(" . pretty_number($sn_data[$BuildID]['speed2']) . ")</font>";       // Vitesse rééquipée
    }
  }
  elseif (in_array($BuildID, $sn_data['groups']['defense_active']))
  {
    // Defenses
    $PageTPL = gettemplate('info_buildings_defense');
    $parse['element_typ'] = $lang['tech'][400];

    $rapid_fire = eco_render_rapid_fire($BuildID);
    $parse['rf_info_to'] = $rapid_fire['to'];   // Rapid Fire vers
    $parse['rf_info_fr'] = $rapid_fire['from']; // Rapid Fire de

    $parse['hull_pt'] = pretty_number(($sn_data[$BuildID]['metal'] + $sn_data[$BuildID]['crystal']) / 10); // Points de Structure
    $parse['shield_pt'] = pretty_number($sn_data[$BuildID]['shield']);  // Points de Bouclier
    $parse['attack_pt'] = pretty_number($sn_data[$BuildID]['attack']);  // Points d'Attaque
  }
  elseif ($BuildID >= 502 && $BuildID <= 503)
  {
    // Misilles
    $PageTPL = gettemplate('info_buildings_defense');
    $parse['element_typ'] = $lang['tech'][400];
    $parse['hull_pt'] = pretty_number($sn_data[$BuildID]['metal'] + $sn_data[$BuildID]['crystal']); // Points de Structure
    $parse['shield_pt'] = pretty_number($sn_data[$BuildID]['shield']);  // Points de Bouclier
    $parse['attack_pt'] = pretty_number($sn_data[$BuildID]['attack']);  // Points d'Attaque
  }
  elseif (in_array($BuildID, $sn_data['groups']['mercenaries']))
  {
    // Officiers
    $PageTPL = gettemplate('info_officiers_general');

    $mercenary = $sn_data[$BuildID];
    $mercenary_bonus = $mercenary['bonus'];
    $mercenary_bonus = $mercenary_bonus >= 0 ? "+{$mercenary_bonus}" : "{$mercenary_bonus}";
    switch ($mercenary['bonus_type'])
    {
      case BONUS_PERCENT:
        $mercenary_bonus = "{$mercenary_bonus}%";
        break;

      case BONUS_ADD:
        break;

      case BONUS_ABILITY:
        $mercenary_bonus = '';
        break;

      default:
        break;
    }

    $parse['EFFECT'] = $lang['info'][$BuildID]['effect'];
    $parse['mercenary_bonus'] = $mercenary_bonus;
    $parse['max_level'] = $mercenary['max'];
  }

  // ---- Tableau d'evolution
  if ($TableHeadTPL != '')
  {
    $parse['table_head'] = parsetemplate($TableHeadTPL, $lang);
    $parse['table_data'] = ShowProductionTable($CurrentUser, $CurrentPlanet, $BuildID, $TableTPL);
  }

  // La page principale
  $page = parsetemplate($PageTPL, $parse);
  if ($GateTPL != '')
  {
    if ($CurrentPlanet[$unit_data['name']] > 0)
    {
      $RestString = GetNextJumpWaitTime($CurrentPlanet);
      $parse['gate_start_link'] = uni_render_coordinates_href($CurrentPlanet, '', 3);
      if ($RestString['value'] != 0)
      {
        $parse['gate_time_script'] = InsertJavaScriptChronoApplet("Gate", "1", $RestString['value'], true);
        $parse['gate_wait_time'] = "<div id=\"bxx" . "Gate" . "1" . "\"></div>";
        $parse['gate_script_go'] = InsertJavaScriptChronoApplet("Gate", "1", $RestString['value'], false);
      }
      else
      {
        $parse['gate_time_script'] = "";
        $parse['gate_wait_time'] = "";
        $parse['gate_script_go'] = "";
      }
      $parse['gate_dest_moons'] = BuildJumpableMoonCombo($CurrentUser, $CurrentPlanet);
      $parse['gate_fleet_rows'] = BuildFleetListRows($CurrentPlanet);
      $page .= parsetemplate($GateTPL, $parse);
    }
  }

  if ($DestroyTPL != '')
  {
    if ($CurrentPlanet[$unit_data['name']] > 0)
    {
      // ---- Destruction
      $NeededRessources = GetBuildingPrice($CurrentUser, $CurrentPlanet, $BuildID, true, true);
      $DestroyTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $BuildID) / 2;
      $parse['destroyurl'] = "buildings.php?mode=" . QUE_STRUCTURES . "&action=destroy&unit_id={$BuildID}"; // Non balisé les balises sont dans le
      $parse['levelvalue'] = $CurrentPlanet[$unit_data['name']]; // Niveau du batiment a detruire
      $parse['nfo_metal'] = $lang['Metal'];
      $parse['nfo_crysta'] = $lang['Crystal'];
      $parse['nfo_deuter'] = $lang['Deuterium'];
      $parse['metal'] = pretty_number($NeededRessources['metal']);     // Cout en metal de la destruction
      $parse['crystal'] = pretty_number($NeededRessources['crystal']);   // Cout en cristal de la destruction
      $parse['deuterium'] = pretty_number($NeededRessources['deuterium']); // Cout en deuterium de la destruction
      $parse['destroytime'] = pretty_time($DestroyTime);                   // Durée de la destruction
      // L'insert de destruction
      $page .= parsetemplate($DestroyTPL, $parse);
    }
  }

  return $page;
}
// ----------------------------------------------------------------------------------------------------------
// Appel de la page ...
// Tout le reste ne sert qu'a la calculer :)
//

$page = ShowBuildingInfoPage($user, $planetrow, sys_get_param_int('gid'));

display($page, $lang['nfo_page_title']);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Réécriture (réinventation de l'eau tiède)
// 1.1 - Ajout JumpGate pour la porte de saut comme la présente OGame ... Enfin un peu mieux quand meme !

?>
