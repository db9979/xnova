<?php

/**
 * stat.php
 *
 * 1.2 copyright (c) 2010 by Gorlum for http://supernova.ws
 *   [*] Now we don't need any misc new and old RANK calculations or UPDATEs here
 *       All RANKs calculations now handled in StatFunctions.php
 * 1.1 copyright (c) 2010 by Gorlum for http://supernova.ws
 *   [*] This file is also used when no users logged in to show server stats
 * 1.0 copyright 2008 by Chlorel for XNova
 *   [!] R��criture module
*/

$allow_anonymous = true;

include('common.' . substr(strrchr(__FILE__, '.'), 1));

lng_include('stat');

$parse = $lang;
$who   = (isset($_POST['who']))   ? $_POST['who']   : $_GET['who'];
if (!isset($who)) {
  $who   = 1;
}
$type  = (isset($_POST['type']))  ? $_POST['type']  : $_GET['type'];
if (!isset($type)) {
  $type  = 1;
}
$range = (isset($_POST['range'])) ? $_POST['range'] : $_GET['range'];
if (!isset($range)) {
  $range = 1;
}

$parse['who']    = "<option value=\"1\"". (($who == "1") ? " SELECTED" : "") .">". $lang['stat_player'] ."</option>";
$parse['who']   .= "<option value=\"2\"". (($who == "2") ? " SELECTED" : "") .">". $lang['stat_allys']  ."</option>";

$parse['type']   = "<option value=\"1\"". (($type == "1") ? " SELECTED" : "") .">". $lang['stat_main']     ."</option>";
$parse['type']  .= "<option value=\"2\"". (($type == "2") ? " SELECTED" : "") .">". $lang['stat_fleet']    ."</option>";
$parse['type']  .= "<option value=\"3\"". (($type == "3") ? " SELECTED" : "") .">". $lang['stat_research'] ."</option>";
$parse['type']  .= "<option value=\"4\"". (($type == "4") ? " SELECTED" : "") .">". $lang['stat_building'] ."</option>";
$parse['type']  .= "<option value=\"5\"". (($type == "5") ? " SELECTED" : "") .">". $lang['stat_defenses'] ."</option>";
$parse['type']  .= "<option value=\"6\"". (($type == "6") ? " SELECTED" : "") .">". $lang['stat_resources'] ."</option>";

if       ($type == 1) {
  $Order   = "total_points";
  $Points  = "total_points";
  $Counts  = "total_count";
  $Rank    = "total_rank";
  $OldRank = "total_old_rank";
} elseif ($type == 2) {
  $Order   = "fleet_points";
  $Points  = "fleet_points";
  $Counts  = "fleet_count";
  $Rank    = "fleet_rank";
  $OldRank = "fleet_old_rank";
} elseif ($type == 3) {
  $Order   = "tech_points";
  $Points  = "tech_points";
  $Counts  = "tech_count";
  $Rank    = "tech_rank";
  $OldRank = "tech_old_rank";
} elseif ($type == 4) {
  $Order   = "build_points";
  $Points  = "build_points";
  $Counts  = "build_count";
  $Rank    = "build_rank";
  $OldRank = "build_old_rank";
} elseif ($type == 5) {
  $Order   = "defs_points";
  $Points  = "defs_points";
  $Counts  = "defs_count";
  $Rank    = "defs_rank";
  $OldRank = "defs_old_rank";
} elseif ($type == 6) {
  $Order   = "res_points";
  $Points  = "res_points";
  $Counts  = "res_count";
  $Rank    = "res_rank";
  $OldRank = "res_old_rank";
}

$parse['stat_date'] = date(FMT_DATE_TIME, $config->var_stat_update);

if ($who == 2) {
  $MaxAllys = doquery ("SELECT COUNT(*) AS `count` FROM {{alliance}} WHERE 1;", '', true);
  if ($MaxAllys['count'] > 100) {
    $LastPage = floor($MaxAllys['count'] / 100);
  }
  $parse['range'] = "";
  for ($Page = 0; $Page <= $LastPage; $Page++) {
    $PageValue      = ($Page * 100) + 1;
    $PageRange      = $PageValue + 99;
    $parse['range'] .= "<option value=\"". $PageValue ."\"". (($range == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>";
  }

  $parse['stat_header'] = parsetemplate(gettemplate('stat_alliancetable_header'), $parse);

  $start = floor($range / 100 % 100) * 100;
  $query = doquery("SELECT @rownum:=@rownum+1 as rownum, {{statpoints}}.* FROM (SELECT @rownum:=0) r, {{statpoints}} WHERE `stat_type` = '2' AND `stat_code` = '1' ORDER BY `". $Rank ."`, id_owner LIMIT ". $start .",100;");

  $start++;
  $parse['stat_values'] = "";
  while ($StatRow = mysql_fetch_assoc($query)) {
    $parse['ally_rank']       = $start;

    $AllyRow                  = doquery("SELECT * FROM {{alliance}} WHERE `id` = '". $StatRow['id_owner'] ."';", '',true);

    $rank_old                 = $StatRow[ $OldRank ];
    $rank_new                 = $StatRow[ $Rank ];
    $ranking                  = $rank_old - $rank_new;
    if ($ranking == "0") {
      $parse['ally_rankplus']   = "<font color=\"#87CEEB\">*</font>";
    }elseif ($ranking < "0") {
      $parse['ally_rankplus']   = "<font color=\"red\">".$ranking."</font>";
    }elseif ($ranking > "0") {
      $parse['ally_rankplus']   = "<font color=\"green\">+".$ranking."</font>";
    }
    $parse['ally_tag']        = $AllyRow['ally_tag'];

    if ($AllyRow['ally_name'] == $user['ally_name']) {
      $parse['ally_name'] = "<font color=\"#33CCFF\">".$AllyRow['ally_name']."</font>";
    } else {
      $parse['ally_name'] = $AllyRow['ally_name'];
    }
//      $parse['ally_name']       = $AllyRow['ally_name'];
    $parse['ally_id']         = $AllyRow['id'];
    $parse['ally_mes']        = '';
    $parse['ally_members']    = $AllyRow['ally_members'];
    $parse['ally_points']     = pretty_number( $StatRow[ $Order ] );
    $parse['ally_members_points'] =  pretty_number( floor($StatRow[ $Order ] / $AllyRow['ally_members']) );

    $parse['stat_values']    .= parsetemplate(gettemplate('stat_alliancetable'), $parse);
    $start++;
  }
} else {
  $MaxUsers = doquery ("SELECT COUNT(*) AS `count` FROM {{users}} WHERE `db_deaktjava` = '0';", '', true);
  if ($MaxUsers['count'] > 100) {
    $LastPage = floor($MaxUsers['count'] / 100);
  }
  $parse['range'] = "";
  for ($Page = 0; $Page <= $LastPage; $Page++) {
    $PageValue      = ($Page * 100) + 1;
    $PageRange      = $PageValue + 99;
    $parse['range'] .= "<option value=\"". $PageValue ."\"". (($range == $PageValue) ? " SELECTED" : "") .">". $PageValue ."-". $PageRange ."</option>\n";
  }

  $parse['stat_header'] = parsetemplate(gettemplate('stat_playertable_header'), $parse);

  $start = floor($range / 100 % 100) * 100;
  $start1 = $start;
  $query = doquery("SELECT @rownum:=@rownum+1 rownum, {{statpoints}}.* FROM (SELECT @rownum:=0) r, {{statpoints}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `". $Rank ."`, id_owner LIMIT ". $start .",100;");

  $start++;
  $parse['stat_values'] = "";
  while ($StatRow = mysql_fetch_assoc($query)) {
    $UsrRow                   = doquery("SELECT * FROM {{users}} WHERE `id` = '". $StatRow['id_owner'] ."';", '',true);

    $parse['player_rank']     = ($StatRow['rownum'] + $start1);

    $parse['player_rank']     = $StatRow[ $Rank ];
    $ranking                  = $StatRow[ $OldRank ] - $StatRow[ $Rank ];
    if ($ranking == "0") {
      $parse['player_rankplus'] = "<font color=\"#87CEEB\">*</font>";
    }elseif ($ranking < "0") {
      $parse['player_rankplus'] = "<font color=\"red\">".$ranking."</font>";
    }elseif ($ranking > "0") {
      $parse['player_rankplus'] = "<font color=\"green\">+".$ranking."</font>";
    }
    if ($UsrRow['id'] == $user['id']) {
      $parse['player_name']     = "<font color=\"lime\">".$UsrRow['username']."</font>";
    } else {
      $parse['player_name']     = $UsrRow['username'];
    }
    if ($IsUserChecked)
      $parse['player_mes']      = "<a href=\"messages.php?mode=write&id=" . $UsrRow['id'] . "\"><img src=\"" . $dpath . "img/m.gif\" border=\"0\" alt=\"". $lang['Ecrire'] ."\" /></a>";
    if ($UsrRow['ally_name'] == $user['ally_name']) {
      $parse['player_alliance'] = "<font color=\"#33CCFF\">".$UsrRow['ally_name']."</font>";
    } else {
      $parse['player_alliance'] = $UsrRow['ally_name'];
    }
    $parse['player_country'] = '';

    if($UsrRow['lang'] == "ru"){
      $parse['player_country'] .= '<img src="design/images/lang/ru.png">';
    }elseif($UsrRow['lang'] == "en"){
      $parse['player_country'] .= '<img src="design/images/lang/en.png">';
    }elseif($UsrRow['lang'] == "pl"){
      $parse['player_country'] .= '<img src="design/images/lang/pl.png">';
    }elseif($UsrRow['lang'] == "fr"){
      $parse['player_country'] .= '<img src="design/images/lang/fr.png">';
    }elseif($UsrRow['lang'] == "es"){
      $parse['player_country'] .= '<img src="design/images/lang/es.png">';
    }elseif($UsrRow['lang'] == "de"){
      $parse['player_country'] .= '<img src="design/images/lang/de.png">';
    }elseif($UsrRow['lang'] == "it"){
      $parse['player_country'] .= '<img src="design/images/lang/it.png">';
    }
    $parse['player_points']   = pretty_number( $StatRow[ $Order ] );
    $parse['stat_values']    .= parsetemplate(gettemplate('stat_playertable'), $parse);
    $start++;
  }
}
display(parsetemplate(gettemplate('stat_body'), $parse), $lang['stat_title'], $IsUserChecked, '', false, $IsUserChecked);

?>
