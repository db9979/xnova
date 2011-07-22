<?php
/*
--------------------------------------------- Informacion ---------------------------------------------
  _    _                                      _                   _                 
 | |  | |                                    | |                 | |                
 | |  | |   __ _    __ _   _ __ ___     ___  | |   __ _   _ __   | |   __ _   _   _  �
 | |  | |  / _` |  / _` | | '_ ` _ \   / _ \ | |  / _` | | '_ \  | |  / _` | | | | |
 | |__| | | (_| | | (_| | | | | | | | |  __/ | | | (_| | | |_) | | | | (_| | | |_| |
  \____/   \__, |  \__,_| |_| |_| |_|  \___| |_|  \__,_| | .__/  |_|  \__,_|  \__, |
            __/ |                                        | |                   __/ |
           |___/                                         |_|                  |___/ 
 
 *
 * newbot.class.php
 *
 * @copyright 2008-2010 Ugamelaplay
 * @package Ugamelaplay
 * @author shoghicp@gmail.com
 *
 *	UGamelaPlay.net es propietario de la parte propia de este archivo. Partes de este archivo son parte de XG Proyect. Su uso esta restringido a UGaSpace y XG Proyect por el momento. Para cualquier otra plataforma, contacte con shoghicp@gmail.com
 *	UGamelaPlay.net se reserva todos los derechos sobre la parte propia de este archivo.
 *
 
--------------------------------------------- Descripcion ------------------------------------------------------

Este archivo controla los bots. Amplia edificios, almacenes, investigaciones, crea flota y defensa, envia flotas, coloniza y hace fleet-saving.

--------------------------------------------- Historial de cambios ---------------------------------------------

0.1 - Crea y sube edificios
0.2 - A�adidas flotas, defensas en investigaciones
0.3 - Coloniza, mueve flota, hace fleetsaving, formulas de control
0.4 - Fixes varios y logs en archivo
0.5 - Base de datos

*/

include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);
include_once($xgp_root . 'includes/functions/HandleTechnologieBuild.' . $phpEx);

function scmp( $a, $b ) {
	 mt_srand((double)microtime()*1000000);
     return mt_rand(-1,1);
}
function UpdateNewBots(){
	global $user, $BotString;
	$allbots = doquery("SELECT * FROM {{table}};", 'bots');
	while($bot = mysql_fetch_array($allbots)){
		if(($bot['last_time'] + $bot['every_time']) < time() and $user['id'] != $bot['player']){
			$player = doquery("SELECT * FROM {{table}} WHERE `id` = '".$bot['player']."';", 'users', true);
			$thebot = new NewBot($player, $bot);
			$thebot->Play();
			unset($thebot);
		}	
	}
	$st = fopen($xgp_root.'includes/newbot.html', "a+");
	fwrite($st, $BotString);
	fclose($st);
	unset($bot);
	unset($allbots);
}

class NewBot{
	protected $player;
	protected $Bot;
	protected $CurrentPlanet;
	var $VERSION;
	var $Database;
	
	function __construct($player, $bot){
		$this->VERSION = '0.5';
		$this->player = $player;
		$this->Bot = $bot;
		$this->Database = new BotDatabase(md5($player['id']));
	}
	function Play(){
		global $resource, $BotString;
		$this->HandleOwnFleets();
		$iPlanetCount =  doquery ("SELECT count(*) AS `total` FROM {{table}} WHERE `id_owner` = '". $this->player['id'] ."' AND `planet_type` = '1'", 'planets',true);
		$maxfleet  = doquery("SELECT COUNT(fleet_owner) AS `actcnt` FROM {{table}} WHERE `fleet_owner` = '".$this->player['id']."';", 'fleets', true);
		$maxcolofleet  = doquery("SELECT COUNT(fleet_owner) AS `total` FROM {{table}} WHERE `fleet_owner` = '".$this->player['id']."' AND `fleet_mission` = '7';", 'fleets', true);
		$MaxFlyingFleets     = $maxfleet['actcnt'];
		$MaxFlottes         = $this->player[$resource[108]];
		$planetselected = false;
		$planetwork = false;
		$planetquery = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$this->player['id']."' AND `planet_type` = '1' ORDER BY `id` ASC;",'planets', false);
		while($this->CurrentPlanet = mysql_fetch_array($planetquery) ){
			if($planetselected == true and $this->CurrentPlanet['id_owner'] == $this->player['id']){
				CheckPlanetUsedFields ( $this->CurrentPlanet );
				if($BotString){
					$BotString .= "\r\n".'<tr><td colspan="2" class="c">'.$this->player['username'].'</td></tr><tr><th>Hora</th><th>'. date(DATE_RFC822) .'</th></tr><tr><th>Planeta actual</th><th>'.$this->CurrentPlanet['name'].' ['.$this->CurrentPlanet['id'].']</th></tr></tr>';
				}
				$this->BuildStores();
				$Rand = mt_rand(0, 1);
				if($Rand == 1 or $this->CurrentPlanet[$resource[4]] <= 5){
					$this->BuildBuildings();
				}else{
					$this->BuildSpecialBuildings();	
				}
				
				if($this->CurrentPlanet[$resource[31]] > 0){
					$this->ResearchTechs();
				}
				$Rand = mt_rand(0, 1);
				if($Rand == 1){
					$this->BuildFleet();
				}else{
					$this->BuildDefense();
				}
				
				
				if($iPlanetCount['total'] < MAX_PLAYER_PLANETS and $maxcolofleet['total'] < (MAX_PLAYER_PLANETS - $maxcolofleet['total']) and $MaxFlyingFleets < $MaxFlottes and $this->CurrentPlanet[$resource[208]] >= 1 ){
					$this->Colonize($iPlanetCount['total']);
				}
				if($this->CurrentPlanet['id'] == $this->player['id_planet']){
					if($MaxFlyingFleets < ($MaxFlottes + 1)){
						$this->HandleOtherFleets();
					}
				}elseif($MaxFlyingFleets < $MaxFlottes){
					$this->GetFleet();
				}				
				$this->Update();
				$planetselected = false;
				$planetwork = true;
				$planetid = $this->CurrentPlanet['id'];
			}else{
				if($this->CurrentPlanet['id'] == $this->Bot['last_planet']){
					$planetselected = true;				
				}
			}
		}
		if($planetwork == false){
				$this->CurrentPlanet = doquery("SELECT * FROM {{table}} WHERE `id` = '".$this->player['id_planet']."';",'planets', true);
			
				if($BotString){
					$BotString .= '<tr><td colspan="2" class="c">'.$this->player['username'].'</td><tr><th>Planeta actual</th><th>'.$this->CurrentPlanet['name'].' ['.$this->CurrentPlanet['id'].']</th></tr></tr>';
				}
				$this->BuildStores();
				$Rand = mt_rand(0, 1);
				if($Rand == 1 or $this->CurrentPlanet[$resource[4]] <= 5){
					$this->BuildBuildings();
				}else{
					$this->BuildSpecialBuildings();	
				}
				
				if($this->CurrentPlanet[$resource[31]] > 0){
					$this->ResearchTechs();
				}
				$Rand = mt_rand(0, 1);
				if($Rand == 1){
					$this->BuildFleet();
				}else{
					$this->BuildDefense();
				}
				
				if($iPlanetCount['total'] < MAX_PLAYER_PLANETS and $maxcolofleet['total'] < (MAX_PLAYER_PLANETS - $maxcolofleet['total']) and $MaxFlyingFleets < $MaxFlottes and $this->CurrentPlanet[$resource[208]] >= 1 ){
					$this->Colonize($iPlanetCount['total']);
				}
				if($this->CurrentPlanet['id'] == $this->player['id_planet']){
					if($MaxFlyingFleets < ($MaxFlottes + 1)){
						$this->HandleOtherFleets();
					}
				}elseif($MaxFlyingFleets < $MaxFlottes){
					$this->GetFleet();
				}				
				$this->Update();
				$planetid = $this->player['id_planet'];		
		}
		$this->End($planetid);
	}
	protected function BuildBuildings(){
		global $BotString, $resource, $lang;
		$CurrentQueue  = $this->CurrentPlanet['b_building_id'];
		if ($CurrentQueue != 0) {
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		} else {
			$QueueArray    = "";
			$ActualCount   = 0;
		}
		if       (($this->CurrentPlanet['energy_max'] == 0 &&
			$this->CurrentPlanet['energy_used'] > 0) or $CurrentUser['urlaubs_modus'] == 1) {
			$production_level = 0;
		} elseif ($this->CurrentPlanet['energy_max']  > 0 &&
			abs($this->CurrentPlanet['energy_used']) > $this->CurrentPlanet['energy_max']) {
			$production_level = floor(($this->CurrentPlanet['energy_max']) / $this->CurrentPlanet['energy_used'] * 100);
		} elseif ($this->CurrentPlanet['energy_max'] == 0 &&
			abs($this->CurrentPlanet['energy_used']) > $this->CurrentPlanet['energy_max']) {
			$production_level = 0;
		} else {
			$production_level = 100;
		}
		if ($production_level > 100) {
			$production_level = 100;
		}
		$production_level = abs($production_level);
		$MaxBuildings = array(1 => 60, 2 => 62, 3 => 65);
		if($production_level < 100){
			if($ActualCount <= 0 and IsElementBuyable ($this->player, $this->CurrentPlanet, 4, true, false) and $this->CurrentPlanet["field_current"] < ( CalculateMaxPlanetFields($this->CurrentPlanet) ) ){
				$this->AddBuildingToQueue ( $this->CurrentPlanet, $this->player, 4, true);
				if($BotString){
					$BotString .= '<tr><th>Construir</th><th>'.$lang['tech'][4].' al nivel '. ($this->CurrentPlanet[$resource[4]] + 1 ).'</th></tr></tr>';
				}
			}
		}else{
			mt_srand(time());
			$Element = mt_rand(1, 3);
			if($this->CurrentPlanet[$resource[$Element]] < $MaxBuildings[$Element]){
				if($ActualCount <= 0 and IsElementBuyable ($this->player, $this->CurrentPlanet, $Element, true, false) and $this->CurrentPlanet["field_current"] < ( CalculateMaxPlanetFields($this->CurrentPlanet) ) ){
					$this->AddBuildingToQueue ( $this->CurrentPlanet, $this->player, $Element, true);
					if($BotString){
						$BotString .= '<tr><th>Construir</th><th>'.$lang['tech'][$Element].' al nivel '. ($this->CurrentPlanet[$resource[$Element]] + 1 ).'</th></tr></tr>';
					}
				}
			}
		}
		SetNextQueueElementOnTop ( $this->CurrentPlanet, $this->player );
		$this->SavePlanetRecord();
	}
	
	protected function BuildSpecialBuildings(){
		global $BotString, $resource, $lang;
		$CurrentQueue  = $this->CurrentPlanet['b_building_id'];
		if ($CurrentQueue != 0) {
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		} else {
			$QueueArray    = "";
			$ActualCount   = 0;
		}
		$MaxBuildings = array(/*33 => 100, */ 14 => 20, 15 => 10, 21 => 17, 31 => 16 );
			uasort( $MaxBuildings, 'scmp' );
			foreach($MaxBuildings as $Element => $Max){
				if($this->CurrentPlanet[$resource[$Element]] < $MaxBuildings[$Element] AND $Element != 0){
					if($ActualCount <= 0 and IsTechnologieAccessible($this->player, $this->CurrentPlanet, $Element) and IsElementBuyable ($this->player, $this->CurrentPlanet, $Element, true, false) and $this->CurrentPlanet["field_current"] < ( CalculateMaxPlanetFields($this->CurrentPlanet) ) ){
						$this->AddBuildingToQueue ( $this->CurrentPlanet, $this->player, $Element, true);
						if($BotString){
							$BotString .= '<tr><th>Construir</th><th>'.$lang['tech'][$Element].' al nivel '. ($this->CurrentPlanet[$resource[$Element]] + 1 ).'</th></tr></tr>';
						}
						break;
					}
				}
				
			}
		
		SetNextQueueElementOnTop ( $this->CurrentPlanet, $this->player );
		$this->SavePlanetRecord();
	}
	protected function BuildStores(){
		global $BotString, $resource, $lang;
		$CurrentQueue  = $this->CurrentPlanet['b_building_id'];
		if ($CurrentQueue != 0) {
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		} else {
			$QueueArray    = "";
			$ActualCount   = 0;
		}
		
		$StoreLevel = array(22 => 20, 23 => 20, 24 => 20);
		foreach($StoreLevel as $Element => $Max){

			if($Element == 22){
				if($ActualCount <= 0 and $this->CurrentPlanet[$resource[$Element]] < $Max and $this->CurrentPlanet['metal'] >= $this->CurrentPlanet['metal_max'] and $Queue2['lenght'] < 2 and IsElementBuyable ($this->player, $this->CurrentPlanet, $Element, true, false) and $this->CurrentPlanet["field_current"] < ( CalculateMaxPlanetFields($this->CurrentPlanet))){
						$this->AddBuildingToQueue ( $this->CurrentPlanet, $this->player, $Element, true);
						if($BotString){
							$BotString .= '<tr><th>Construir</th><th>'.$lang['tech'][$Element].' al nivel '. ($this->CurrentPlanet[$resource[$Element]] + 1 ).'</th></tr></tr>';
						}
						$ActualCount++;
				}
			}elseif($Element == 23){
				if($ActualCount <= 0 and $this->CurrentPlanet[$resource[$Element]] < $Max and $this->CurrentPlanet['crystal'] >= $this->CurrentPlanet['crystal_max'] and $Queue2['lenght'] < 2 and IsElementBuyable ($this->player, $this->CurrentPlanet, $Element, true, false) and $this->CurrentPlanet["field_current"] < ( CalculateMaxPlanetFields($this->CurrentPlanet))){
						$this->AddBuildingToQueue ( $this->CurrentPlanet, $this->player, $Element, true);
						if($BotString){
							$BotString .= '<tr><th>Construir</th><th>'.$lang['tech'][$Element].' al nivel '. ($this->CurrentPlanet[$resource[$Element]] + 1 ).'</th></tr></tr>';
						}
						$ActualCount++;
				}
			}elseif($Element == 24){
				if($ActualCount <= 0 and $this->CurrentPlanet[$resource[$Element]] < $Max and $this->CurrentPlanet['deuterium'] >= $this->CurrentPlanet['deuterium_max'] and $Queue2['lenght'] < 2 and IsElementBuyable ($this->player, $this->CurrentPlanet, $Element, true, false) and $this->CurrentPlanet["field_current"] < ( CalculateMaxPlanetFields($this->CurrentPlanet))){
						$this->AddBuildingToQueue ( $this->CurrentPlanet, $this->player, $Element, true);
						if($BotString){
							$BotString .= '<tr><th>Construir</th><th>'.$lang['tech'][$Element].' al nivel '. ($this->CurrentPlanet[$resource[$Element]] + 1 ).'</th></tr></tr>';
						}
						$ActualCount++;
				}
			}elseif($Element == 0){
			}
		}
		SetNextQueueElementOnTop ( $this->CurrentPlanet, $this->player );
		$this->SavePlanetRecord();
	}
	protected function ResearchTechs(){
		global $resource, $BotString, $lang;
		if ($this->CheckLabSettingsInQueue ( $this->CurrentPlanet ) == true) {		
			$TechLevel =  array(122 => 5, 114 => 9, 118 => 11, 109 => 20, 108 => 20, 113 => 12, 115 => 8, 117 => 8, 124 => 3, 120 => 12, 106 => 12, 111 => 4, 110 => 20, 121 => 7, 199 => 1  );
			uasort( $TechLevel, 'scmp' );
			foreach($TechLevel as $Techno => $Max){
				if($Techno == 0){
				}elseif($this->player["b_tech_planet"] == 0 and $this->player[$resource[$Techno]] < $Max and IsElementBuyable($this->player, $this->CurrentPlanet, $Techno) and IsTechnologieAccessible($this->player, $this->CurrentPlanet, $Techno)){
					$this->Research($Techno);
						if($BotString){
							$BotString .= '<tr><th>Investigar</th><th>'.$lang['tech'][$Techno].' al nivel '. ($this->player[$resource[$Techno]] + 1 ).'</th></tr></tr>';
						}					
					break;
				}		
			}
		}
	}
	protected function Research($Techno){
        if ( IsTechnologieAccessible($this->player, $this->CurrentPlanet, $Techno) && IsElementBuyable($this->player, $this->CurrentPlanet, $Techno) ) {
			$costs                        = GetBuildingPrice($this->player, $this->CurrentPlanet, $Techno);
			$this->CurrentPlanet['metal']      -= $costs['metal'];
			$this->CurrentPlanet['crystal']    -= $costs['crystal'];
			$this->CurrentPlanet['deuterium']  -= $costs['deuterium'];
			$this->CurrentPlanet["b_tech_id"]   = $Techno;
			$this->CurrentPlanet["b_tech"]      = time() + GetBuildingTime($this->player, $this->CurrentPlanet, $Techno);
			$this->player["b_tech_planet"] = $this->CurrentPlanet["id"];
			
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`b_tech_id` = '".   $this->CurrentPlanet['b_tech_id']   ."', ";
			$QryUpdatePlanet .= "`b_tech` = '".      $this->CurrentPlanet['b_tech']      ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '".          $this->CurrentPlanet['id']          ."';";
			doquery( $QryUpdatePlanet, 'planets');

			$QryUpdateUser  = "UPDATE {{table}} SET ";
			$QryUpdateUser .= "`b_tech_planet` = '". $this->player['b_tech_planet'] ."' ";
			$QryUpdateUser .= "WHERE ";
			$QryUpdateUser .= "`id` = '".            $this->player['id']            ."';";
			doquery( $QryUpdateUser, 'users');
		}
	}
	protected function BuildFleet(){
		global $resource;		
			$FleetLevel =  array(212 => 300,218 => 200, 219 => 150, 215 => 150, 214 => 50, 211 => 200, 207 => 500, 209 => 500, 202 => 200,203 => 150, 204 => 345, 205 => 100, 206 => 30, 208 => 1, 210 => 20, 213 => 100);
			uasort( $FleetLevel, 'scmp' );
			foreach($FleetLevel as $Element => $Max){
				if($Element == 0){
					continue;
				}
				if($Element == 212 /* and $this->GetProductionLevel() == 100*/){
					continue;
				}
				if($Element == 218 /* and $this->GetProductionLevel() == 100*/){
					continue;
				}
				$MaxElements   = $this->GetMaxConstructibleElements ( $Element,$this->CurrentPlanet );
				$Count = $MaxElements;
				if ($Count > ($Max * $this->CurrentPlanet[$resource[21]]) ) {
					$Count = ($Max * $this->CurrentPlanet[$resource[21]]);
				}
				$Value = (1 + pow(10, 2) - pow($this->CurrentPlanet[$resource[21]], 2));
				if($Value > 0){
					$Count = ceil($Count / $Value);
				}else{
					$Count = ceil($Count * $Value);
				}
				if(IsElementBuyable($this->player, $this->CurrentPlanet, $Element) and IsTechnologieAccessible($this->player, $this->CurrentPlanet, $Element)){
					$this->HangarBuild($Element, $Count);
				}		
			}
	}
	protected function BuildDefense(){
		global $resource;	
			$DefLevel =  array(401 => 150,402 => 150, 403 => 90, 403 => 110,404 => 70,  406 => 50 /*, 407 => 1, 408 => 1 */);
			uasort( $DefLevel, 'scmp' );
			foreach($DefLevel as $Element => $Max){
				if($Element == 0){
					continue;
				}
				$MaxElements   = $this->GetMaxConstructibleElements ( $Element,$this->CurrentPlanet );
				$Count = $MaxElements;
				if ($Count > ($Max * $this->CurrentPlanet[$resource[21]])) {
					$Count = ($Max * $this->CurrentPlanet[$resource[21]]);
				}
				$Value = (1 + pow(10, 2) - pow($this->CurrentPlanet[$resource[21]], 2));
				if($Value > 0){
					$Count = ceil($Count / $Value);
				}else{
					$Count = ceil($Count * $Value);
				}
				if( IsElementBuyable($this->player, $this->CurrentPlanet, $Element) and IsTechnologieAccessible($this->player, $this->CurrentPlanet, $Element)){
					$this->HangarBuild($Element, $Count);

				}		
			}
	}
	protected function HangarBuild($Element, $Count){
		global $resource, $BotString, $lang;
        $Ressource = $this->GetElementRessources ( $Element, $Count );
		$BuildTime = GetBuildingTime($this->player,$this->CurrentPlanet, $Element, 1);
		if (($Count >= 1 and $this->CurrentPlanet['b_hangar_id'] == "")) {
			$this->CurrentPlanet['metal']           -= $Ressource['metal'];
			$this->CurrentPlanet['crystal']         -= $Ressource['crystal'];
			$this->CurrentPlanet['deuterium']       -= $Ressource['deuterium'];
			$this->CurrentPlanet['b_hangar_id']     .= "". $Element .",". $Count .";";
			if($BotString){
				$BotString .= '<tr><th>Construir</th><th>'.$Count.' '.$lang['tech'][$Element].'</th></tr></tr>';
			}
		}
	}
	protected function HandleOwnFleets(){
		$_fleets = doquery("SELECT * FROM {{table}} WHERE (`fleet_start_time` <= '".time()."') OR (`fleet_end_time` <= '".time()."');", 'fleets'); //  OR fleet_end_time <= ".time()
		while ($row =  mysql_fetch_array($_fleets)) {
			//Actualizar solo flotas que afecten al jugador actual
			if($row['fleet_owner'] == $this->player['id'] or $row['fleet_target_owner'] == $this->player['id']){
				$array                = array();
				$array['galaxy']      = $row['fleet_start_galaxy'];
				$array['system']      = $row['fleet_start_system'];
				$array['planet']      = $row['fleet_start_planet'];
				if($row['fleet_start_time'] <= time()){
					$array['planet_type'] = $row['fleet_start_type'];
				}else{
					$array['planet_type'] = $row['fleet_end_type'];
				}

				$fleet = new FlyingFleetHandler ($array);
				unset($fleet);
				unset($array);
			}
			unset($row);
		}
		unset($_fleets);
	}
	protected function HandleOtherFleets(){
	global $resource, $reslist, $pricelist;
		$_fleets = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` != '".$this->player['id']."' AND `fleet_target_owner` = '".$this->player['id']."' AND `fleet_end_time` <= ".time().";", 'fleets');
		while ($row =  mysql_fetch_array($_fleets)) {
			//Actualizar solo flotas que afecten al jugador actual
			if(($row['fleet_mission'] == 1 or $row['fleet_mission'] == 2 or $row['fleet_mission'] == 9) and ($row['fleet_end_galaxy'] == $this->CurrentPlanet['galaxy'] and $row['fleet_end_system'] == $this->CurrentPlanet['system'] and $row['fleet_end_planet'] == $this->CurrentPlanet['planet'])){
				$array                = array();
				$array['galaxy']      = $row['fleet_start_galaxy'];
				$array['system']      = $row['fleet_start_system'];
				$array['planet']      = $row['fleet_start_planet'];
				if($row['fleet_start_time'] <= time()){
					$array['planet_type'] = $row['fleet_start_type'];
				}else{
					$array['planet_type'] = $row['fleet_end_type'];
				}

				$fleet = new FlyingFleetHandler ($array);
				unset($fleet);
				unset($array);
				$planet = $this->player['planet'];
				$system = $this->player['system'];
				$galaxy = $this->player['galaxy'];
				$fleetarray = array();
				$totalships = 0;
				foreach($reslist['fleet'] as $Element){
					if($this->CurrentPlanet[$resource[$Element]] > 0 and $Element != 212){
						$fleetarray[$Element] = $this->CurrentPlanet[$resource[$Element]];
						$totalships += $this->CurrentPlanet[$resource[$Element]];
					}
				}
				if($totalships > 0){
				$AllFleetSpeed  = GetFleetMaxSpeed ($fleetarray, 0, $this->player);
				$MaxFleetSpeed  = min($AllFleetSpeed);
				$distance      = GetTargetDistance ( $this->CurrentPlanet['galaxy'], $galaxy, $this->CurrentPlanet['system'], $system, $this->CurrentPlanet['planet'], $planet );
				$duration      = GetMissionDuration ( 1, $MaxFleetSpeed, $distance, GetGameSpeedFactor () );
				$consumption   = GetFleetConsumption ( $fleetarray, GetGameSpeedFactor (), $duration, $distance, $MaxFleetSpeed, $this->player );
				$StayDuration    = 0;
				$StayTime        = 0;
				$fleet['start_time'] = $duration + time();
				$fleet['end_time']   = $StayDuration + (2 * $duration) + time();
				$FleetStorage        = 0;
				$fleet_array2 = '';
				$FleetShipCount      = 0;
				$FleetSubQRY         = "";
				foreach ($fleetarray as $Ship => $Count) {
					$FleetStorage    += $pricelist[$Ship]["capacity"] * $Count;
					$FleetShipCount  += $Count;
					$fleet_array2     .= $Ship .",". $Count .";";
					$FleetSubQRY     .= "`".$resource[$Ship] . "` = `" . $resource[$Ship] . "` - " . $Count . " , ";
				}
				$FleetStorage        -= $consumption;
				if (($this->CurrentPlanet['metal']) > ($FleetStorage / 3)) {
					$Mining['metal']   = $FleetStorage / 3;
					$FleetStorage      = $FleetStorage - $Mining['metal'];
				} else {
					$Mining['metal']   = $this->CurrentPlanet['metal'];
					$FleetStorage      = $FleetStorage - $Mining['metal'];
				}
				if (($this->CurrentPlanet['crystal']) > ($FleetStorage / 2)) {
					$Mining['crystal'] = $FleetStorage / 2;
					$FleetStorage      = $FleetStorage - $Mining['crystal'];
				} else {
					$Mining['crystal'] = $this->CurrentPlanet['crystal'];
					$FleetStorage      = $FleetStorage - $Mining['crystal'];
				}
				if (($this->CurrentPlanet['deuterium']) > $FleetStorage) {
					$Mining['deuterium']  = $FleetStorage;
					$FleetStorage      = $FleetStorage - $Mining['deuterium'];
				} else {
					$Mining['deuterium']  = $this->CurrentPlanet['deuterium'];
					$FleetStorage      = $FleetStorage - $Mining['deuterium'];
				}				
				$QryInsertFleet  = "INSERT INTO {{table}} SET ";
				$QryInsertFleet .= "`fleet_owner` = '". $this->player['id'] ."', ";
				$QryInsertFleet .= "`fleet_mission` = '4', ";
				$QryInsertFleet .= "`fleet_amount` = '". $FleetShipCount ."', ";
				$QryInsertFleet .= "`fleet_array` = '". $fleet_array2 ."', ";
				$QryInsertFleet .= "`fleet_start_time` = '". $fleet['start_time'] ."', ";
				$QryInsertFleet .= "`fleet_start_galaxy` = '". $this->CurrentPlanet['galaxy'] ."', ";
				$QryInsertFleet .= "`fleet_start_system` = '". $this->CurrentPlanet['system'] ."', ";
				$QryInsertFleet .= "`fleet_start_planet` = '". $this->CurrentPlanet['planet'] ."', ";
				$QryInsertFleet .= "`fleet_start_type` = '". $this->CurrentPlanet['planet_type'] ."', ";
				$QryInsertFleet .= "`fleet_end_time` = '". $fleet['end_time'] ."', ";
				$QryInsertFleet .= "`fleet_end_stay` = '". $StayTime ."', ";
				$QryInsertFleet .= "`fleet_end_galaxy` = '". $galaxy ."', ";
				$QryInsertFleet .= "`fleet_end_system` = '". $system ."', ";
				$QryInsertFleet .= "`fleet_end_planet` = '". $planet ."', ";
				$QryInsertFleet .= "`fleet_end_type` = '1', ";
				$QryInsertFleet .= "`fleet_resource_metal` = '".$Mining['metal']."', ";
				$QryInsertFleet .= "`fleet_resource_crystal` = '".$Mining['crystal']."', ";
				$QryInsertFleet .= "`fleet_resource_deuterium` = '".$Mining['deuterium']."', ";
				$QryInsertFleet .= "`fleet_target_owner` = '0', ";
				$QryInsertFleet .= "`fleet_group` = '0', ";
				$QryInsertFleet .= "`start_time` = '". time() ."';";
				doquery( $QryInsertFleet, 'fleets');
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= $FleetSubQRY;
				$QryUpdatePlanet .= "`id` = '". $this->CurrentPlanet['id'] ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $this->CurrentPlanet['id'] ."'";
				doquery("LOCK TABLE {{table}} WRITE", 'planets');
				doquery ($QryUpdatePlanet, "planets");
				doquery("UNLOCK TABLES", '');
				$this->CurrentPlanet["metal"]  -= $Mining['metal'];
				$this->CurrentPlanet["crystal"]  -= $Mining['crystal'];
				$this->CurrentPlanet["deuterium"]  -= $consumption + $Mining['deuterium'];
				}		
			}
			unset($row);
		}
		unset($_fleets);
	}
	protected function Colonize($iPlanetCount){
		global $resource, $pricelist;	
			if($iPlanetCount >= 4){
				$planet = mt_rand(1, MAX_PLANET_IN_SYSTEM);
				$system = mt_rand(1, MAX_SYSTEM_IN_GALAXY);
				$galaxy = mt_rand(1, MAX_GALAXY_IN_WORLD);
			}else{
				$planet = mt_rand(1, MAX_PLANET_IN_SYSTEM);
				$system = mt_rand(($this->CurrentPlanet['system'] - 2), ($this->CurrentPlanet['system'] + 2));
				$galaxy = $this->CurrentPlanet['galaxy'];			
			}
			$Colo = doquery("SELECT count(*) AS `total` FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND `planet` = '".$planet."' AND `planet_type` = '1';", 'planets', true);
			if($Colo['total'] == 0){
				$fleetarray         = array(208 => 1);
				$AllFleetSpeed  = GetFleetMaxSpeed ($fleetarray, 0, $this->player);
				$MaxFleetSpeed  = min($AllFleetSpeed);
				$distance      = GetTargetDistance ( $this->CurrentPlanet['galaxy'], $galaxy, $this->CurrentPlanet['system'], $system, $this->CurrentPlanet['planet'], $planet );
				$duration      = GetMissionDuration ( 10, $MaxFleetSpeed, $distance, GetGameSpeedFactor () );
				$consumption   = GetFleetConsumption ( $fleetarray, GetGameSpeedFactor (), $duration, $distance, $MaxFleetSpeed, $this->player );
				$StayDuration    = 0;
				$StayTime        = 0;
				$fleet['start_time'] = $duration + time();
				$fleet['end_time']   = $StayDuration + (2 * $duration) + time();
				$FleetStorage        = 0;
				$fleet_array2 = '';
				$FleetShipCount      = 0;
				$FleetSubQRY         = "";
				foreach ($fleetarray as $Ship => $Count) {
					$FleetStorage    += $pricelist[$Ship]["capacity"] * $Count;
					$FleetShipCount  += $Count;
					$fleet_array2     .= $Ship .",". $Count .";";
					$FleetSubQRY     .= "`".$resource[$Ship] . "` = `" . $resource[$Ship] . "` - " . $Count . " , ";
				}
				
				$QryInsertFleet  = "INSERT INTO {{table}} SET ";
				$QryInsertFleet .= "`fleet_owner` = '". $this->player['id'] ."', ";
				$QryInsertFleet .= "`fleet_mission` = '7', ";
				$QryInsertFleet .= "`fleet_amount` = '". $FleetShipCount ."', ";
				$QryInsertFleet .= "`fleet_array` = '". $fleet_array2 ."', ";
				$QryInsertFleet .= "`fleet_start_time` = '". $fleet['start_time'] ."', ";
				$QryInsertFleet .= "`fleet_start_galaxy` = '". $this->CurrentPlanet['galaxy'] ."', ";
				$QryInsertFleet .= "`fleet_start_system` = '". $this->CurrentPlanet['system'] ."', ";
				$QryInsertFleet .= "`fleet_start_planet` = '". $this->CurrentPlanet['planet'] ."', ";
				$QryInsertFleet .= "`fleet_start_type` = '". $this->CurrentPlanet['planet_type'] ."', ";
				$QryInsertFleet .= "`fleet_end_time` = '". $fleet['end_time'] ."', ";
				$QryInsertFleet .= "`fleet_end_stay` = '". $StayTime ."', ";
				$QryInsertFleet .= "`fleet_end_galaxy` = '". $galaxy ."', ";
				$QryInsertFleet .= "`fleet_end_system` = '". $system ."', ";
				$QryInsertFleet .= "`fleet_end_planet` = '". $planet ."', ";
				$QryInsertFleet .= "`fleet_end_type` = '1', ";
				$QryInsertFleet .= "`fleet_resource_metal` = '0', ";
				$QryInsertFleet .= "`fleet_resource_crystal` = '0', ";
				$QryInsertFleet .= "`fleet_resource_deuterium` = '0', ";
				$QryInsertFleet .= "`fleet_target_owner` = '0', ";
				$QryInsertFleet .= "`fleet_group` = '0', ";
				$QryInsertFleet .= "`start_time` = '". time() ."';";
				doquery( $QryInsertFleet, 'fleets');
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= $FleetSubQRY;
				$QryUpdatePlanet .= "`id` = '". $this->CurrentPlanet['id'] ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $this->CurrentPlanet['id'] ."'";
				doquery ($QryUpdatePlanet, "planets");
				$this->CurrentPlanet["deuterium"]  -= $consumption;
			}else{
				$this->Colonize($iPlanetCount);
			}

		
	}
	protected function GetFleet(){
		global $resource, $reslist, $pricelist;
			$planet = $this->player['planet'];
			$system = $this->player['system'];
			$galaxy = $this->player['galaxy'];
			$fleetarray = array();
			$totalships = 0;
			foreach($reslist['fleet'] as $Element){
				if($this->CurrentPlanet[$resource[$Element]] > 0 and $Element != 212){
					$fleetarray[$Element] = $this->CurrentPlanet[$resource[$Element]];
					$totalships += $this->CurrentPlanet[$resource[$Element]];
				}
			}
			if(($this->CurrentPlanet[$resource[21]] <= 5 and $totalships > 150) or $totalships > 5000){
				$AllFleetSpeed  = GetFleetMaxSpeed ($fleetarray, 0, $this->player);
				$MaxFleetSpeed  = min($AllFleetSpeed);
				$distance      = GetTargetDistance ( $this->CurrentPlanet['galaxy'], $galaxy, $this->CurrentPlanet['system'], $system, $this->CurrentPlanet['planet'], $planet );
				$duration      = GetMissionDuration ( 10, $MaxFleetSpeed, $distance, GetGameSpeedFactor () );
				$consumption   = GetFleetConsumption ( $fleetarray, GetGameSpeedFactor (), $duration, $distance, $MaxFleetSpeed, $this->player );
				$StayDuration    = 0;
				$StayTime        = 0;
				$fleet['start_time'] = $duration + time();
				$fleet['end_time']   = $StayDuration + (2 * $duration) + time();
				$FleetStorage        = 0;
				$fleet_array2 = '';
				$FleetShipCount      = 0;
				$FleetSubQRY         = "";
				$Mining = array();
				foreach ($fleetarray as $Ship => $Count) {
					$FleetStorage    += $pricelist[$Ship]["capacity"] * $Count;
					$FleetShipCount  += $Count;
					$fleet_array2     .= $Ship .",". $Count .";";
					$FleetSubQRY     .= "`".$resource[$Ship] . "` = `" . $resource[$Ship] . "` - " . $Count . " , ";
				}
				$FleetStorage        -= $consumption;
				if (($this->CurrentPlanet['metal']) > ($FleetStorage / 3)) {
					$Mining['metal']   = $FleetStorage / 3;
					$FleetStorage      = $FleetStorage - $Mining['metal'];
				} else {
					$Mining['metal']   = $this->CurrentPlanet['metal'];
					$FleetStorage      = $FleetStorage - $Mining['metal'];
				}
				if (($this->CurrentPlanet['crystal']) > ($FleetStorage / 2)) {
					$Mining['crystal'] = $FleetStorage / 2;
					$FleetStorage      = $FleetStorage - $Mining['crystal'];
				} else {
					$Mining['crystal'] = $this->CurrentPlanet['crystal'];
					$FleetStorage      = $FleetStorage - $Mining['crystal'];
				}
				if (($this->CurrentPlanet['deuterium']) > $FleetStorage) {
					$Mining['deuterium']  = $FleetStorage;
					$FleetStorage      = $FleetStorage - $Mining['deuterium'];
				} else {
					$Mining['deuterium']  = $this->CurrentPlanet['deuterium'];
					$FleetStorage      = $FleetStorage - $Mining['deuterium'];
				}				
				$QryInsertFleet  = "INSERT INTO {{table}} SET ";
				$QryInsertFleet .= "`fleet_owner` = '". $this->player['id'] ."', ";
				$QryInsertFleet .= "`fleet_mission` = '4', ";
				$QryInsertFleet .= "`fleet_amount` = '". $FleetShipCount ."', ";
				$QryInsertFleet .= "`fleet_array` = '". $fleet_array2 ."', ";
				$QryInsertFleet .= "`fleet_start_time` = '". $fleet['start_time'] ."', ";
				$QryInsertFleet .= "`fleet_start_galaxy` = '". $this->CurrentPlanet['galaxy'] ."', ";
				$QryInsertFleet .= "`fleet_start_system` = '". $this->CurrentPlanet['system'] ."', ";
				$QryInsertFleet .= "`fleet_start_planet` = '". $this->CurrentPlanet['planet'] ."', ";
				$QryInsertFleet .= "`fleet_start_type` = '". $this->CurrentPlanet['planet_type'] ."', ";
				$QryInsertFleet .= "`fleet_end_time` = '". $fleet['end_time'] ."', ";
				$QryInsertFleet .= "`fleet_end_stay` = '". $StayTime ."', ";
				$QryInsertFleet .= "`fleet_end_galaxy` = '". $galaxy ."', ";
				$QryInsertFleet .= "`fleet_end_system` = '". $system ."', ";
				$QryInsertFleet .= "`fleet_end_planet` = '". $planet ."', ";
				$QryInsertFleet .= "`fleet_end_type` = '1', ";
				$QryInsertFleet .= "`fleet_resource_metal` = '".$Mining['metal']."', ";
				$QryInsertFleet .= "`fleet_resource_crystal` = '".$Mining['crystal']."', ";
				$QryInsertFleet .= "`fleet_resource_deuterium` = '".$Mining['deuterium']."', ";
				$QryInsertFleet .= "`fleet_target_owner` = '0', ";
				$QryInsertFleet .= "`fleet_group` = '0', ";
				$QryInsertFleet .= "`start_time` = '". time() ."';";
				doquery( $QryInsertFleet, 'fleets');
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= $FleetSubQRY;
				$QryUpdatePlanet .= "`id` = '". $this->CurrentPlanet['id'] ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $this->CurrentPlanet['id'] ."'";
				doquery ($QryUpdatePlanet, "planets");
				$this->CurrentPlanet["metal"]  -= $Mining['metal'];
				$this->CurrentPlanet["crystal"]  -= $Mining['crystal'];
				$this->CurrentPlanet["deuterium"]  -= $consumption + $Mining['deuterium'];
			}
		
	}
	protected function SavePlanetRecord(){	
		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
		$QryUpdatePlanet .= "`b_building_id` = '". $this->CurrentPlanet['b_building_id'] ."', ";
		$QryUpdatePlanet .= "`b_building` = '".    $this->CurrentPlanet['b_building']    ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '".            $this->CurrentPlanet['id']            ."';";
		doquery( $QryUpdatePlanet, 'planets');	
	}
	protected function Update(){
		//UpdatePlanet($this->CurrentPlanet, $this->player, time(), true);
       UpdatePlanetBatimentQueueList ( $this->CurrentPlanet, $this->player );  
       HandleTechnologieBuild($this->CurrentPlanet,$this->player);
		PlanetResourceUpdate ( $this->player, $this->CurrentPlanet, time() );
	}
	protected function End($planetid){
		$QryUpdateUser  = "UPDATE {{table}} SET ";
		$QryUpdateUser .= "`onlinetime` = '". time() ."', ";
		$QryUpdateUser .= "`user_lastip` = 'BOT', ";
		$QryUpdateUser .= "`user_agent` = 'UGamelaPlay NewBot v". $this->VERSION ."' ";
		$QryUpdateUser .= "WHERE ";
		$QryUpdateUser .= "`id` = '". $this->player['id'] ."' LIMIT 1;";
		doquery( $QryUpdateUser, 'users');
		$QryUpdateBot  = " UPDATE {{table}} SET ";
		$QryUpdateBot .= "`last_time` = '". time() ."', ";
		$QryUpdateBot .= "`last_planet` = '".$planetid."' ";
		$QryUpdateBot .= "WHERE ";
		$QryUpdateBot .= "`id` = '". $this->Bot['id'] ."' LIMIT 1;";
		doquery( $QryUpdateBot, 'bots'); 
	}
	protected function AddBuildingToQueue (&$CurrentPlanet, $CurrentUser, $Element, $AddMode = true)
	{
		global $resource;

		$CurrentQueue  = $CurrentPlanet['b_building_id'];

		$CurrentMaxFields  	= CalculateMaxPlanetFields($CurrentPlanet);
		if ($CurrentQueue != 0)
		{
			$QueueArray    = explode ( ";", $CurrentQueue );
			$ActualCount   = count ( $QueueArray );
		}
		else
		{
			$QueueArray    = "";
			$ActualCount   = 0;
		}

		if ($AddMode == true)
		{
			$BuildMode = 'build';
		}
		else
		{
			$BuildMode = 'destroy';
		}

		if ( $ActualCount < MAX_BUILDING_QUEUE_SIZE)
		{
			$QueueID      = $ActualCount + 1;
		}
		else
		{
			$QueueID      = false;
		}

		if ( $QueueID != false )
		{
			if ($QueueID > 1)
			{
				$InArray = 0;
				for ( $QueueElement = 0; $QueueElement < $ActualCount; $QueueElement++ )
				{
					$QueueSubArray = explode ( ",", $QueueArray[$QueueElement] );
					if ($QueueSubArray[0] == $Element)
					{
						$InArray++;
					}
				}
			}
			else
			{
				$InArray = 0;
			}

			if ($InArray != 0)
			{
				$ActualLevel  = $CurrentPlanet[$resource[$Element]];
				if ($AddMode == true)
				{
					$BuildLevel   = $ActualLevel + 1 + $InArray;
					$CurrentPlanet[$resource[$Element]] += $InArray;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$CurrentPlanet[$resource[$Element]] -= $InArray;
				}
				else
				{
					$BuildLevel   = $ActualLevel - 1 - $InArray;
					$CurrentPlanet[$resource[$Element]] -= $InArray;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
					$CurrentPlanet[$resource[$Element]] += $InArray;
				}
			}
			else
			{
				$ActualLevel  = $CurrentPlanet[$resource[$Element]];
				if ($AddMode == true)
				{
					$BuildLevel   = $ActualLevel + 1;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				}
				else
				{
					$BuildLevel   = $ActualLevel - 1;
					$BuildTime    = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element) / 2;
				}
			}

			if ($QueueID == 1)
			{
				$BuildEndTime = time() + $BuildTime;
			}
			else
			{
				$PrevBuild = explode (",", $QueueArray[$ActualCount - 1]);
				$BuildEndTime = $PrevBuild[3] + $BuildTime;
			}

			$QueueArray[$ActualCount]       = $Element .",". $BuildLevel .",". $BuildTime .",". $BuildEndTime .",". $BuildMode;
			$NewQueue                       = implode ( ";", $QueueArray );
			$CurrentPlanet['b_building_id'] = $NewQueue;
		}
	}
	private function CheckLabSettingsInQueue ($CurrentPlanet)
	{
		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			if (strpos ($CurrentQueue, ";"))
			{
				// FIX BY LUCKY - IF THE LAB IS IN QUEUE THE USER CANT RESEARCH ANYTHING...
				$QueueArray		= explode (";", $CurrentQueue);

				for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)
				{
					$ListIDArray	= explode (",", $QueueArray[$i]);
					$Element		= $ListIDArray[0];

					if($Element == 31)
						break;
				}
				// END - FIX
			}
			else
			{
				$CurrentBuilding = $CurrentQueue;
			}

			if ($CurrentBuilding == 31 or $Element == 31) // ADDED (or $Element == 31) BY LUCKY
			{
				$return = false;
			}
			else
			{
				$return = true;
			}
		}
		else
		{
			$return = true;
		}

		return $return;
	}
	private function GetMaxConstructibleElements ($Element, $Ressources)
	{
		global $pricelist;

		if ($pricelist[$Element]['metal'] != 0)
		{
			$Buildable        = floor($Ressources["metal"] / $pricelist[$Element]['metal']);
			$MaxElements      = $Buildable;
		}

		if ($pricelist[$Element]['crystal'] != 0)
			$Buildable        = floor($Ressources["crystal"] / $pricelist[$Element]['crystal']);

		if (!isset($MaxElements))
			$MaxElements      = $Buildable;
		elseif($MaxElements > $Buildable)
			$MaxElements      = $Buildable;

		if ($pricelist[$Element]['deuterium'] != 0)
			$Buildable        = floor($Ressources["deuterium"] / $pricelist[$Element]['deuterium']);

		if (!isset($MaxElements))
			$MaxElements      = $Buildable;
		elseif ($MaxElements > $Buildable)
			$MaxElements      = $Buildable;

		if ($pricelist[$Element]['energy'] != 0)
			$Buildable        = floor($Ressources["energy_max"] / $pricelist[$Element]['energy']);

		if ($Buildable < 1)
			$MaxElements      = 0;

		return $MaxElements;
	}
	private function GetElementRessources($Element, $Count)
	{
		global $pricelist;

		$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
		$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
		$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);

		return $ResType;
	}	
}

class BotDatabase{
	private $SQLite;
	
	function __construct($Database){
		global $xgp_root;
		if(!file_exists($xgp_root.'includes/'.$Database.'.botdb')){		
			$this->SQLite = new SQLiteDatabase($xgp_root.'includes/'.$Database.'.botdb');
			$this->SQLite->query("CREATE TABLE [actions] (
				[id] INTEGER  NOT NULL PRIMARY KEY,
				[function] TEXT  NOT NULL,
				[parameters] TEXT  NOT NULL,
				[priority] FLOAT DEFAULT '1' NOT NULL,
				[time] TIME  NOT NULL
				);

				CREATE TABLE [config] (
				[name] TEXT  UNIQUE NOT NULL PRIMARY KEY,
				[value] TEXT  NULL
				);

				CREATE TABLE [objetives] (
				[id] INTEGER  NOT NULL PRIMARY KEY,
				[id_user] INTEGER  NOT NULL,
				[id_planet] INTEGER  NOT NULL,
				[galaxy] INTEGER  NOT NULL,
				[system] INTEGER  NOT NULL,
				[planet] INTEGER  NOT NULL,
				[planet_type] INTEGER DEFAULT '1' NOT NULL,
				[priority] FLOAT DEFAULT '1' NOT NULL
				);");
		}else{
			$this->SQLite = new SQLiteDatabase($xgp_root.'includes/'.$Database.'.botdb');
		}
	}
	
	function doquery($query, $fetch = false){
		$result = $this->Db->query($query);
		if($fetch){
			$array = $result->fetch();
			return $array;
		}else{
			return $result;
		}
	}

}

?>