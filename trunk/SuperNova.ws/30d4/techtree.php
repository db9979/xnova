<?php

/**
 * techtree.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

include('common.' . substr(strrchr(__FILE__, '.'), 1));

$HeadTpl = gettemplate('techtree_head');
$RowTpl  = gettemplate('techtree_row');

foreach($lang['tech'] as $Element => $ElementName)
{
  $parse            = array();
  $parse['tt_name'] = $ElementName;
  if (!isset($sn_data[$Element]['name']))
  {
    $parse['Requirements']  = $lang['Requirements'];
    $page                  .= parsetemplate($HeadTpl, $parse);
  }
  else
  {
    if (isset($sn_data[$Element]['require']))
    {
      $parse['required_list'] = "";
      foreach($sn_data[$Element]['require'] as $ResClass => $Level)
      {
        if(isset($user[$sn_data[$ResClass]['name']]) && $user[$sn_data[$ResClass]['name']] >= $Level)
        {
          $parse['required_list'] .= "<font color=\"#00ff00\">";
        }
        elseif ( isset($planetrow[$sn_data[$ResClass]['name']] ) && $planetrow[$sn_data[$ResClass]['name']] >= $Level)
        {
          $parse['required_list'] .= "<font color=\"#00ff00\">";
        }
        else
        {
          $parse['required_list'] .= "<font color=\"#ff0000\">";
        }
        //$parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['level'] ." ". $Level .")";
        $parse['required_list'] .= $lang['tech'][$ResClass] ." ( ". $lang['level'] ." ". $user[$sn_data[$ResClass]['name']] ." ". $planetrow[$sn_data[$ResClass]['name']] ." / ". $Level ." )";
        $parse['required_list'] .= "</font><br>";
      }
      // $parse['tt_detail']      = "<a href=\"techdetails.php?techid=". $Element ."\">" .$lang['treeinfo'] ."</a>";
    }
    else
    {
      $parse['required_list'] = "";
      $parse['tt_detail']     = "";
    }
    $parse['tt_info']   = $Element;
    $page              .= parsetemplate($RowTpl, $parse);
  }
}

$parse['techtree_list'] = $page;

display(parsetemplate(gettemplate('techtree_body'), $parse), $lang['Tech']);

// -----------------------------------------------------------------------------------------------------------
// History version
// - 1.0 mise en conformité code avec skin XNova
// - 1.1 ajout lien pour les details des technos
// - 1.2 suppression du lien details ou il n'est pas necessaire
?>