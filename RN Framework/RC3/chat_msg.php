<?php
 ini_set('display_error',0);
 ini_set('error_reporting',0);
/**
 * chat_msg.php
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

includeLang('INGAME');

$page_limit = 30; // Chat rows Limit
if($_GET['page']>''){
    $page = $_GET['page'];
}else{
    $page = 0;
}
$start_row = $page * $page_limit;

if ($_GET) {
    if($_GET['chat_type']=='ally' && $_GET['ally_id']>''){
        if ($_GET['show']=='history') {
            if($_GET['ally_id'] != $user['ally_id']){
            message($lang['Error_1'], $lang['Error']);
            }
            showPageButtons($page,'ally');
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."' ORDER BY messageid DESC LIMIT ".$start_row.",".$page_limit." ", "chat");
        }else{
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."' ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
        }
    }else{
        if ($_GET['show']=='history') {
            showPageButtons($page,'all');
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id < 1 ORDER BY messageid DESC LIMIT ".$start_row.",".$page_limit." ", "chat");
        }else{
            $query = doquery("SELECT * FROM {{table}} WHERE ally_id < 1 ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
        }
    }
}else{
    if($_POST['chat_type']=='ally' && $_POST['ally_id']>''){
        $query = doquery("SELECT * FROM {{table}} WHERE ally_id = '".$_POST['ally_id']."' ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
    }else{
        $query = doquery("SELECT * FROM {{table}} WHERE ally_id < 1 ORDER BY messageid DESC LIMIT ".$page_limit." ", "chat");
    }
}

$buff = "";
while($v=mysql_fetch_object($query)){
    $msg = "";
    if($_GET['show']!='history'){
        $nick="<a href='#' onmousedown=\"addSmiley('[ ".$v->user." ]')\">".$v->user."</a>";
    // If non UTF-8 Encoding
    //  $nick="<a href='#' onmousedown=\"addSmiley('[ ".htmlentities($v->user, ENT_QUOTES, cp1251)." ]')\">".htmlentities($v->user, ENT_QUOTES, cp1251)."</a>";
    }else{
        $nick=$v->user;
        // If non UTF-8 Encoding
        //$nick=htmlentities($v->user, ENT_QUOTES, cp1251);
    }
    $msg=$v->message;
    // If non UTF-8 Encoding
    //$msg=htmlentities($v->message, ENT_QUOTES, cp1251);
    $msgtimestamp=$v->timestamp;
    // If non UTF-8 Encoding
    //$msgtimestamp=htmlentities($v->timestamp, ENT_QUOTES, cp1251);
        
    $msgtimestamp=date("m/d H:i:s", $msgtimestamp);
    // Les différentes polices (gras, italique, couleurs, etc...)
    include("includes/msg_replace.php");  

    // Affichage du message
    $msg="<div align=\"left\" style='color:white;'><span style='font:menu;'>[".$msgtimestamp."]</span> <span style='width:50px;font:menu;'><b>".$nick."</b></span> : ".$msg."<br></div>";
    $buff = $msg . $buff;
}
print $buff;

function showPageButtons($curPage,$type){
    global $page_limit,$lang;
    echo "<div style='width:100%;border:1px solid red;padding:4px;' align=center>";
    echo "<b><font size=3>".$lang['AllyChat']." / ".$lang['chat_history']."</font></b> ";
    echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    echo "<b><font size=2>".$lang['chat_page'].":</font></b> ";
    echo "<select name='page' onchange='document.location.assign(\"chat_msg.php?chat_type=".$_GET['chat_type']."&ally_id=".$_GET['ally_id']."&show=".$_GET['show']."&page=\"+this.value)'>";
    if($type=='ally'){
        $rows = doquery("SELECT count(1) AS CNT FROM {{table}} WHERE ally_id = '".$_GET['ally_id']."'", "chat",true);
        $cnt = $rows['CNT'] / $page_limit;
        for($i = 0; $i < $cnt; $i++) {
            if($curPage==$i){
                echo "<option value=".$i." selected>".$i."</option> ";
            }else{
                echo "<option value=".$i.">".$i."</option> ";
            }
        }
    }else{
        $rows = doquery("SELECT count(1) AS CNT FROM {{table}} WHERE ally_id < 1", "chat",true);
        $cnt = $rows['CNT'] / $page_limit;
        for($i = 0; $i < $cnt; $i++) {
            if($curPage==$i){
                echo "<option value=".$i." selected>".$i."</option> ";
            }else{
                echo "<option value=".$i.">".$i."</option> ";
            }
        }
    }
    echo "</select> ";
    echo "</div>";
}

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>
