<div id="log_menu">
  <!-- BEGIN language -->
    <a href="{FILENAME}?lang={language.LANG_NAME_ISO2}{referral}"><img src="language/{language.LANG_NAME_ISO2}/{language.LANG_FLAG}" /></a>
  <!-- END language -->
</div>

<div id="log_menu">
  <a href="login.php{LANG}{referral}">{L_log_login_page}</a> ::
  <a href="reg.php{LANG}{referral}">{L_log_reg}</a> ::
  <a href="lostpassword.php{LANG}{referral}">{L_PasswordLost}</a>
  </br>

  <!-- IF URL_RULES -->
  <a href="{URL_RULES}">{L_log_rules}</a> ::
  <!-- ENDIF -->
  <a href="server_info.php{LANG}">{L_log_cred}</a> ::
  <a href="stat.php{LANG}">{L_log_stat_menu}</a>
  <!-- IF URL_FAQ -->
  :: <a href="{URL_FAQ}">{L_log_faq}</a>
  <!-- ENDIF -->
  <br />

  <a href="announce.php{LANG}">{L_log_news}</a> ::
  <!-- IF URL_FORUM -->
  <a href="{URL_FORUM}">{L_log_forums}</a> ::
  <!-- ENDIF -->
  <a href="banned.php{LANG}">{L_log_banned}</a> ::
  <a href="contact.php{LANG}">{L_log_contacts}</a>
</div>
