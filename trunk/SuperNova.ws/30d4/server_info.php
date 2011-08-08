<?php

$allow_anonymous = true;
include('common.' . substr(strrchr(__FILE__, '.'), 1));

lng_include('admin');

$template = gettemplate('server_info', true);

$template->assign_vars(array(
  'game_speed' => get_game_speed(),
  'fleet_speed' => get_fleet_speed(),
  'game_build_and_research' => $config->BuildLabWhileRun,
  'USER_VACATION_DISABLE' => $config->user_vacation_disable,
  'ALLOW_BUFFING' => $config->allow_buffing,
  'ALLY_HELP_WEAK' => $config->ally_help_weak,
  'DB_VERSION' => DB_VERSION,
  'SN_VERSION' => SN_VERSION,
  'FLEET_BASHING_ATTACKS' => $config->fleet_bashing_attacks,
  'fleet_bashing_interval' => sys_time_human($config->fleet_bashing_interval),
  'fleet_bashing_scope' => sys_time_human($config->fleet_bashing_scope),
  'fleet_bashing_war_delay' => sys_time_human($config->fleet_bashing_war_delay),
));

display(parsetemplate($template));

?>