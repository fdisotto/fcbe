<?PHP

require_once("./controlla_pass.php");
include("./header.php");
require("./menu.php");
echo"<center><H3>Risultati di calcio da tutto il mondo</h3>in tempo reale<br/><br/>
<br/>Seleziona il servizio a cui sei interessato:<br/>
<a href='http://www.goalslive.com/co_branded/ituser.asp?css=1035&amp;ttl=$sito' target='iframe'>RISULTATI IN DIRETTA</a> 
&nbsp; &nbsp; &nbsp; &nbsp;<a href='http://www.goalslive.com/co_branded/it_stat_matches.asp?css=1035&amp;ttl=$sito' target='iframe'>STATISTICHE</a> 
<br/><br/>
<iframe name='iframe' align='center' style='width: 700px; height: 900px' src='http://www.goalslive.com/co_branded/ituser.asp?css=1035&amp;ttl=SassariOnLine.net' marginwidth='0' marginheight='0' hspace='0' vspace='0' frameborder='0'>
Il tuo browser non supporta i Frame in linea non puoi vedere questa pagina.
</iframe>
</center>";

include("./footer.php");
?>
