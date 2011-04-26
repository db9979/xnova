<?php //options.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;


include("common.php");
include("cookies.php");

{// init

	$userrow = checkcookies();//Identificaci�n del usuario

	CheckUserExist($userrow);

	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
}

if($_POST && $mode == "change"){ //Array ( [db_character] 
	
	$iduser = $userrow["id"];
	$avatar = $_POST["avatar"];
	$dpath = $_POST["dpath"];
	//Mostrar skin
	if($_POST["design"] == 'on'){
		$design = "1";
	}else{
		$design = "0";
	}
	//Desactivar comprobaci�n de IP
	if($_POST["noipcheck"] == 'on'){
		$noipcheck = "1";
	}else{
		$noipcheck = "0";
	}
	//Cantidad de sondas de espionaje
	if(is_numeric($_POST["spio_anz"])){
		$spio_anz = $_POST["spio_anz"];
	}else{
		$spio_anz = "1";
	}
	//Mostrar tooltip durante
	if(is_numeric($_POST["settings_tooltiptime"])){
		$settings_tooltiptime = $_POST["settings_tooltiptime"];
	}else{
		$settings_tooltiptime = "1";
	}
	//Maximo mensajes de flotas
	if(is_numeric($_POST["settings_fleetactions"])){
		$settings_fleetactions = $_POST["settings_fleetactions"];
	}else{
		$settings_fleetactions = "1";
	}//
	//Mostrar logos de los aliados
	if($_POST["settings_allylogo"] == 'on'){
		$settings_allylogo = "1";
	}else{
		$settings_allylogo = "0";
	}
	//Espionaje
	if($_POST["settings_esp"] == 'on'){
		$settings_esp = "1";
	}else{
		$settings_esp = "0";
	}
	//Escribir mensaje
	if($_POST["settings_wri"] == 'on'){
		$settings_wri = "1";
	}else{
		$settings_wri = "0";
	}
	//A�adir a lista de amigos
	if($_POST["settings_bud"] == 'on'){
		$settings_bud = "1";
	}else{
		$settings_bud = "0";
	}
	//Ataque con misiles
	if($_POST["settings_mis"] == 'on'){
		$settings_mis = "1";
	}else{
		$settings_mis = "0";
	}
	//Ver reporte
	if($_POST["settings_rep"] == 'on'){
		$settings_rep = "1";
	}else{
		$settings_rep = "0";
	}
	//Modo vacaciones
	if($_POST["urlaubs_modus"] == 'on'){
		$urlaubs_modus = "1";
	}else{
		$urlaubs_modus = "0";
	}
	//Borrar cuenta
	if($_POST["db_deaktjava"] == 'on'){
		$db_deaktjava = "1";
	}else{
		$db_deaktjava = "0";
	}
	
	doquery("UPDATE {{table}} SET
	`email` = '$db_email',
	`avatar` = '$avatar',
	`dpath` = '$dpath',
	`design` = '$design',
	`noipcheck` = '$noipcheck',
	`spio_anz` = '$spio_anz',
	`settings_tooltiptime` = '$settings_tooltiptime',
	`settings_fleetactions` = '$settings_fleetactions',
	`settings_allylogo` = '$settings_allylogo',
	`settings_esp` = '$settings_esp',
	`settings_wri` = '$settings_wri',
	`settings_bud` = '$settings_bud',
	`settings_mis` = '$settings_mis',
	`settings_rep` = '$settings_rep',
	`urlaubs_modus` = '$urlaubs_modus',
	`db_deaktjava` = '$db_deaktjava'
	WHERE `id` = '$iduser' LIMIT 1","users");
	
	
	if(isset($_POST["db_password"]) && md5($_POST["db_password"]) == $userrow["password"]){
		
		if($_POST["newpass1"] == $_POST["newpass2"]){
			$newpass = md5($_POST["newpass1"]);
			doquery("UPDATE {{table}} SET `password` = '$newpass' WHERE `id` = '$iduser' LIMIT 1","users");
			setcookie('ogamela', "", time()-100000, "/", "", 0);//le da el expire
			error("La contrase�a se cambio correctamente.<br />\n<a href=\"index.php\" target=\"_top\">Volver</a>","Cambio de contrase�a");
		}
		
	}
	error("Los datos se guardaron correctamente.<br />\n<a href=\"options.php\">Volver</a>","Opciones");
}
else
{

echo_head("Opciones");
echo_topnav(); ?>
<center>
<br>

<form action="options.php?mode=change" method="post">
 <table width="519">

     <tbody><tr><td class="c" colspan="2">Datos de usuario</td></tr>
<tr>
      <th>Nombre de usuario</th>
   <th><input name="db_character" size="20" value="<? echo $userrow['username'] ?>" type="text"></th>
    </tr>
  <tr>
  <th>Contrase�a anterior</th>
   <th><input name="db_password" size="20" value="" type="password"></th>
  </tr>
  <tr>
  <th>Nueva contrase�a (min. 8 Caracteres)</th>
   <th><input name="newpass1" size="20" maxlength="40" type="password"></th>
  </tr>
  <tr>
  <th>Nueva contrase�a (repetir)</th>
   <th><input name="newpass2" size="20" maxlength="40" type="password"></th>
  </tr>
  <tr>
  <th><a title="Esta direcci�n puede ser cambiada en cualquier momento. La direcci�n sera permanente si no se realizan cambios en los pr�ximos 7 d�as.">Direcci�n de correo electr�nico</a></th>
  <th><input name="db_email" maxlength="100" size="20" value="<? echo $userrow['email'] ?>" type="text"></th>
  </tr>
  <tr>
  <th>Direcci�n pemanente de correo electr�nico</th>
   <th><? echo $userrow['email_2'] ?></th>
  </tr>
   <tr><th colspan="2">
  </th></tr>
  <tr>
  <td class="c" colspan="2">Ajustes generales</td>
  </tr>
  <tr>
   <th>Skins (p.e. /ugamela/css/)<br> <a href="http://80.237.203.201/download/" target="_blank">Descargar</a></th>
   <th><input name="dpath" maxlength="80" size="40" value="<? echo $userrow['dpath'] ?>" type="text"> <br>
  </tr>
  <tr>
   <th>Avatar (p.e. /img/avatar.jpg)<br> <a href="http://www.google.com.ar/imghp" target="_blank">Buscar</a></th>
   <th><input name="avatar" maxlength="80" size="40" value="<? echo $userrow['avatar'] ?>" type="text">
   </th>
  </tr>
  <tr>
  <th>Mostrar skin</th>
   <th>
    <input name="design"<? if($userrow['design'] == 1) echo " checked='checked'"; ?> type="checkbox">
   </th>
  </tr>
  <tr>
    <th><a title="La comprobaci�n de IP significa que se realizar� un logout de seguridad autom�ticamente cuando cambie la IP o cuando 2 personas entren en la misma cuenta usando diferentes IPs.
Desactivar la comprobaci�n de IP puede ser un agujero de seguridad! ">Desactivar comprobaci�n de IP</a></th>
   <th><input name="noipcheck"<? if($userrow['noipcheck'] == 1) echo " checked='checked'"; ?> type="checkbox" /></th>
  </tr>
  <tr>
   <td class="c" colspan="2">Opciones de visi�n de Galaxia</td>
  </tr>
  <tr>
   <th><a title="Cantidad de sondas de espionaje que ser�n enviadas en cada espionaje desde el men� de galaxia">Cantidad de sondas de espionaje</a></th>
   <th><input name="spio_anz" maxlength="2" size="2" value="<? echo $userrow['spio_anz'] ?>" type="text"></th>
  </tr>
  <tr>
   <th>Mostrar tooltip durante</th>
   <th><input name="settings_tooltiptime" maxlength="2" size="2" value="<? echo $userrow['settings_tooltiptime'] ?>" type="text"> Segundos</th>
  </tr>
  <tr>
   <th>Maximo mensajes de flotas</th>
   <th><input name="settings_fleetactions" maxlength="2" size="2" value="<? echo $userrow['settings_fleetactions'] ?>" type="text"></th>
  </tr>
  <tr>
   <th>Mostrar logos de los aliados</th>
   <th><input name="settings_allylogo"<? if($userrow['settings_allylogo'] == 1) echo " checked='checked'/"; ?> type="checkbox" /></th>
  </tr>
     <tr>
   <th>Accesos directos</th>
   <th>Mostrar</th>
  </tr>
      <tr>
   <th><img src="<? echo "$dpath"; ?>img/e.gif" alt="">   Espionaje</th>
   <th><input name="settings_esp"<? if($userrow['settings_esp'] == 1) echo " checked='checked'/"; ?> type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="<? echo "$dpath"; ?>img/m.gif" alt="">   Escribir mensaje</th>
   <th><input name="settings_wri"<? if($userrow['settings_wri'] == 1) echo " checked='checked'/"; ?> type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="<? echo "$dpath"; ?>img/b.gif" alt="">   A�adir a lista de amigos</th>
   <th><input name="settings_bud"<? if($userrow['settings_bud'] == 1) echo " checked='checked'/"; ?> type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="<? echo "$dpath"; ?>img/r.gif" alt="">   Ataque con misiles</th>
   <th><input name="settings_mis"<? if($userrow['settings_mis'] == 1) echo " checked='checked'/"; ?> type="checkbox" /></th>
   </tr>
      <tr>
   <th><img src="<? echo "$dpath"; ?>img/s.gif" alt="">   Ver reporte</th>
   <th><input name="settings_rep"<? if($userrow['settings_rep'] == 1) echo " checked='checked'/"; ?> type="checkbox" /></th>
   </tr>
         
    <tr>
     <td class="c" colspan="2">Modo de vacaciones / Borrar cuenta</td>
  </tr>
  <tr>
     <th><a title="El modo de vacaciones protege el planeta cuando el usuario se ausenta por mucho tiempo. Solamente es posible activarlo cuando no se est� construyendo nada (edificio, nave espacial, sistema de defensa) o investigando, y que no haya ninguna flota realizando una misi�n.
Al activar el modo de vacaciones el planeta ser� protegido de recibir nuevos ataques, pero los ataques que hayan empezado antes de activar  el modo de vacaciones ser�n realizados igualmente. La producci�n de recursos bajar� autom�ticamente a 0% durante el modo de vacaciones y hay que cambiarla manualmente a 100% al desactivar el modo de vacaciones. El modo de vacaciones tiene una duraci�n m�nima de 2 d�as, solo despues de estos 2 d�as es posible desactivarlo.">Activar modo de vacaciones</a></th>
   <th>
    <input name="urlaubs_modus"<? if($userrow['urlaubs_modus'] == 1) echo " checked='checked'/"; ?> type="checkbox" />
   </th>


  

  </tr>
  <tr>
   <th><a title="Tu cuenta ser� borrada completamente en 7 d�as si pones una palomita aqui.">Borrar cuenta</a></th>
   <th><input name="db_deaktjava"<? if($userrow['db_deaktjava'] == 1) echo " checked='checked'/"; ?> type="checkbox" />
   
   
   
   </th>
  </tr>
  <tr>
   <th colspan="2"><input value="Guardar cambios" type="submit"></th>
  </tr>


   
 </tbody></table>

 
</form>

</center>
</body>
</html><?
}


//  Timer, para comprobar la velocidad del scriptd
if($userrow['authlevel'] == 3){
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>