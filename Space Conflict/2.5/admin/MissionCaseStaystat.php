<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** MissionCaseStayStat.php               **
******************************************/

define('INSIDE'  , true);

define('INSTALL' , false);

$xnova_root_path = './';

include($xnova_root_path . 'admin/statfunctions.php');
doquery("UNLOCK TABLES", "");

   $StatDate   = time();


   doquery ( "DELETE FROM {{table}} WHERE `stat_code` = '2';" , 'statpoints');
   doquery ( "UPDATE {{table}} SET `stat_code` = `stat_code` + '1';" , 'statpoints');

   $GameUsers  = doquery("SELECT * FROM {{table}}", 'users');

   while ($CurUser = mysql_fetch_assoc($GameUsers)) {

      $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');

      if ($OldStatRecord) {
         $OldTotalRank = $OldStatRecord['total_rank'];
         $OldTechRank  = $OldStatRecord['tech_rank'];
         $OldBuildRank = $OldStatRecord['build_rank'];
         $OldDefsRank  = $OldStatRecord['defs_rank'];
         $OldFleetRank = $OldStatRecord['fleet_rank'];
         doquery ("DELETE FROM {{table}} WHERE `stat_type` = '1' AND `id_owner` = '".$CurUser['id']."';",'statpoints');

      } else {
         $OldTotalRank = 0;
         $OldTechRank  = 0;
         $OldBuildRank = 0;
         $OldDefsRank  = 0;
         $OldFleetRank = 0;
      }

      $Points         = GetTechnoPoints ( $CurUser );
      $TTechCount     = $Points['TechCount'];
      $TTechPoints    = ($Points['TechPoint'] / 1000);
      $TBuildCount    = 0;
      $TBuildPoints   = 0;
      $TDefsCount     = 0;
      $TDefsPoints    = 0;
      $TFleetCount    = 0;
      $TFleetPoints   = 0;

      $GCount         = $TTechCount;
      $GPoints        = $TTechPoints;
      $UsrPlanets     = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $CurUser['id'] ."';", 'planets');

      while ($CurPlanet = mysql_fetch_assoc($UsrPlanets) ) {
         $Points           = GetBuildPoints ( $CurPlanet );
         $TBuildCount     += $Points['BuildCount'];
         $GCount          += $Points['BuildCount'];
         $PlanetPoints     = ($Points['BuildPoint'] / 1000);
         $TBuildPoints    += ($Points['BuildPoint'] / 1000);

         $Points           = GetDefensePoints ( $CurPlanet );
         $TDefsCount      += $Points['DefenseCount'];;
         $GCount          += $Points['DefenseCount'];
         $PlanetPoints    += ($Points['DefensePoint'] / 1000);
         $TDefsPoints     += ($Points['DefensePoint'] / 1000);

         $Points           = GetFleetPoints ( $CurPlanet );
         $TFleetCount     += $Points['FleetCount'];
         $GCount          += $Points['FleetCount'];
         $PlanetPoints    += ($Points['FleetPoint'] / 1000);
         $TFleetPoints    += ($Points['FleetPoint'] / 1000);

         $GPoints         += $PlanetPoints;
         $QryUpdatePlanet  = "UPDATE {{table}} SET ";
         $QryUpdatePlanet .= "`points` = '". $PlanetPoints ."' ";
         $QryUpdatePlanet .= "WHERE ";
         $QryUpdatePlanet .= "`id` = '". $CurPlanet['id'] ."';";
         doquery ( $QryUpdatePlanet , 'planets');
      }

      $QryInsertStats  = "INSERT INTO {{table}} SET ";
      $QryInsertStats .= "`id_owner` = '". $CurUser['id'] ."', ";
      $QryInsertStats .= "`id_ally` = '". $CurUser['ally_id'] ."', ";
      $QryInsertStats .= "`stat_type` = '1', "; // 1 pour joueur , 2 pour alliance
      $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 2 mis a jour de maniere automatique
      $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
      $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
      $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
      $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
      $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
      $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
      $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
      $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
      $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
      $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
      $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
      $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
      $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
      $QryInsertStats .= "`total_count` = '". $GCount ."', ";
      $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
      $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
      doquery ( $QryInsertStats , 'statpoints');
   }

   $Rank           = 1;
   $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `tech_points` DESC;", 'statpoints');

   while ($TheRank = mysql_fetch_assoc($RankQry) ) {
      $QryUpdateStats  = "UPDATE {{table}} SET ";
      $QryUpdateStats .= "`tech_rank` = '". $Rank ."' ";
      $QryUpdateStats .= "WHERE ";
      $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
      doquery ( $QryUpdateStats , 'statpoints');

      $Rank++;
   }

   $Rank           = 1;
   $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `build_points` DESC;", 'statpoints');

   while ($TheRank = mysql_fetch_assoc($RankQry) ) {
      $QryUpdateStats  = "UPDATE {{table}} SET ";
      $QryUpdateStats .= "`build_rank` = '". $Rank ."' ";
      $QryUpdateStats .= "WHERE ";
      $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
      doquery ( $QryUpdateStats , 'statpoints');

      $Rank++;
   }

   $Rank           = 1;
   $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `defs_points` DESC;", 'statpoints');

   while ($TheRank = mysql_fetch_assoc($RankQry) ) {
      $QryUpdateStats  = "UPDATE {{table}} SET ";
      $QryUpdateStats .= "`defs_rank` = '". $Rank ."' ";
      $QryUpdateStats .= "WHERE ";
      $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
      doquery ( $QryUpdateStats , 'statpoints');
      $Rank++;
   }

   $Rank           = 1;
   $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `fleet_points` DESC;", 'statpoints');

   while ($TheRank = mysql_fetch_assoc($RankQry) ) {
      $QryUpdateStats  = "UPDATE {{table}} SET ";
      $QryUpdateStats .= "`fleet_rank` = '". $Rank ."' ";
      $QryUpdateStats .= "WHERE ";
      $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
      doquery ( $QryUpdateStats , 'statpoints');
      $Rank++;
   }

   $Rank           = 1;
   $RankQry        = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' ORDER BY `total_points` DESC;", 'statpoints');

   while ($TheRank = mysql_fetch_assoc($RankQry) ) {
      $QryUpdateStats  = "UPDATE {{table}} SET ";
      $QryUpdateStats .= "`total_rank` = '". $Rank ."' ";
      $QryUpdateStats .= "WHERE ";
      $QryUpdateStats .= " `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $TheRank['id_owner'] ."';";
      doquery ( $QryUpdateStats , 'statpoints');
      $Rank++;
   }

   $GameAllys  = doquery("SELECT * FROM {{table}}", 'alliance');

   while ($CurAlly = mysql_fetch_assoc($GameAllys)) {
      $OldStatRecord  = doquery ("SELECT * FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
      if ($OldStatRecord) {
         $OldTotalRank = $OldStatRecord['total_rank'];
         $OldTechRank  = $OldStatRecord['tech_rank'];
         $OldBuildRank = $OldStatRecord['build_rank'];
         $OldDefsRank  = $OldStatRecord['defs_rank'];
         $OldFleetRank = $OldStatRecord['fleet_rank'];
         doquery ("DELETE FROM {{table}} WHERE `stat_type` = '2' AND `id_owner` = '".$CurAlly['id']."';",'statpoints');
      } else {
         $OldTotalRank = 0;
         $OldTechRank  = 0;
         $OldBuildRank = 0;
         $OldDefsRank  = 0;
         $OldFleetRank = 0;
      }

      $QrySumSelect   = "SELECT ";
      $QrySumSelect  .= "SUM(`tech_points`)  as `TechPoint`, ";
      $QrySumSelect  .= "SUM(`tech_count`)   as `TechCount`, ";
      $QrySumSelect  .= "SUM(`build_points`) as `BuildPoint`, ";
      $QrySumSelect  .= "SUM(`build_count`)  as `BuildCount`, ";
      $QrySumSelect  .= "SUM(`defs_points`)  as `DefsPoint`, ";
      $QrySumSelect  .= "SUM(`defs_count`)   as `DefsCount`, ";
      $QrySumSelect  .= "SUM(`fleet_points`) as `FleetPoint`, ";
      $QrySumSelect  .= "SUM(`fleet_count`)  as `FleetCount`, ";
      $QrySumSelect  .= "SUM(`total_points`) as `TotalPoint`, ";
      $QrySumSelect  .= "SUM(`total_count`)  as `TotalCount` ";
      $QrySumSelect  .= "FROM {{table}} ";
      $QrySumSelect  .= "WHERE ";
      $QrySumSelect  .= "`stat_type` = '1' AND ";
      $QrySumSelect  .= "`id_ally` = '". $CurAlly['id'] ."';";
      $Points         = doquery( $QrySumSelect, 'statpoints', true);

      $TTechCount     = $Points['TechCount'];
      $TTechPoints    = $Points['TechPoint'];
      $TBuildCount    = $Points['BuildCount'];
      $TBuildPoints   = $Points['BuildPoint'];
      $TDefsCount     = $Points['DefsCount'];
      $TDefsPoints    = $Points['DefsPoint'];
      $TFleetCount    = $Points['FleetCount'];
      $TFleetPoints   = $Points['FleetPoint'];
      $GCount         = $Points['TotalCount'];
      $GPoints        = $Points['TotalPoint'];

      $QryInsertStats  = "INSERT INTO {{table}} SET ";
      $QryInsertStats .= "`id_owner` = '". $CurAlly['id'] ."', ";
      $QryInsertStats .= "`id_ally` = '0', ";
      $QryInsertStats .= "`stat_type` = '2', "; // 1 pour joueur , 2 pour alliance
      $QryInsertStats .= "`stat_code` = '1', "; // de 1 a 5 mis a jour de maniere automatique
      $QryInsertStats .= "`tech_points` = '". $TTechPoints ."', ";
      $QryInsertStats .= "`tech_count` = '". $TTechCount ."', ";
      $QryInsertStats .= "`tech_old_rank` = '". $OldTechRank ."', ";
      $QryInsertStats .= "`build_points` = '". $TBuildPoints ."', ";
      $QryInsertStats .= "`build_count` = '". $TBuildCount ."', ";
      $QryInsertStats .= "`build_old_rank` = '". $OldBuildRank ."', ";
      $QryInsertStats .= "`defs_points` = '". $TDefsPoints ."', ";
      $QryInsertStats .= "`defs_count` = '". $TDefsCount ."', ";
      $QryInsertStats .= "`defs_old_rank` = '". $OldDefsRank ."', ";
      $QryInsertStats .= "`fleet_points` = '". $TFleetPoints ."', ";
      $QryInsertStats .= "`fleet_count` = '". $TFleetCount ."', ";
      $QryInsertStats .= "`fleet_old_rank` = '". $OldFleetRank ."', ";
      $QryInsertStats .= "`total_points` = '". $GPoints ."', ";
      $QryInsertStats .= "`total_count` = '". $GCount ."', ";
      $QryInsertStats .= "`total_old_rank` = '". $OldTotalRank ."', ";
      $QryInsertStats .= "`stat_date` = '". $StatDate ."';";
      doquery ( $QryInsertStats , 'statpoints');
   }

   $tempsstat   = 60;
   $StatFleetDate   = time()+$tempsstat;
   $StatFleetDatend   = $StatFleetDate+$tempsstat;

   $QryInsertFleet  = "INSERT INTO {{table}} SET ";
   $QryInsertFleet .= "`fleet_owner` = '0', ";
   $QryInsertFleet .= "`fleet_mission` = '4', ";
   $QryInsertFleet .= "`fleet_amount` = '1', ";
   $QryInsertFleet .= "`fleet_array` = '203,1;', ";
   $QryInsertFleet .= "`fleet_start_time` = '". $StatFleetDate ."',";
   $QryInsertFleet .= "`fleet_start_galaxy` = '1', ";
   $QryInsertFleet .= "`fleet_start_system` = '1', ";
   $QryInsertFleet .= "`fleet_start_planet` = '1', ";
   $QryInsertFleet .= "`fleet_start_type` = '1', ";
   $QryInsertFleet .= "`fleet_end_time` = '". $StatFleetDatend ."', ";
   $QryInsertFleet .= "`fleet_end_stay` = '0', ";
   $QryInsertFleet .= "`fleet_end_galaxy` = '1', ";
   $QryInsertFleet .= "`fleet_end_system` = '1', ";
   $QryInsertFleet .= "`fleet_end_planet` = '1', ";
   $QryInsertFleet .= "`fleet_end_type` = '1', ";
   $QryInsertFleet .= "`fleet_resource_metal` = '0', ";
   $QryInsertFleet .= "`fleet_resource_crystal` = '0', ";
   $QryInsertFleet .= "`fleet_resource_deuterium` = '1', ";
   $QryInsertFleet .= "`fleet_target_owner` = '0', ";
   $QryInsertFleet .= "`start_time` = '". time() ."';";
   doquery( $QryInsertFleet, 'fleets');     

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>