<script type="text/javascript"><!--
var sym_list = Array();

<!-- BEGIN simulator -->
  <!-- IF simulator.ID && simulator.GROUP != 400 -->
    sym_list[{simulator.ID}] = '{simulator.VALUE}';
  <!-- ENDIF -->
<!-- END simulator -->

function sym_set(id, value)
{
  if(!value)
  {
    value = 0;
  }
  else
  {
    value = sym_list[id];
  }

  element_cache['attacker' + id].value = value;
}

function sym_set_all(group, value)
{
  for(sym_id in sym_list)
  {
    if(sym_id >= group && sym_id < group +100)
    {
      sym_set(sym_id, value);
    }
  }
}
--></script>

<h2>{COE_combatSimulator}</h2>
<form action='simulator.php' method='post'>
  <table>
    <tr>
      <td class="c">&nbsp;</td>
      <td class="c">{L_sys_attacker}</td>
      <td class="c">{L_sys_defender}</td>
    </tr>

    <!-- BEGIN simulator -->
    <tr>
      <!-- IF simulator.ID -->
        <th>{simulator.NAME}</th>
        <th>
          <!-- IF simulator.GROUP != 400 -->
            <span class="fl"><input type="button" class="button" tabindex=-1 value="0" onclick="sym_set({simulator.ID});"></span>
            <span class="fl">&nbsp;&nbsp;<input type='text' tabindex=1{simulator.NUM} group="attacker{simulator.ID}" id="attacker{simulator.ID}" name='attacker[{simulator.ID}]' value='{simulator.ATTACKER}'>&nbsp;&nbsp;</span>
            <span class="fr"><input type="button" class="button" tabindex=-1 value="{L_sys_max}" onclick="sym_set({simulator.ID}, 1);"></span>
          <!-- ELSE -->
            &nbsp;
          <!-- ENDIF -->
        </th>
        <th><input type='text' tabindex=2{simulator.NUM} name='defender[{simulator.ID}]' value='{simulator.DEFENDER}'></th>
      <!-- ELSE -->
        <!-- IF simulator.GROUP != 400 -->
          <td class=c>{simulator.NAME}</td>
          <td class=c>
            <span class="fl"><input type="button" class="button" tabindex=-1 value="0" onclick="sym_set_all({simulator.GROUP})"></span>
            <span class="fr"><input type="button" class="button" tabindex=-1 value="{L_sys_max}" onclick="sym_set_all({simulator.GROUP}, true)">&nbsp;</span>
          </td>
          <td class=c>&nbsp;</td>
        <!-- ELSE -->
          <td class=c colspan=3>{simulator.NAME}</td>
        <!-- ENDIF -->
      <!-- ENDIF -->
    </tr>
    <!-- END simulator -->

    <tr><th colspan='3'><input type='submit' class="button" name='submit' value='{L_COE_simulate}'></th></tr>
  </table>
  <input type='hidden' name='BE_DEBUG' value="{BE_DEBUG}">
</form>
