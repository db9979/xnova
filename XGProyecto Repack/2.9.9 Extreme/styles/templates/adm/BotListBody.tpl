<script>document.body.style.overflow = "auto";</script> 
<body>
<table width="400">
    <tr>
    	<td class="c" colspan="8">Lista de Bots [<a href="?deleteall=yes" onClick="return confirm('Vas a borrar todos los bots. Estas seguro?');">{er_dlte_all}</a>][<a href="BotListPage.php?page=deletenew_bot" onClick="return confirm('Solo borre este archivo si est� lento el servidor, presenta errores, o el archivo pesa demaciado. Desea borrarlo de todas formas?');">Borrar bot_new</a>]</td>
    </tr>
    <tr>
    	<td class="c" colspan="8">[<a href="BotListPage.php?page=new_bot">Crear un Bot</a>]</td>
    </tr>
    <tr>
        <td class="c" width="25">Id</td>
        <td class="c" width="170">Jugador</td>
        <td class="c" width="170">�ltima Actividad</td>
        <td class="c" width="230">Tiempo de Actualizaci�n</td>
        <td class="c" width="230">�ltimo Planeta</td>
        <td class="c" width="170">Tipo</td>
        <td class="c" width="95">{button_delete}</td>
        <td class="c" width="95">Info</td>
    </tr>
    <tr>{bots_list}</tr>
</table>
</body>