<?php

/**
 * records.php
 *
 * @version 1.4
 * @copyright 2008 by Chlorel for XNova
 */

	includeLang('records');

	$RecordTpl = gettemplate('records_body');
	$HeaderTpl = gettemplate('records_section_header');
	$TableRows = gettemplate('records_section_rows');

	$parse['rec_title'] = $lang['rec_title'];

	$bloc['section']    = $lang['rec_build'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_level'];
	$parse['building']  = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_specb'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_level'];
	$parse['buildspe']  = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_techn'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_level'];
	$parse['research']  = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_fleet'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_nbre'];
	$parse['fleet']     = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_defes'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_nbre'];
	$parse['defenses']  = parsetemplate( $HeaderTpl, $bloc);


	foreach($lang['tech'] as $Element => $ElementName) {
		if ($ElementName != "") {
			if ($resource[$Element] != "") {
				// Je sais bien qu'il n'y a aucune raison de blinder ce test ...
				// Mais avec les zozos qui vont le pomper ... Mieux vaut prevoir que guerir !!
				if       ($Element >=   1 && $Element <=  39 || $Element == 44) {
					// Batiment
					$Query = $DB->query("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM ".PREFIX."planets WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM ".PREFIX."planets);");
					$PlanetRow = $Query->fetch();
					$Query2 = $DB->query("SELECT `username` FROM ".PREFIX."users WHERE `id` = '".$PlanetRow['id_owner']."';");
					$UserRow = $Query2->fetch();
					$Row['element']     = $ElementName;
					$Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
					$Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
					$parse['building'] .= parsetemplate( $TableRows, $Row);
				} elseif ($Element >=  41 && $Element <=  99 && $Element != 44) {
					// Batiment spéciaux
					$Query = $DB->query("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM ".PREFIX."planets WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM ".PREFIX."planets WHERE `id_level` = '0')");
					$PlanetRow = $Query->fetch();
					$Query2 = $DB->query("SELECT `username` FROM ".PREFIX."users WHERE `id` = '".$PlanetRow['id_owner']."';");
					$UserRow = $Query2->fetch();
					$Row['element']     = $ElementName;
					$Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
					$Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
					$parse['buildspe'] .= parsetemplate( $TableRows, $Row);
				} elseif ($Element >= 101 && $Element <= 199) {
					// Techno
					$Query = $DB->query("SELECT `username`, `". $resource[$Element] ."` AS `current` FROM ".PREFIX."users WHERE `". $resource[$Element] ."` = (SELECT MAX(`". $resource[$Element] ."`) FROM ".PREFIX."users WHERE `authlevel` = '0')");
					$UserRow = $Query->fetch();
					$Row['element']     = $ElementName;
					$Row['winner']      = ($UserRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
					$Row['count']       = ($UserRow['current'] != 0) ? pretty_number( $UserRow['current'] ) : $lang['rec_rien'];
					$parse['research'] .= parsetemplate( $TableRows, $Row);
				} elseif ($Element >= 201 && $Element <= 399) {
					// Flotte
					$Query = $DB->query("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM ".PREFIX."planets WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM ".PREFIX."planets WHERE `id_level` = '0')");
					$PlanetRow = $Query->fetch();
					$Query2 = $DB->query("SELECT `username` FROM ".PREFIX."users WHERE `id` = '".$PlanetRow['id_owner']."';");
					$UserRow = $Query2->fetch();
					$Row['element']     = $ElementName;
					$Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
					$Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
					$parse['fleet']    .= parsetemplate( $TableRows, $Row);
				} elseif ($Element >= 401 && $Element <= 599) {
					// Défenses
					$Query = $DB->query("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM ".PREFIX."planets WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM ".PREFIX."planets WHERE `id_level` = '0')");
					$PlanetRow = $Query->fetch();
					$Query2 = $DB->query("SELECT `username` FROM ".PREFIX."users WHERE `id` = '".$PlanetRow['id_owner']."';");
					$UserRow = $Query2->fetch();
					$Row['element']     = $ElementName;
					$Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
					$Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
					$parse['defenses'] .= parsetemplate( $TableRows, $Row);
				}
			}
		}
	}

	$page = parsetemplate( $RecordTpl, $parse );
	display($page, $lang['rec_title']);

// -----------------------------------------------------------------------------------------------------------
// History version
// - 1.0 Réécriture
// - 1.1 Ajout du test de presence d'un chmap de la base de données ... Si apres ca ca plante c'est
//       que l'utilisateur de ce module est vraiment trop con et devrait arreter l'informatique pour aller
//       vendre des frittes chez Mc Do ou autre FastFood
// - 1.2 Separateur de chiffres ... qu'ils soient comme partout ailleur dans le jeu
// - 1.3 Remplacement des 0 par un texte ou un '-' (suggestion matdu57)
// - 1.4 Non prise en compte des planetes protégées
?>