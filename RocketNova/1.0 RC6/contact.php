<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

	includeLang('contact');

	$BodyTPL = gettemplate('contact_body');
	$RowsTPL = gettemplate('contact_body_rows');
	$parse   = $lang;

	$QrySelectUser  = "SELECT `username`, `email`, `authlevel`, `id`  ";
	$QrySelectUser .= "FROM {{table}} ";
	$QrySelectUser .= "WHERE `authlevel` != '0' ORDER BY `authlevel` DESC;";
	$GameOps = doquery ( $QrySelectUser, 'users');

	while( $Ops = mysql_fetch_assoc($GameOps) ) {
		$bloc['ctc_data_name']    = $Ops['username'];
		$bloc['ctc_data_auth']    = $lang['user_level'][$Ops['authlevel']];
		$bloc['ctc_data_mail']    = "<a href=mailto:".$Ops['email']."?subject=Anfrage_AG-XNova_Uni1_>".$Ops['email']."</a>";

            if(empty($user['authlevel'])) {
    		$bloc['ctc_data_pn']	= "login";
		} else {
    		$bloc['ctc_data_pn']	= "<a href=messages.php?mode=write&id=".$Ops['id'].">".$lang['ctc_pn']."</a>";
            }
		$parse['ctc_admin_list'] .= parsetemplate($RowsTPL, $bloc);
	}

	$page = parsetemplate($BodyTPL, $parse);
	display($page, $lang['ctc_title'], false);

?>

