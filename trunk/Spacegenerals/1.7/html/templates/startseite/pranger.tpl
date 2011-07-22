﻿
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="layout.css" rel="stylesheet" type="text/css" />
<script src="rollover.js" type="text/javascript"></script>
</head>

<body id="page5" onload="MM_preloadImages('images/m1_act.jpg','images/m2_act.jpg','images/m3_act.jpg','images/m4_act.jpg','images/m5_act.jpg','images/m6_act.jpg')">	<div id="main">
		<!-- header -->
		<div id="header">
			<div class="row_1">
				<div class="fleft">{url}</div>
				<ul class="top_nav">
					<li><a href="kontakt.php">{Kontakt}</a></li>
					<li><a class="last" href="impressum.php">{Impressum}</a></li>
				</ul>
			</div>
			<div class="row_2">
				<div class="inner">
					<a href="index.php"><img alt="" src="images/logo.png" /></a><br />

				</div>
			</div>
			<div class="row_3">
<a href="index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_1','','images/m1_act.jpg',1)"><img alt="" src="images/m1.jpg" id="r_1" /></a><a href="forum/index.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_2','','images/m2_act.jpg',1)"><img alt="" src="images/m2.jpg" id="r_2" /></a><a href="irc.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_3','','images/m3_act.jpg',1)"><img alt="" src="images/m3.jpg" id="r_3" /></a><a href="pranger.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_4','','images/m4_act.jpg',1)"><img alt="" src="images/m4_act.jpg" id="r_4" /></a><a href="gameinfos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_5','','images/m5_act.jpg',1)"><img alt="" src="images/m5.jpg" id="r_5" /></a><a href="kontakt.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('r_6','','images/m6_act.jpg',1)"><img alt="" src="images/m6.jpg" id="r_6" /></a>    			</div>
		</div>
		<!-- content -->
		<div id="content">
			<div class="bgd">
				<div class="inner">
					<div class="extra">
						<a href="index.php"><img alt="" src="images/login.jpg" /></a><a href="reg.php"><img alt="" src="images/reg.jpg" /></a><a href="pw.php"><img alt="" src="images/pw.jpg" /></a>
					</div>
					<div class="article">
						<div class="wrapper">
							<div class="col_1">
								<h5>{pbk}</h5>
<table width="600" id="table5">
<tbody>
<tr>
	<td colspan="4" class="c" align="Center"><b>{ctc_title}</b></td>
</tr><tr>
	<th colspan="4">
		<font color="orange">{ctc_intro}</font>
	</th>
</tr><tr>
	<th><font color="lime">{ctc_name}</font></th>
	<th><font color="lime">{ctc_rank}</font></th>
	<th><font color="lime">{ctc_mail}</font></th>
	<th><font color="lime">{ctc_pn}</font></th>
</tr>
	{ctc_admin_list}
</tbody>
</table>
      <table width="600" style="color:#FFFFFF" id="table6">
	<td class="c" colspan="5"><center>{ban_title}</center></td>
</tr><tr>
	  <th width="95">{ban_name}</th>
	  <th width="130">{ban_from}</th>
	  <th width="130">{ban_to}</th>
      <th width="150">{ban_reason}</th>
	  <th width="95">{ban_by}</th>
</tr>
{banned}
</table>
							</div>

							<div class="col_2">
								<h5>{Infos}</h5>
								<table width="250" border="0" cellspacing="0" cellpadding="0" id="table2">
  <tr>
    <td><font size="p2" color="#E3F8E6">{log_online}:</font></td>
    <td width="125"><font face="Verdana, Arial, Helvetica, sans-serif" size="p2" class="font">
	{online_users}</font></td>
  </tr>
  <tr>
    <td><font size="p2" color="#E3F8E6">{log_lastreg}:</font></td>
    <td width="125"><font face="Verdana, Arial, Helvetica, sans-serif" size="p2" class="font">
	{last_user}</font></td>
  </tr>
  <tr>
    <td><font size="p2" color="#E3F8E6">{log_numbreg}:</font></td>
    <td width="125"><font face="Verdana, Arial, Helvetica, sans-serif" size="p2" class="font">
	{users_amount}</font></td>
  </tr>
</table>
							  <br><table width="250" border="0" cellspacing="0" cellpadding="0" id="table3">
  <tr>
    <td width="125"><font size="p2" color="#E3F8E6">{pto}:</font></td>
    <td width="125"><font face="Verdana, Arial, Helvetica, sans-serif" size="p2" class="font">
	{OnlineAdmins}</font></td>
  </tr>
  </table>
								<p>&nbsp;</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- footer -->
		<div id="footer">
			<div class="fleft">
<!-- Darf nicht geänder oder Gelöscht werden -->
<!-- änderung oder löschung führt zu anzeige -->
				{copyright}
<!-- Must not be changed or deleted -->
<!-- modification or deletion leads to ad -->
			</div>
			<div class="fright">
				<a href="index.php"><img alt="" src="images/footer_img1.jpg" /></a><a href="reg.php"><img alt="" src="images/footer_img2.jpg" /></a><a href="forum/index.php"><img alt="" src="images/footer_img3.jpg" /></a><a href="impressum.php"><img alt="" src="images/footer_img4.jpg" /></a>
			</div>
		</div>
	</div>
</body>
</html>
</body>
</html>
</body>
</html>