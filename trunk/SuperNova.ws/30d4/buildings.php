<?php

/**
 * buildings.php
 *
 *  Allow building of... hmm... buildings
 *
 * @version 1.3s Security checks by Gorlum for http://supernova.ws
 * @version 1.3
// History version
// 1.0 - Nettoyage modularisation
// 1.1 - Mise au point, mise en fonction pour lin�arisation du fonctionnement
// 1.2 - Liste de construction batiments
 * @copyright 2008 by Chlorel for XNova
 */

include('common.' . substr(strrchr(__FILE__, '.'), 1));

$mode = sys_get_param_escaped('mode');

lng_include('buildings');
lng_include('infos');

$mode = (!$mode || $mode == 'buildings') ? QUE_STRUCTURES : ($mode == 'fleet' ? SUBQUE_FLEET : ($mode == 'defense' ? SUBQUE_DEFENSE : $mode));

switch ($mode)
{
  case 'research':
  case QUE_RESEARCH:
    // --------------------------------------------------------------------------------------------------
    ResearchBuildingPage($user, $planetrow, $que);
  break;

  case SUBQUE_FLEET:
  case SUBQUE_DEFENSE:
    eco_build_hangar($mode, $user, $planetrow, $que);
  break;

  case QUE_STRUCTURES:
  default:
    eco_build(QUE_STRUCTURES, $user, $planetrow, $que);
  break;
}

?>
