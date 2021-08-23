<?php
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003-2009 by Antonello Onida
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
require_once DATI_DIR . "/dati_gen.php";
require_once INC_DIR . "/funzioni.php";

if ( trim( $messaggi[ 5 ] ) != "" )
    echo "<div class='slogan'>" . html_entity_decode( $messaggi[ 5 ] ) . "</div>"; elseif ( $mostra_calendario == "SI" ) {
    echo " <div class='slogan'><center>";
    crea_calendario();
    echo "</center></div>";
}

echo "<div id='menu_d'>";

if ( $iscrizione_online == "SI" )
    echo "<a href='./iscrizione.php'>Iscrizione on-line</a>";
if ( $usa_cms == "SI" )
    link_pagine_box();
#echo "<a href='./regolamento.php'>Regolamento</a>";
if ( is_file( DATI_DIR . "/tornei.php" ) )
    echo "<a href='./vedi_tornei.php'>Tornei in corso</a>";
if ( $usa_cms == "SI" )
    link_categorie();

echo "<div id='loginbox'><p align='center'><b><u>Accesso procedura</u></b></p>";

if ( @$_GET[ "fallito" ] == 1 )
    echo "<br/><div class='evidenziato'>> Pseudonimo o password errati o mancanti!</div>"; elseif ( @$_GET[ "fallito" ] == 2 )
    echo "<br/><div class='evidenziato'>> Password amministratore errata.<br/>E' stata inviata una mail di notifica.</div>";
elseif ( @$_GET[ "fallito" ] == 3 )
    echo "<br><div class=\"evidenziato\">> Scegli il torneo dal men&ugrave; a tendina</div>";
elseif ( @$_GET[ "nofile" ] )
    echo "<br/><div class='evidenziato'>> File utenti non trovato!</div>";
elseif ( @$_GET[ "logout" ] == 1 )
    echo "<br/><div class='evidenziato'>> Disconnesso!</div>";
elseif ( @$_GET[ "logout" ] == 2 )
    echo "<br/><div class='evidenziato'>> Accesso riservato!</div>";
elseif ( @$_GET[ "logout" ] == 3 )
    echo "<br/><div class='evidenziato'>> Rieseguire accesso!</div>";
elseif ( @$_GET[ "nuovo" ] )
    echo "<br/><div class='evidenziato'>> Connesso!</div>";
elseif ( @$_GET[ "iscritto" ] )
    echo "<br/><div class='evidenziato'>> Utente iscritto! Email inviata!</div>";
elseif ( @$_GET[ "attesa" ] )
    echo "<br/><div class='evidenziato'>> Utente in attesa di autorizzazione!</div>";

if ( isset( $_SESSION[ "valido" ] ) and $_SESSION[ 'valido' ] == "SI" ) {
    echo "<br/>Ciao: <b>" . $_SESSION[ 'utente' ] . "</b><br/>";
    require_once INC_DIR . "/online.php";
} else {
    $tornei = @file( DATI_DIR . "/tornei.php" ) ?: [];
    $num_tornei = 0;
    $conta_tornei = count( $tornei );
    if ( $attiva_multi == "SI" and $conta_tornei > 2 ) {
        $vedi_tornei_attivi = "<select name='l_torneo'>";
        $vedi_tornei_attivi .= "<option value=''>Scegli il tuo torneo</option>";
        #$tornei = @file(DATI_DIR . "/tornei.php");
        #$num_tornei = 0;
        #$conta_tornei = count($tornei);
        for ( $num1 = 0; $num1 < $conta_tornei; $num1++ ) {
            $num_tornei++;
        }

        for ( $num1 = 1; $num1 < $num_tornei; $num1++ ) {
            @list( $otid, $otdenom ) = explode( ",", trim( $tornei[ $num1 ] ) );
            $vedi_tornei_attivi .= "<option value='$otid'>$otdenom</option>";
        } # fine for $num1

        $vedi_tornei_attivi .= "</select>";
    } else $vedi_tornei_attivi = "<input type='hidden' name='l_torneo' value='1' />";

    echo "<br/><form method='post' action='./login.php'>
	username: <input type='text' name='l_utente' class='text' /><br/>
	password:   <input type='password' name='l_pass' class='text' /><br/>
	$vedi_tornei_attivi<br>
	Ricordami <input type=\"checkbox\" name=\"l_ricordami\" value=\"SI\">	<br/><br/>
	
	<input type='image' name='login' value='Login' src='immagini/entra.gif'>
	</form>";
    echo "<br/><div class='articolo_d'><a href='./recuperopass.php'>recupera password</a></div>";
    #echo "<br/><div class='articolo_d'><a href='./recuperopass.php'>recupera password</a></div>";

} # fine ----------<input name='login' class='button' value='Login' type='submit' />
echo "</div>";
unset ( $vedi_tornei_attivi, $tornei );
?>

</div>

<?php
if ( $usa_cms == "SI" and $vedi_notizie == "2" )
    echo "<div class='articolo_d'>" . ultime_notizie( '' ) . "</div>";

if ( $mostra_voti_in_login == "SI" ) {
    $mostra_voti_vedi = "<div class='articolo_d'><center><form method='post' name='vedi_voti' action='voti.php'>
	<input type = 'hidden' name = 'escludi_controllo' value = 'SI' />
	<input type='submit' name='guarda_voti' value='Voti della giornata' /> n. \r\n
	<select name='giornata' onChange='submit()'>";

    for ( $num1 = 1; $num1 < 40; $num1++ ) {
        if ( strlen( $num1 ) == 1 )
            $num1 = "0" . $num1;

        $percorso = "$prima_parte_pos_file_voti$num1$seconda_parte_pos_file_voti";
        if ( is_file( "$percorso" ) ) {
            $mostra_voti_vedi .= "<option value='$num1' selected>$num1</option>";
        } # fine if
        else break;
    } # fine for $num1
    $mostra_voti_vedi .= "</select><br/><br/>
	<input type='radio' name='ruolo_guarda' value='tutti' checked /> Tutti |
	<input type='radio' name='ruolo_guarda' value='P' /> P |
	<input type='radio' name='ruolo_guarda' value='D' /> D |
	<input type='radio' name='ruolo_guarda' value='C' /> C |";

    if ( $considera_fantasisti_come == "F" )
        $mostra_voti_vedi .= "<input type='radio' name='ruolo_guarda' value='F' /> F |";
    $mostra_voti_vedi .= "<input type='radio' name='ruolo_guarda' value='A' /> A
	</form></center></div>";
    echo $mostra_voti_vedi;
} # fine if

if ( $mostra_giornate_in_login == "SI" ) {
    $vedi_tornei_attivi = "<select name='itorneo'>";
    $tornei = @file( DATI_DIR . "/tornei.php" );
    $num_tornei = 0;
    for ( $num1 = 0; $num1 < count( $tornei ); $num1++ ) {
        $num_tornei++;
    }

    for ( $num1 = 1; $num1 < $num_tornei; $num1++ ) {
        @list( $tid, $tdenom, $tpart, $tserie ) = explode( ",", trim( $tornei[ $num1 ] ) );
        $tdenom = preg_replace( "/\"/", "", $tdenom );

        if ( isset( $torneo_completo ) && $torneo_completo != "SI" )
            $vedi_tornei_attivi .= "<option value='$tid'>$tdenom</option>";
    } # fine for $num1

    $vedi_tornei_attivi .= "</select>";

    $giormerc = "<form method='post' action='guarda_giornata.php'>
	<input type='hidden' name='escludi_controllo' value='SI' />
	<input type='submit' name='guarda_giornata' value='Vedi' /> giornata n. <select name='giornata' onChange='submit()'>";

    for ( $num1 = 1; $num1 < 40; $num1++ ) {
        if ( strlen( $num1 ) == 1 )
            $num1 = "0" . $num1;
        $controlla_giornata = "giornata$num1";
        if ( @is_file( DATI_DIR . "/$controlla_giornata" ) )
            $giormerc .= "<option value='$num1' selected>$num1</option>"; else break;
    } # fine for $num1

    $giormerc .= "</select><br/>" . $vedi_tornei_attivi . "</form><br/>";
    if ( $num1 > 1 )
        echo "<div class='articolo_d'>
	<div>" . $giormerc . "</div>
	<div>" . $mostra_voti_vedi . "</div>
	</div>";
}

if ( $attiva_rss == "SI" ) {
    echo "<div class='articolo_d'><center><b><u>News Calcio</u></b></center><br/>\n";

    require_once INC_DIR . "/rss_fetch.php";
    $html = "- <a href='#{link}' target='_blank'>#{title}</a><br />\n";
    #$html .= "      #{description}<br /><font size='-1'>#{pubDate}</font><br />\n";
    $rss = new rss_parser( $url_rss, 10, $html, 1 );
    echo "</div>\n";
}
?>
</div>
