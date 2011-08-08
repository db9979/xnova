<br />

<!-- DEFINE $QUE_ID = '{QUE_ID}' -->
<!-- INCLUDE eco_queue.tpl -->

<div>{error_msg}</div>

<font color="#ff0000">{noresearch}</font>

<form action="buildings.php?mode={MODE}" method="post">
  <!-- IF .production -->
  <table valign="top" align="center" width="600px">
    <!-- IF $QUE_NOT_EMPTY -->
      <tr>
        <th colspan="2" class="c" align="center">
          <table width=100% class="noborder">
            <tr>
              <th width=120px>
                <div id="ov_{QUE_ID}"></div>
                <div id="ov_{QUE_ID}_timer" style="color: lime"></div>
                <div>{L_sys_total_time}</div>
                <div id="ov_{QUE_ID}_total" style="color: red"></div>
              </th>
              <th id="ov_{QUE_ID}_que"></th>
            </tr>
          </table>
        </th>
      </tr>

      <tr>
        <td colspan="2" class="c" align="center">
          <div class="fl"><a href="buildings.php?mode={QUE_ID}&action=clear">{L_eco_que_clear}</a></div>
          <div class="fr"><a href="buildings.php?mode={QUE_ID}&action=trim">{L_eco_que_trim}</a></div>
        </td>
      </tr>
    <!-- ELSE -->
      <tr>
        <th colspan="2" class="c_c" align="center">
          {L_eco_que_empty}
        </th>
      </tr>
    <!-- ENDIF -->

    <!-- BEGIN production -->
    <tr>
      <th>
        <a href="infos.php?gid={production.ID}">
          {production.NAME}<br />
          <img border=0 src="{dpath}gebaeude/{production.ID}.gif" align=top width=120 height=120>
        </a>
      </th>
      <td valign="top">
        <table border=0 valign=top>
          <tr>
            <td align=justify valign="top" style="border: 0">{production.DESCRIPTION}</td>
            <td valign=top style="border: 0">
              <table valign=top width=165>
                <tr>
                  <th class="c_l">{L_sys_ship_armour}</th>
                  <td class="c_r" width=65>{production.ARMOR}</td>
                </tr>
                <tr>
                  <th class="c_l">{L_sys_ship_shield}</th>
                  <td class="c_r">{production.SHIELD}</td>
                </tr>
                <tr>
                  <th class="c_l">{L_sys_ship_weapon}</th>
                  <td class="c_r">{production.WEAPON}</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align=center valign=top style="border: 0">
              <table align="center">
                <tr>
                  <th class="c_l">{L_ConstructionTime}</th>
                  <td class="c_r">{production.TIME}</td>
                </tr>
                <tr>
                  <th class="c_l">{L_built}</th>
                  <td class="c_r">{production.LEVEL}</td>
                </tr>
<!--
                <tr>
                  <th class="c_l">{L_can_build}</th>
                  <td class="c_r">{production.BUILD_CAN}</td>
                </tr>
-->
              </table>
              <!-- IF production.BUILD_CAN && ! production.MESSAGE-->
                <input type=text name=fmenge[{production.ID}] alt='{production.NAME}' size=5 maxlength=5 value=0 tabindex="{production.TABINDEX}"> / {production.BUILD_CAN} <input type="submit" value="{L_Construire}">
              <!-- ELSEIF production.MESSAGE -->
                <span class="error">{production.MESSAGE}</span>
              <!-- ENDIF -->
            </td>
            <td valign=top style="border: 0">
              <table align="center" width=165>
                <!-- IF production.METAL -->
                <tr>
                  <th class="c_l">{L_sys_metal}</th>
                  <td class="c_r" width=65>{production.METAL_PRINT}</td>
                </tr>
                <!-- ENDIF -->
                <!-- IF production.CRYSTAL -->
                <tr>
                  <th class="c_l">{L_sys_crystal}</th>
                  <td class="c_r">{production.CRYSTAL_PRINT}</td>
                </tr>
                <!-- ENDIF -->
                <!-- IF production.DEUTERIUM -->
                <tr>
                  <th class="c_l">{L_sys_deuterium}</th>
                  <td class="c_r">{production.DEUTERIUM_PRINT}</td>
                </tr>
                <!-- ENDIF -->
              </table>
            </td>
          </tr>
        </table>
    </tr>
    <!-- END production -->
  </table>
  <!-- ELSE -->
  <!-- ENDIF -->

</form>
