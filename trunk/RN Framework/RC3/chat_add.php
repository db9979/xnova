<?php

/**
 * chat_add.php
 *
 * @version 1.0
 * @version 1.2 by Ihor
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root_path = './';
include($xgp_root_path . 'extension.inc.php');
include($xgp_root_path . 'common.' . $phpEx);

if ($IsUserChecked == false) {
    includeLang('INGAME');
    header("Location: login.php");
}

    // On récupère les informations du message et de l'envoyeur
    if (isset($_POST["msg"]) && isset($user['username'])) {
       $msg  = addslashes ($_POST["msg"]);
       $nick = addslashes ($user['username']);
       $chat_type = addslashes ($_POST["chat_type"]);
       $ally_id = addslashes ($_POST["ally_id"]);
       $nick = addslashes ($user['username']);
       // If non UTF-8 Encoding
       //$msg = iconv('UTF-8', 'cp1251', $msg); // CHANGE IT !!!!!!!!!!!
    }
    else {
       $msg="";
       $nick="";
    }
    if ($msg!="" && $nick!="") {
        if($chat_type=="ally" && $ally_id>""){
            $query = doquery("INSERT INTO {{table}}(user, ally_id, message, timestamp) VALUES ('".$nick."','".$ally_id."','".$msg."', '".time()."')", "chat");
        }else{
            $query = doquery("INSERT INTO {{table}}(user, ally_id, message, timestamp) VALUES ('".$nick."','0', '".$msg."', '".time()."')", "chat");
        }
    }
?>