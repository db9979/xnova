<h2>{L_msg_page_header}</h2>
<table width="519">
  <tr class="c_c">
    <th>{L_msg_head_type}</th>
    <th>{L_msg_head_count}</th>
    <th>{L_msg_head_total}</th>
    <th><img src="design/images/r1.png"></th>
  </tr>

  <!-- BEGIN message_class -->
    <tr class="{message_class.STYLE} c_c">
      <td><a href="messages.php?mode=show&message_class={message_class.ID}"><span class="{message_class.STYLE}">{message_class.TEXT}</span></a></td>
      <td><!-- IF message_class.ID != -1 --><span class="{message_class.STYLE}">{message_class.UNREAD}</span><!-- ELSE --><a href="messages.php?mode=write"><span class="{message_class.STYLE}">{L_msg_compose}</span></a><!-- ENDIF --></td>
      <td><span class="{message_class.STYLE}">{message_class.TOTAL}</span></td>
      <td><!-- IF message_class.ID != -1 --><a href="messages.php?mode=delete&message_class={message_class.ID}&message_range=class&return=1" title="{L_msg_del_class}"><span class="{message_class.STYLE}"><img src="design/images/r1.png"></span></a><!-- ELSE -->&nbsp;<!-- ENDIF --></td>
    </tr>
  <!-- END message_class -->
</table>

<!-- INCLUDE page_hint.tpl -->
