<br />
<table width="519">
  <form action="fleet_shortcuts.php" method="post" name="fForm">
    <tr><td class="c" colspan=2><!-- IF MODE == 'edit' -->{L_shortcut_edit}<!-- ELSEIF MODE == 'copy' -->{L_shortcut_copy}<!-- ELSE -->{L_shortcut_add}<!-- ENDIF --></td></tr>
    <tr>
      <td>{L_sys_coordinates}</td>
      <td>
        <span class="fl">
          <input name="galaxy" size="3" maxlength="3" value="{GALAXY}"> :
          <input name="system" size="3" maxlength="4" value="{SYSTEM}"> :
          <input name="planet" size="3" maxlength="3" value="{PLANET}">
          <select name="planet_type" onChange="shortInfo()" onKeyUp="shortInfo()">
            <option value="{D_PT_PLANET}" {t1}>{L_sys_planet_type[1]}</option>
            <option value="{D_PT_DEBRIS}" {t2}>{L_sys_planet_type[2]}</option>
            <option value="{D_PT_MOON}" {t3}>{L_sys_planet_type[3]}</option>
          </select>
        </span>

        <span class="fr"><!-- IF MODE == 'edit' -->{L_shortcut_mode_edit}<!-- ELSEIF MODE == 'copy' -->{L_shortcut_mode_copy}<!-- ELSE -->{L_shortcut_new}<!-- ENDIF --></span>
        <input type="hidden" name="id" value="{ID}">
        <input type="hidden" name="mode" value="{MODE}">
      </td>
    </tr>

    <tr>
      <td>{L_shortcut_text}</td>
      <td><input name="text" size="60" maxlength="64" value="{TEXT}"></td>
    </tr>
    <tr><td colspan="2" align="center"><input type=submit value="<!-- IF MODE == 'edit' -->{L_shortcut_edit}<!-- ELSEIF MODE == 'copy' -->{L_shortcut_copy}<!-- ELSE -->{L_shortcut_add}<!-- ENDIF -->"></td></tr>
  </form>
</table>

<br />

<table width="519">
  <tr><td class="c" colspan="5">{L_shortcut_title}</td></tr>
  <tr>
    <th>{L_sys_coordinates}</th>
    <th width="100%">{L_shortcut_text}</th>
    <th><img src="design/images/icon_edit.png"></th>
    <th><img src="design/images/icon_copy.gif"></th>
    <th><img src="design/images/r1.png"></th>
  </tr>
  <!-- BEGIN shortcut -->
    <tr>
      <td>
        {shortcut.PLANET_TYPE} {shortcut.COORDINATES} 
      </td>
      <td align=left>
        {shortcut.TEXT}
      </td>
      <td><a href="fleet_shortcuts.php?mode=edit&id={shortcut.ID}"><img src="design/images/icon_edit.png"></a></td>
      <td><a href="fleet_shortcuts.php?mode=copy&id={shortcut.ID}"><img src="design/images/icon_copy.gif"></a></td>
      <td><a href="fleet_shortcuts.php?mode=del&id={shortcut.ID}"><img src="design/images/r1.png"></a></td>
    </tr>
  <!-- END shortcut -->
</table>
