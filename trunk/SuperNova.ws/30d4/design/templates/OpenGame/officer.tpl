<table width="530">
  <tr>
    <td colspan="2" class="c">{L_sys_dark_matter}</td>
  </tr>

  <tr>
    <th width="120" ><img src="design/images/DMaterie.jpg" width="120" height="120"></th>
    <th width="314" >
      <p align="justify">{L_off_dark_matter_desc}</p>
      <div>
        <div class="fl"><img src="design/images/dm_klein_1.jpg"></div>
        <div align="left" id="off_dark_matter_hint">{L_off_dark_matter_hint}</div>
      </div>
      <A HREF="dark_matter.php" id="off_get_dark_matter">{L_sys_dark_matter_get}</A>
    </th>
  </tr>

  <tr>
    <td width="535" colspan="2" class="c">{L_tech[600]}</td>
  </tr>

  <!-- BEGIN officer -->
    <tr>
      <th width=120>
        {officer.NAME}<br>
        <img src="{dpath}gebaeude/{officer.ID}.jpg" align="top" width="120" height="120" /><br>
        {L_sys_level} {officer.LEVEL}/{officer.LEVEL_MAX}<br>
        <!-- IF officer.CAN_BUY == 1 -->
          <a href="officer.php?mode=2&offi={officer.ID}"><span class="positive">{L_off_hire} {DM_COST} {L_sys_dark_matter_sh}</span>
        <!-- ELSE -->
          <span class="negative">{L_sys_maximum_level}</span>
        <!-- ENDIF -->
      </th>

      <th align=left>
        {officer.DESCRIPTION}<br><br>
        <span class="positive">{officer.BONUS} {officer.EFFECT}</span>
      </th>
    </tr>
  <!-- END officer -->
</table>
