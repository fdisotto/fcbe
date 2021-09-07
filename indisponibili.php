<?PHP

require_once("./controlla_pass.php");
include("./header.php");
require("./menu.php");
echo"<center><H3>Indisponibili</h3>della Serie A TIM<br/><br/>
<br/>Seleziona il servizio a cui sei interessato:<br/>
<a href='http://www.fantacalcio.kataweb.it/stat/index.php?page=indisponibili' target='iframe'>La Repubblica</a> 
&nbsp; &nbsp; &nbsp; &nbsp;<a href='http://www.fantagazzetta.com/indisponibili_serie_a.asp' target='iframe'>Fantagazzetta</a> 
<br/><br/>
<iframe name='iframe' align='center' style='width: 700px; height: 900px' src='http://www.fantacalcio.kataweb.it/stat/index.php?page=indisponibili' marginwidth='0' marginheight='0' hspace='0' vspace='0' frameborder='0'>
Il tuo browser non supporta i Frame in linea non puoi vedere questa pagina.
</iframe>
</center>";

include("./footer.php");
?>
