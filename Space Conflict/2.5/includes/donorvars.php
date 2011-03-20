<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** donorvars.php                         **
******************************************/

if ( defined('INSIDE')) {

	$donorid = array(1 => "metal_mine",
			   2 => "crystal_mine",
			   3 => "deuterium_sintetizer",
			   4 => "tach_accel",
			   5 => "solar_plant",
			  12 => "fusion_plant",
			  14 => "robot_factory",
			  15 => "nano_factory",
			  21 => "hangar",
			  22 => "metal_store",
			  23 => "crystal_store",
			  24 => "deuterium_store",
			  25 => "tachyon_store",
			  31 => "laboratory",
			  33 => "terraformer",
			  34 => "ally_deposit",
			  35 => "orb_shipyard",
			  41 => "mondbasis",
			  42 => "phalanx",
			  43 => "sprungtor",
			  44 => "silo",

			 106 => "spy_tech",
			 108 => "computer_tech",
			 109 => "military_tech",
			 110 => "defence_tech",
			 111 => "shield_tech",
			 113 => "energy_tech",
			 114 => "hyperspace_tech",
			 115 => "combustion_tech",
			 117 => "impulse_motor_tech",
			 118 => "hyperspace_motor_tech",
			 120 => "laser_tech",
			 121 => "ionic_tech",
			 122 => "buster_tech",
			 123 => "intergalactic_tech",
			 124 => "expedition_tech",
			 194 => "tach_extract_tech",
			 195 => "tach_compress_tech",
			 196 => "genetic_tech",
			 197 => "quantum_tech",
			 198 => "quantum_drive_tech",
			 199 => "graviton_tech",
			 200 => "tach_tech",

			 202 => "small_ship_cargo",
			 203 => "big_ship_cargo",
			 204 => "freighter",
			 205 => "light_hunter",
			 206 => "heavy_hunter",
			 207 => "elite_fighter",
			 208 => "crusher",
			 209 => "battle_ship",
			 210 => "colonizer",
			 211 => "recycler",
			 212 => "spy_sonde",
			 213 => "bomber_ship",
			 214 => "solar_satelit",
			 215 => "destructor",
			 216 => "dearth_star",
			 217 => "battleship",
			 218 => "world_eater",

			 401 => "misil_launcher",
			 402 => "small_laser",
			 403 => "big_laser",
			 404 => "gauss_canyon",
			 405 => "ionic_canyon",
			 406 => "buster_canyon",
			 407 => "small_protection_shield",
			 408 => "big_protection_shield",
			 409 => "orb_def_plat",

			 996 => "metal",
			 997 => "crystal",
			 998 => "deuterium",
			 999 => "tachyon");


	$donorname = array(1 => "Metal Mine",
			     2 => "Crystal Mine",
			     3 => "Deuterium Synthetsizer",
			     4 => "Tachyon Accelerator",
			     5 => "Solar Plant",
			    12 => "Fusion Reactor",
			    14 => "Robotics Factory",
			    15 => "Nanite Factory",
			    21 => "Shipyard",
			    22 => "Metal Storage",
			    23 => "Crystal Storage",
			    24 => "Deuterium Tank",
			    25 => "Tachyon Containment Center",
			    31 => "Research Lab",
			    33 => "Terraformer",
			    34 => "Alliance Depot",
			    35 => "Orbital Shipyard",
			    44 => "Missile Silo",

			   106 => "Espionage Technology",
			   108 => "Computer Technology",
			   109 => "Weapons Technology",
			   110 => "Armor Technology",
			   111 => "Shield Technology",
			   113 => "Energy Technology",
			   114 => "Hyperspace Technology",
			   115 => "Combustion Drive Technology",
			   117 => "Impulse Drive Technology",
			   118 => "Hyperspace Drive Technology",
			   120 => "Laser Technology",
			   121 => "Ion Technology",
			   122 => "Plasma Technology",
			   123 => "Intergalactic Research Network",
			   124 => "Expedition Technology",
			   194 => "Tachyon Extraction Technology",
			   195 => "Tachyon Compression Technology",
			   196 => "Genetics Technology",
			   197 => "Quantum Physics",
			   198 => "Quantum Drive Technology",
			   199 => "Graviton Technology",
			   200 => "Tachyon Technology",

			   202 => "Small Cargo Ship",
			   203 => "Large Cargo Ship",
			   204 => "Freighter",
			   205 => "Light Fighter",
			   206 => "Heavy Fighter",
			   207 => "Elite Fighter",
			   208 => "Cruiser",
			   209 => "Battleship",
			   210 => "Colony Ship",
			   211 => "Recycler",
			   212 => "Espionage Probe",
			   213 => "Bomber",
			   214 => "Solar Satalite",
			   215 => "Destroyer",
			   216 => "Death Star",
			   217 => "Battlecruiser",
			   218 => "World Eater",

			   401 => "Rocket Launcher",
			   402 => "Small Laser",
			   403 => "Large Laser",
			   404 => "Gauss cannon",
			   405 => "Ion Cannon",
			   406 => "Plasma Cannon",
			   407 => "Small Shield Dome",
			   408 => "Large Shield Dome",
			   409 => "Orbital Defense Platform",

			   996 => "Metal",
			   997 => "Crystal",
			   998 => "Deuterium",
			   999 => "Tachyon Particles");

	$donorcost = array(1 => 5,
			     2 => 10,
			     3 => 15,
			     4 => 25,
			     5 => 5,
			    12 => 15,
			    14 => 15,
			    15 => 35,
			    21 => 10,
			    22 => 5,
			    23 => 10,
			    24 => 15,
			    25 => 25,
			    31 => 10,
			    33 => 25,
			    34 => 5,
			    35 => 50,
			    44 => 5,

			   106 => 5,
			   108 => 5,
			   109 => 5,
			   110 => 5,
			   111 => 10,
			   113 => 10,
			   114 => 10,
			   115 => 10,
			   117 => 15,
			   118 => 15,
			   120 => 10,
			   121 => 15,
			   122 => 20,
			   123 => 25,
			   124 => 20,
			   194 => 25,
			   195 => 25,
			   196 => 10,
			   197 => 10,
			   198 => 15,
			   199 => 25,
			   200 => 10,

			   202 => 1,
			   203 => 5,
			   204 => 100,
			   205 => 5,
			   206 => 10,
			   207 => 25,
			   208 => 50,
			   209 => 75,
			   210 => 1,
			   211 => 1,
			   212 => 1,
			   213 => 25,
			   214 => 1,
			   215 => 75,
			   216 => 250,
			   217 => 100,
			   218 => 500,

			   401 => 1,
			   402 => 5,
			   403 => 2,
			   404 => 10,
			   405 => 15,
			   406 => 25,
			   407 => 5,
			   408 => 10,
			   409 => 150,

			   996 => 500,
			   997 => 1000,
			   998 => 2500,
			   999 => 10000);

}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>	