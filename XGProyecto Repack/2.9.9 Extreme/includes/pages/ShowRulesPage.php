<?php
#*******************************************************************************
#** Nome                   : Rules Page
#** Autor                    : nkrsystem
#** Descri��o            : Pagina de regras.                            
#** Vers�o                  : 1 
#******************************************************************************** ?
if(!defined('INSIDE')){ die(header("location:../../"));}
 
display(parsetemplate(gettemplate('rules'), $parse));
?> 