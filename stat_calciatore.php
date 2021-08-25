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
require_once "./controlla_pass.php";
require_once "./header.php";

if ( $_SESSION[ 'valido' ] == "SI" ) {
    require_once "./menu.php";
} else {
    echo "<div class='contenuto'>
    <div id='articoli'>
    <div id='sinistra'>
    <div class='articoli_s'>";
}

if ( $stato_mercato == "I" or $stato_mercato == "B" or $stato_mercato == "R" ) {
    echo "<h3>FASE INIZIALE: statistiche non disponibili!</h3>";
}

$partite_giocate = 0;
$somma_voti_tot = 0;
$somma_voti_giornale = 0;

for ( $num1 = 1; $num1 < 40; $num1++ ) {
    if ( strlen( $num1 ) == 1 )
        $num1 = "0" . $num1;

    if ( $voti = @file( "$percorso_cartella_voti/voti$num1.txt" ) ) {
        $num_voti = count( $voti );
        for ( $num2 = 0; $num2 < $num_voti; $num2++ ) {
            $dati_voto = explode( $separatore_campi_file_voti, $voti[ $num2 ] );
            $num_calciatore_voto = $dati_voto[ ( $num_colonna_numcalciatore_file_voti - 1 ) ];
            $num_calciatore_voto = trim( $num_calciatore_voto );

            if ( $num_calciatore == $num_calciatore_voto ) {
                $voto_tot = $dati_voto[ ( $num_colonna_vototot_file_voti - 1 ) ];
                $voto_tot = trim( $voto_tot );
                $voto_tot = str_replace( ",", ".", $voto_tot );
                $voto_giornale = $dati_voto[ ( $num_colonna_votogiornale_file_voti - 1 ) ];
                $voto_giornale = trim( $voto_giornale );
                $voto_giornale = str_replace( ",", ".", $voto_giornale );
                if ( $voto_tot != 0 or $voto_giornale != 0 ) {
                    $partite_giocate++;
                    $somma_voti_tot = $somma_voti_tot + $voto_tot;
                    $somma_voti_giornale = $somma_voti_giornale + $voto_giornale;
                } # fine if ($voto_tot != 0 or $voto_giornale != 0)

                if ( $statistiche == "SI" and $stato_mercato != "I" ) {
                    $stat_codice = $dati_voto[ ( $ncs_codice - 1 ) ];
                    $stat_giornata = $dati_voto[ ( $ncs_giornata - 1 ) ];
                    $stat_nome = $dati_voto[ ( $ncs_nome - 1 ) ];
                    $stat_nome = preg_replace( "/\"/", "", $stat_nome );
                    $stat_squadra = $dati_voto[ ( $ncs_squadra - 1 ) ];
                    $stat_squadra = preg_replace( "/\"/", "", $stat_squadra );
                    $stat_attivo = $dati_voto[ ( $ncs_attivo - 1 ) ];
                    $stat_ruolo = $dati_voto[ ( $ncs_ruolo - 1 ) ];
                    $stat_presenza = $dati_voto[ ( $ncs_presenza - 1 ) ];
                    $totpresenze = ( $totpresenze ?? 0 ) + $stat_presenza;
                    $stat_votofc = $dati_voto[ ( $ncs_votofc - 1 ) ];
                    $totvotfc = ( $totvotfc ?? 0 ) + $stat_votofc;
                    $stat_mininf25 = $dati_voto[ ( $ncs_mininf25 - 1 ) ];
                    $totmininf25 = ( $totmininf25 ?? 0 ) + $stat_mininf25;
                    $stat_minsup25 = $dati_voto[ ( $ncs_minsup25 - 1 ) ];
                    $totminsup25 = ( $totminsup25 ?? 0 ) + $stat_minsup25;
                    $stat_voto = $dati_voto[ ( $ncs_voto - 1 ) ];
                    $totvot = ( $totvot ?? 0 ) + $stat_voto;
                    $stat_golsegnati = $dati_voto[ ( $ncs_golsegnati - 1 ) ];
                    $totgol = ( $totgol ?? 0 ) + $stat_golsegnati;
                    $stat_golsubiti = $dati_voto[ ( $ncs_golsubiti - 1 ) ];
                    $totgolsub = ( $totgolsub ?? 0 ) + $stat_golsubiti;
                    $stat_golvittoria = $dati_voto[ ( $ncs_golvittoria - 1 ) ];
                    $totgolvit = ( $totgolvit ?? 0 ) + $stat_golvittoria;
                    $stat_golpareggio = $dati_voto[ ( $ncs_golpareggio - 1 ) ];
                    $totgolpar = ( $totgolpar ?? 0 ) + $stat_golpareggio;
                    $stat_assist = $dati_voto[ ( $ncs_assist - 1 ) ];
                    $totass = ( $totass ?? 0 ) + $stat_assist;
                    $stat_ammonizione = $dati_voto[ ( $ncs_ammonizione - 1 ) ];
                    $totamm = ( $totamm ?? 0 ) + $stat_ammonizione;
                    $stat_espulsione = $dati_voto[ ( $ncs_espulsione - 1 ) ];
                    $totesp = ( $totesp ?? 0 ) + $stat_espulsione;
                    $stat_rigoretirato = $dati_voto[ ( $ncs_rigoretirato - 1 ) ];
                    $totrigt = ( $totrigt ?? 0 ) + $stat_rigoretirato;
                    $stat_rigoresubito = $dati_voto[ ( $ncs_rigoresubito - 1 ) ];
                    $totrigs = ( $totrigs ?? 0 ) + $stat_rigoresubito;
                    $stat_rigoreparato = $dati_voto[ ( $ncs_rigoreparato - 1 ) ];
                    $totrigp = ( $totrigp ?? 0 ) + $stat_rigoreparato;
                    $stat_rigoresbagliato = $dati_voto[ ( $ncs_rigoresbagliato - 1 ) ];
                    $totrigsb = ( $totrigsb ?? 0 ) + $stat_rigoresbagliato;
                    $stat_autogol = $dati_voto[ ( $ncs_autogol - 1 ) ];
                    $totaut = ( $totaut ?? 0 ) + $stat_autogol;
                    $stat_subentrato = $dati_voto[ ( $ncs_entrato - 1 ) ];
                    $stat_titolare = $dati_voto[ ( $ncs_titolare - 1 ) ];
                    $tottit = ( $tottit ?? 0 ) + $stat_titolare;
                    $stat_valore = $dati_voto[ ( $ncs_valore - 1 ) ];
                }

                break;
            } # fine if ($num_calciatore == $num_calciatore_voto)
            $ultima_giornata = $num1;
        } # fine if ($voti = @file("$percorso_cartella_voti/voti$num1.txt"))
    } # fine for $num2
} # fine for $num1

if ( $partite_giocate != 0 ) {
    $media_giornale = round( ( $somma_voti_giornale / $partite_giocate ), 2 );
    $media_punti = round( ( $somma_voti_tot / $partite_giocate ), 2 );
} # fine if ($partite_giocate != 0)
else {
    $media_giornale = 0;
    $media_punti = 0;
} # fine else if ($partite_giocate != 0)

if ( isset( $ultima_giornata ) && $ultima_giornata != "" ) {
    $calciatori = file( "$prima_parte_pos_file_voti$ultima_giornata.txt" );
} else {
    $calciatori = file( "$percorso_cartella_dati/calciatori.txt" );
}

$num_calciatori = count( $calciatori );
for ( $num1 = 0; $num1 < $num_calciatori; $num1++ ) {
    $dati_calciatore = explode( $separatore_campi_file_calciatori, $calciatori[ $num1 ] );
    $numero = $dati_calciatore[ ( $num_colonna_numcalciatore_file_calciatori - 1 ) ];
    $numero = trim( $numero );
    if ( $num_calciatore == $numero ) {
        $nome = stripslashes( $dati_calciatore[ ( $num_colonna_nome_file_calciatori - 1 ) ] );
        $nome = trim( $nome );
        $nome = preg_replace( "/\"/", "", $nome );
        if ( $num_colonna_squadra_file_calciatori != 0 ) {
            $xsquadra = $dati_calciatore[ ( $num_colonna_squadra_file_calciatori - 1 ) ];
            $xsquadra = trim( $xsquadra );
            $xsquadra = preg_replace( "/\"/", "", $xsquadra );
        } # fine if ($num_colonna_squadra_file_calciatori != 0)
        $s_ruolo = $dati_calciatore[ ( $num_colonna_ruolo_file_calciatori - 1 ) ];
        $s_ruolo = trim( $s_ruolo );
        $ruolo = $s_ruolo;
        if ( $considera_fantasisti_come != "P" and $considera_fantasisti_come != "D" and $considera_fantasisti_come != "C" and $considera_fantasisti_come != "A" )
            $considera_fantasisti_come = "F";
        if ( $s_ruolo == $simbolo_fantasista_file_calciatori )
            $ruolo = $considera_fantasisti_come;
        if ( $s_ruolo == $simbolo_portiere_file_calciatori )
            $ruolo = "P";
        if ( $s_ruolo == $simbolo_difensore_file_calciatori )
            $ruolo = "D";
        if ( $s_ruolo == $simbolo_centrocampista_file_calciatori )
            $ruolo = "C";
        if ( $s_ruolo == $simbolo_attaccante_file_calciatori )
            $ruolo = "A";
        break;
    } # fine if ($num_calciatore == $numero)
} # fine for $num1

$tabstat = "<table summary='statistiche' width='90%' border='0' class='border' cellspacing='2' cellpadding='2' align='center' bgcolor='$sfondo_tab1'>
<tr><td class='testa'>Num.</td>
<td class='testa'>Nome</td>
<td class='testa'>Ruolo</td>";
if ( $xsquadra )
    $tabstat .= "<td class='testa'>Squadra</td>";
$tabstat .= "<td class='testa'>Partite giocate</td>
<td class='testa'>Media voti giornale</td>
<td class='testa'>Media punti</td></tr>
<tr bgcolor='$sfondo_tab'><td align='center'>$num_calciatore</td>
<td>$nome</td>
<td align='center'>$ruolo</td>";
if ( $xsquadra )
    $tabstat .= "<td align='center'><a href='tab_squadre.php?vedi_squadra=$xsquadra&amp;escludi_controllo=" . ( $escludi_controllo ?? '' ) . "' class='user'>$xsquadra</a></td>";
$tabstat .= "<td align='center'>$partite_giocate</td>
<td align='center'>$media_giornale</td>
<td align='center'>$media_punti</td>
</tr></table>";

if ( $statistiche == "SI" and $stato_mercato != "I" ) {
    if ( isset( $stat_attivo ) && $stat_attivo == 0 ) {
        $mess = "<b><font color='red'>Non disponibile</font></b>";
    } else {
        $mess = "In attivit&agrave;";
    }

    if ( isset( $stat_ruolo ) && $stat_ruolo == 0 )
        $st_ruolo = "Portiere";
    if ( isset( $stat_ruolo ) && $stat_ruolo == 1 )
        $st_ruolo = "Difensore";
    if ( isset( $stat_ruolo ) && $stat_ruolo == 2 )
        $st_ruolo = "Centrocampista";
    if ( isset( $stat_ruolo ) && $stat_ruolo == 3 )
        $st_ruolo = "Attaccante";
    # if ($stat_ruolo == 3) $st_ruolo = "Fantasista";

    $tabstat1 = "<center><h4>Statistiche complete</h4></center>
	<table summary='statistiche' width='80%' border='0' cellspacing='0' cellpadding='15' align='center'><tr><td width='35%' align='center'>";
    $tabstat2 = "</td></tr></table>";

    $tabstat3 = "<table summary='statistiche' width='100%' class='border' border='0' cellspacing='1' cellpadding='1' align='center'>
	<tr bgcolor='$colore_riga_alt'><td>Codice</td><td align='center'>$numero</td></tr>
	<tr><td>Giornata</td><td align='center'>" . ( $stat_giornata ?? '' ) . "</td></tr>
	<tr bgcolor='$colore_riga_alt'><td>Nome</td><td align='center'><b>$nome</b></td></tr>
	<tr><td>Squadra</td><td align='center'><a href='tab_squadre.php?vedi_squadra=" . ( $stat_squadra ?? '' ) . "&amp;escludi_controllo=" . ( $escludi_controllo ?? '' ) . "' class='user'><b>" . ( $stat_squadra ?? '' ) . "</b></a></td></tr>
	<tr bgcolor='$colore_riga_alt'><td>Status</td><td align='center'>$mess</td></tr>
	<tr><td>Ruolo</td><td align='center'>$ruolo</td></tr>
	<tr bgcolor='$colore_riga_alt'><td>Valore</td><td align='center'>" . ( $stat_valore ?? '' ) . "</td></tr>";

    if ( $foto_calciatori == "SI" ) {
        if ( @is_file( "$foto_path$num_calciatore.png" ) )
            $tabstat3 .= "<tr bgcolor='$sfondo_tab'><td colspan='2' align='center'><br/><p><img src='$foto_path$num_calciatore.png' alt='$num_calciatore' class='shadow' /></p></td></tr>"; elseif ( @is_file( "$foto_path$num_calciatore.jpg" ) )
            $tabstat3 .= "<tr bgcolor='$sfondo_tab'><td colspan='2' align='center'><br/><p><img src='$foto_path$num_calciatore.jpg' alt='$num_calciatore' class='shadow' /></p></td></tr>";
        elseif ( @is_file( "$foto_path$num_calciatore.gif" ) )
            $tabstat3 .= "<tr bgcolor='$sfondo_tab'><td colspan='2' align='center'><br/><p><img src='$foto_path$num_calciatore.gif' alt='$num_calciatore' class='shadow' /></p></td></tr>";
        else $tabstat3 .= "<tr bgcolor='white'><td colspan='2' align='center'><br/><p><img src='immagini/nofoto.jpg' alt'Nessuna foto' class='shadow' /></p></td></tr>";
    }

    $tabstat3 .= "</table></td>";

    $tabstat4 = "<td width='65%'><table summary='statistiche' width='100%' class='border' border='0' cellspacing='1' cellpadding='0' align='center'>
	<tr><td class='testa' width='50%'>Valori</td><td class='testa' width='25%'>Ultima giornata</td><td class='testa' width='25%'>Dati storici</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Presenza</td><td align='center'>" . ( $stat_presenza ?? '' ) . "</td><td align='center'>" . ( $totpresenze ?? '' ) . "</td></tr>
	<tr><td>Voto FC</td><td align='center'>" . ( $stat_votofc ?? '' ) . "</td><td align='center'>" . ( $totvotfc ?? '' ) . "</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Voto Gazzetta</td><td align='center'>" . ( $stat_voto ?? '' ) . "</td><td align='center'>" . ( $totvot ?? '' ) . "</td></tr>
	<tr><td>Gol segnati</td><td align='center'>" . ( $stat_golsegnati ?? '' ) . "</td><td align='center'>" . ( $totgol ?? '' ) . "</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Gol subiti</td><td align='center'>" . ( $stat_golsubiti ?? '' ) . "</td><td align='center'>" . ( $totgolsub ?? '' ) . "</td></tr>
	<tr><td>Gol vittoria</td><td align='center'>" . ( $stat_golvittoria ?? '' ) . "</td><td align='center'>" . ( $totgolvit ?? '' ) . "</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Gol pareggio</td><td align='center'>" . ( $stat_golpareggio ?? '' ) . "</td><td align='center'>" . ( $totgolpar ?? '' ) . "</td></tr>
	<tr><td>Assist</td><td align='center'>" . ( $stat_assist ?? '' ) . "</td><td align='center'>" . ( $totass ?? '' ) . "</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Ammonizione</td><td align='center'>" . ( $stat_ammonizione ?? '' ) . "</td><td align='center'>" . ( $totamm ?? '' ) . "</td></tr>
	<tr><td>Espulsione</td><td align='center'>" . ( $stat_espulsione ?? '' ) . "</td><td align='center'>" . ( $totesp ?? '' ) . "</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Rigore tirato</td><td align='center'>" . ( $stat_rigoretirato ?? '' ) . "</td><td align='center'>" . ( $totrigt ?? '' ) . "</td></tr>
	<tr><td>Rigore subito</td><td align='center'>" . ( $stat_rigoresubito ?? '' ) . "</td><td align='center'>" . ( $totrigs ?? '' ) . "</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Rigore parato</td><td align='center'>" . ( $stat_rigoreparato ?? '' ) . "</td><td align='center'>" . ( $totrigp ?? '' ) . "</td></tr>
	<tr><td>Rigore sbagliato</td><td align='center'>" . ( $stat_rigoresbagliato ?? '' ) . "</td><td align='center'>" . ( $totrigsb ?? '' ) . "</td></tr>
	<tr bgcolor='$sfondo_tab'><td>Autogol</td><td align='center'>" . ( $stat_autogol ?? '' ) . "</td><td align='center'>" . ( $totaut ?? '' ) . "</td></tr></table>";

    tabella_squadre();
    echo "<table summary='statistiche' width='100%' cellpadding='10' align='center'>
	<caption>Riepilogo Statistiche</caption>
	<tr><td align='center' bgcolor='#FFFFFF'>$tabstat1 $tabstat3 $tabstat4 $tabstat2</td></tr>
	<tr><td align='center' bgcolor='#FFFFFF'>$tabstat
	<br /><br /><b>PROSSIMA PARTITA DEL $xsquadra</b><br /><br />
	<object id='probabili_formazioni' width='620' height='250' data='http://www.gazzetta.it/ssi/swf/campetto_oriz.swf' type='application/x-shockwave-flash'>
        <param name='quality' value='high'/>
        <param name='wmode' value='transparent'/>
        <param name='allowScriptAccess' value='always'/>
        <param name='flashvars' value='xmlPath=http://www.gazzetta.it/ssi/2011/boxes/calcio/squadre/" . strtolower( $xsquadra ) . "/formazione/formazione.xml'/>
        <param name='movie' value='http://www.gazzetta.it/ssi/swf/campetto_oriz.swf'/>
        </object> 
	</td></tr></table>";
} # fine if ($statistiche == "SI")
else {
    echo "Statistiche non attivate!";
}

if ( $_SESSION[ 'valido' ] != "SI" ) {
    echo "</div>
	</div>
	<div id='destra'>";
    require_once "./menu_i.php";
    echo "</div>";
}

require_once "./footer.php";
