<?php
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003-2006 by Antonello Onida (fantacalcio@sassarionline.net)
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
##################################################################################
require_once("./controlla_pass.php");
include("./header.php");

if ($_SESSION['valido'] == "SI" AND $stato_mercato != "I") {

require ("./menu.php");

$file = file($percorso_cartella_dati."/utenti_".$_SESSION['torneo'].".php");
$linee = count($file);
$num_giocatori = 0;
	for($num1 = 1; $num1 < $linee; $num1++){
		if(!"") $num_giocatori++;
	}

	for($num1 = 1 ; $num1 < $num_giocatori; $num1++) {
	@list($outente, $opass, $opermessi, $oemail, $ourl, $osquadra, $otorneo, $oserie, $ocitta, $ocrediti, $ovariazioni, $ocambi, $oreg) = explode("<del>", $file[$num1]);
	$ssquadra[$outente] = $osquadra;
	}

echo "<table summary='Registro mercato' width='100%' align='center' class='border' cellpadding='10' bgcolor='$sfondo_tab'>
<caption>Registro Mercato</caption>
<tr><td valign ='top' align='left'>";

$messaggi = @file($percorso_cartella_dati."/registro_mercato_".$_SESSION['torneo']."_".$_SESSION['serie'].".txt");
$num_messaggi = count($messaggi);
$num_iniziale = 0;
#rsort ($messaggi);
		
	for ($num1 = $num_iniziale ; $num1 < $num_messaggi ; $num1++) {
	$messaggio = explode("#@?",$messaggi[$num1]);
	$nome = stripslashes($messaggio[0]);
	$data = stripslashes($messaggio[1]);
	$testo_messaggio = stripslashes($messaggio[2]);
	$soprannome = $ssquadra[$nome];

		if (substr("$messaggi[$num1]",0,13) == "Radio mercato" and $stato_mercato != "I") $messmerc .= "$nome<br/>";

	} # fine for $num1

echo "$messmerc";

echo "</td></tr></table>";

} # fine if ($_SESSION['valido'] == "SI")

include("./footer.php");
?>
