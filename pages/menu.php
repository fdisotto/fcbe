<?php
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003-2010 by Antonello Onida
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
#	ver 1.10
##################################################################################

###############################
#
# Menu
#
###############################
if ( $menu_lato == "SI" and isset( $_SESSION[ 'permessi' ] ) && $_SESSION[ 'permessi' ] <= 4 and $_SESSION[ 'valido' ] == "SI" ) {
    $chiusura_giornata = (int)@file( DATI_DIR . "/chiusura_giornata.txt" );
    $file = file( DATI_DIR . "/utenti_" . $_SESSION[ 'torneo' ] . ".php" );
    $linee = count( $file );

    for ( $num1 = 1; $num1 < 40; $num1++ ) {
        if ( strlen( $num1 ) == 1 )
            $num1 = "0" . $num1;
        if ( @is_file( DATI_DIR . "/giornata" . $num1 . "_" . $_SESSION[ 'torneo' ] . "_" . $_SESSION[ 'serie' ] ) )
            $ultgio = $num1; else break;
    } # fine for $num1

    echo "<div class='menu_s'>
	<table width='100%' style='padding: 2px; border: 1px solid $sfondo_tab3; background-color: $sfondo_tab;' summary='menu'>
	<caption>GESTIONE</caption><tr><td align='left'>" . $acapo;

    echo "<a href='./mercato.php'>Mercato</a>$acapo";

    if ( $chiusura_giornata != 1 ) {
        echo "<a href='./squadra.php' >Gestione squadra</a>$acapo";
        if ( $mercato_libero == "SI" and $stato_mercato == "A" )
            echo "<a href='./cambi.php' >Cambi</a>$acapo";
        if ( $mercato_libero == "SI" and $stato_mercato == "A" and $trasferiti_ok == "SI" )
            echo "<a href='./cambi_tra.php' >Cambia Trasferiti</a>$acapo";
    } elseif ( $chiusura_giornata == 1 )
        echo "<a href='./squadra1.php' >Formazioni attuali</a>$acapo";

    echo "<a href='./a_modUtente.php' >Modifica profilo</a>$acapo";
    if ( $consenti_logo == "SI" ) {
        echo "<a href='./logo_upload.php' >Carica il tuo logo</a>$acapo";
    }
    echo "<a href='./messaggi.php' >Messaggi</a>$acapo";
    ?>
    <?php
    if ( $chiusura_giornata == 1 )
        echo "<a href='./registro_mercato.php' >Registro mercato</a>" . $acapo;

    for ( $num1 = 1; $num1 < 40; $num1++ ) {
        if ( isset( $campionato[ "1-$num1" ] ) && $campionato[ "1-$num1" ] == "S" ) {
            echo "<a href='./calendario.php' >Calendario partite</a>" . $acapo;
            break;
        }
    } # fine for $num1

    # if ($mercato_libero == "NO" AND $stato_mercato != "I" AND $ultgio != 0) {
    if ( $mercato_libero == "NO" or $ottipo_calcolo == "S" ) {
        if ( $stato_mercato != "I" )
            echo "<a href='./classifica.php' >Classifica</a>" . $acapo;
    }

    if ( $mercato_libero == "SI" and $stato_mercato != "I" and ( isset( $ultgio ) && $ultgio != 0 ) ) {
        echo "<a href='./guarda_giornate.php' >Vedi tutti i voti</a>" . $acapo;
    }

    ######

    if ( $num_calciatori_scambiabili > 0 and $stato_mercato != "I" and $mercato_libero == "NO" ) {
        $scambi_proposti = @file( DATI_DIR . "/scambi_" . $_SESSION[ 'torneo' ] . "_" . $_SESSION[ 'serie' ] . ".txt" );
        $num_scambi_proposti = count( $scambi_proposti );
        for ( $num1 = 0; $num1 < $num_scambi_proposti; $num1++ ) {
            $dati_scambio = explode( ",", $scambi_proposti[ $num1 ] );
            if ( $_SESSION[ 'utente' ] == $dati_scambio[ 4 ] ) {
                $tempo_off = $dati_scambio[ 7 ];
                $tempo_off = togli_acapo( $tempo_off );
                $anno_off = substr( $tempo_off, 0, 4 );
                $mese_off = substr( $tempo_off, 4, 2 );
                $giorno_off = substr( $tempo_off, 6, 2 );
                $ora_off = substr( $tempo_off, 8, 2 );
                $minuto_off = substr( $tempo_off, 10, 2 );
                $adesso = mktime( date( "H" ), date( "i" ), 0, date( "m" ), date( "d" ), date( "Y" ) );
                $sec_restanti = mktime( $ora_off, $minuto_off, 0, $mese_off, $giorno_off, $anno_off ) - $adesso;
                if ( $sec_restanti > 0 )
                    $richiesto = "SI";
            } # fine if ($_SESSION == $dati_scambio[4])
        } # fine for $num1

        if ( $richiesto == "SI" )
            echo "<a href='./scambi_proposti.php'><font class='evidenziato'><b>Scambio calciatori</b></font></a>" . $acapo; else echo "<a href='./scambi_proposti.php' >Scambio calciatori</a>$acapo";
    } # fine if ($num_calciatori_scambiabili > 0)

    if ( $stato_mercato != "I" and $stato_mercato != "B" and $mercato_libero == "NO" )
        echo "<a href='./mercato.php?vedi_operazioni=SI' >Situazione lega</a>$acapo";

    echo "<a href='./logout.php'>Disconnetti</a><br/>$acapo";

    if ( $_SESSION[ 'permessi' ] == 4 ) {
        echo "<br/><center><b>PRESIDENZA DI LEGA</b></center><br/>$acapo
		<a href='./a_sito.php'>Gestione news</a>$acapo
		<a href='./a_nlUtente.php'>Messaggio verso utenti</a>$acapo
		<a href='./a_invia_voti.php'>Invia formazioni</a>$acapo		<a href='./a_invia_risultati.php'>Invia risultati</a>$acapo
		<a href='./a_aggUtente.php'>Aggiungi utente</a>$acapo
		<a href='./a_modUtente.php'>Modifica utente</a>$acapo
		<a href='./a_appUtente.php'>Approva utente</a>$acapo
		<a href='./a_eliUtente.php'>Cancella utente</a>$acapo
		<a href='./a_crea_sondaggio.php'>Sondaggi e votazioni</a>
		<a href='./squadra1.php'>Situazione squadre</a>$acapo";
    } # fine if($_SESSION['permessi'] == 4)
    elseif ( $_SESSION[ 'permessi' ] == 3 ) {
        echo "<br/><center><b>SEGRETERIA DI LEGA</b></center><br/>$acapo
		<a href='./a_nlUtente.php' >Messaggio verso utenti</a>$acapo
		<a href='./a_invia_voti.php'>Invia formazioni</a>$acapo		<a href='./a_invia_risultati.php'>Invia risultati</a>$acapo
		<a href='./a_appUtente.php' >Approva utente</a>$acapo
		<a href='./a_crea_sondaggio.php'>Sondaggi e votazioni</a>$acapo
		<a href='./a_sito.php' >Gestione news</a>$acapo";
    } # fine if($_SESSION['permessi'] == 3)
    elseif ( $_SESSION[ 'permessi' ] == 2 ) {
        echo "<br/><center><b>REDAZIONE</b></center><br/>$acapo
		<a href='./a_sito.php' >Gestione news</a>$acapo";
    } # fine if($_SESSION['permessi'] == 2)
    if ( $stato_mercato != "I" and $stato_mercato != "B" and $chiusura_giornata == 1 ) {
        echo "<center><br/><form method='post' action='./squadra.php'><b>Visualizza squadra</b><br/>$acapo
		<select name='nome_squadra' onchange='submit()'>$acapo
		<option value='tutti'> di tutti</option>$acapo";

        for ( $num1 = 1; $num1 <= $linee; $num1++ ) {
            @list( $outente, $opass, $opermessi, $oemail, $ourl, $osquadra, $otorneo, $oserie, $ocitt�, $ocrediti, $ovariazioni, $ocambi, $oreg ) = explode( "<del>", $file[ $num1 ] );
            if ( $_SESSION[ 'torneo' ] == $otorneo and $_SESSION[ 'serie' ] == $oserie ) {
                if ( ! $osquadra )
                    $osquadra = "di $outente";
                echo "<option value='$outente'>" . htmlentities( $osquadra, ENT_QUOTES ) . "</option>$acapo";
            }
        } # fine for $num1

        echo "</select>$acapo<input type='submit' name='guarda_squadra' value='Vedi' /></form></center>$acapo";
    }

    if ( $mostra_giornate_in_mercato == "SI" and $stato_mercato != "I" and isset( $ultgio ) && $ultgio != 0 ) {
        $giormerc = "<center><br/><form method='post' action='guarda_giornata.php'>
		<input type='submit' name='guarda_giornata' value='Vedi' /> giornata n. <select name='giornata' onchange='submit()'>$acapo";

        for ( $num1 = "01"; $num1 < 50; $num1++ ) {
            if ( strlen( $num1 ) == 1 )
                $num1 = "0" . $num1;
            $controlla_giornata = "giornata$num1";
            if ( @is_file( DATI_DIR . "/giornata" . $num1 . "_" . $_SESSION[ 'torneo' ] . "_" . $_SESSION[ 'serie' ] ) )
                $giormerc .= "<option value='$num1' selected='selected'>$num1</option>$acapo"; else break;
        } # fine for $num1
        $giormerc .= "</select></form></center>$acapo";
    }

    echo $giormerc ?? '';
    echo "</td></tr></table><br/><br/>$acapo";

    ###################################
    # STATISTICHE

    echo "<table width='100%' style='padding:2px; border: 1px solid $sfondo_tab3; background-color: $sfondo_tab;' summary='statistiche'>$acapo
	<caption>STATISTICHE</caption><tr><td align='center'>$acapo
	<form method='post' action='./tab_calciatori.php'>$acapo
	<b>Visualizza </b><br/><select name='ruolo_guarda' onchange='submit()'>$acapo
	<option value='tutti'> tutti i calciatori</option>$acapo
	<option value='P'> i portieri</option>$acapo
	<option value='D'> i difensori</option>$acapo
	<option value='C'> i centrocampisti</option>$acapo";

    if ( $considera_fantasisti_come == "F" )
        echo "<option value='F'> i fantasisti</option>$acapo";

    echo "<option value='A'> gli attaccanti</option></select> <input type='submit' name='tab_calciatori' value='Vedi' /></form>$acapo";

    if ( $stato_mercato != "I" && ( isset( $ultgio ) && $ultgio >= 1 ) ) {
        echo "<hr /><form method='post' action='voti.php'>$acapo
		<input type='submit' name='guarda_voti' value='Voti della giornata' /> n. <select name='giornata' onchange='submit()'>$acapo";

        for ( $num1 = 1; $num1 < 40; $num1++ ) {
            if ( strlen( $num1 ) == 1 )
                $num1 = "0" . $num1;

            $percorso = "$percorso_cartella_voti/voti$num1$seconda_parte_pos_file_voti";

            if ( is_file( "$percorso" ) ) {
                echo "<option value='$num1' selected='selected'>$num1</option>$acapo";
            } # fine if
            else break;
        } # fine for $num1
        echo "</select><br/>$acapo
		<input type='radio' name='ruolo_guarda' value='tutti' checked='checked' /> Tutti$acapo
		<input type='radio' name='ruolo_guarda' value='P' /> P |$acapo
		<input type='radio' name='ruolo_guarda' value='D' /> D |$acapo
		<input type='radio' name='ruolo_guarda' value='C' /> C |$acapo";
        if ( $considera_fantasisti_come == "F" )
            echo "<input type='radio' name='ruolo_guarda' value='F' /> F |$acapo";
        echo "<input type='radio' name='ruolo_guarda' value='A' /> A$acapo
		</form>$acapo";

        if ( $statistiche == "SI" ) {
            if ( $ultgio > 2 )
                echo "<hr /><form method='post' action='suggteam.php'>$acapo
			<input type='hidden' name='dif' value='3' />$acapo
			<input type='hidden' name='cen' value='4' />$acapo
			<input type='hidden' name='att' value='3' />$acapo
			<input type='submit' name='vai' value='TOP 11' />$acapo
			</form>$acapo";

            echo "<hr /><form method='post' action='./formateam.php'>$acapo
			<input type='submit' name='vai' value='Stato squadra' /></form>$acapo";

            // Kalskotos
            // aggiunta codice statistiche per ruolo
            echo "<hr /><form method='post' action='stateam1.php'>$acapo
			<input type='radio' name='o_ruolo' value='P' checked='checked' /> P |$acapo
			<input type='radio' name='o_ruolo' value='D' /> D |$acapo
			<input type='radio' name='o_ruolo' value='C' /> C |$acapo
			<input type='radio' name='o_ruolo' value='A' /> A <br/>$acapo
			<input type='submit' name='guarda_ruolo' value='Statistiche per ruolo' /></form>$acapo";
            // fine modifica

            echo "<hr /><form method='post' action='stateam.php'>$acapo
			<b>Visualizza statistiche</b><br/>$acapo
			<select name='o_team' onchange='submit()'> $acapo";

            $team = @file( DATI_DIR . "/squadre.txt" );
            $numteam = count( $team );

            for ( $num1 = 0; $num1 < $numteam; $num1++ ) {
                echo "<option value='" . trim( $team[ $num1 ] ) . "'>" . ucfirst( strtolower( trim( $team[ $num1 ] ) ) ) . "</option>";
            } # fine for $num1

            echo "</select><input type='submit' name='guarda_squadra' value='Vedi' /></form>";
        } # fine if ($statistiche="SI")
    } #fine if ($stato_mercato != "I" AND $ultgio >= 1)

    echo "</td></tr></table><br/><br/>";

    ########################################
    # CALENDARIO A

    if ( ! empty( trim( $messaggi[ 9 ] ) ) ) {
        echo "<table width='100%' style='padding:2px; border: 1px solid $sfondo_tab3; background-color: $sfondo_tab;' summary='calendario'>
	<caption>CALENDARIO</caption><tr><td align='left'>";
        echo "<div id='testo' style='display:'; class='slogan';>" . html_entity_decode( $messaggi[ 9 ] );
        echo "</td></tr></table><br/><br/>";
    }
    ###################################
    # SONDAGGI

    if ( @is_file( DATI_DIR . "/sondaggio.php" ) ) {
        require_once DATI_DIR . "/sondaggio.php";
        echo "<table width='100%' style='padding:2px; border: 1px solid $sfondo_tab3; background-color: $sfondo_tab;' summary='sondaggi'>
		<caption>SONDAGGI</caption><tr><td>";

        if ( $voti_consentiti == 0 ) {
            echo "<b>Sondaggio ";
            $o = "o";
        } # fine if ($voti_consentiti == 0)
        else {
            echo "<br/><b>Votazione ";
            $o = "a";
        } # fine else if ($voti_consentiti == 0)

        if ( $voto_palese == "SI" )
            echo "palese</b><br/>"; else echo "anonim$o</b><br/>";

        if ( $voti_consentiti > 1 )
            echo "<center>$voti_consentiti voti consentiti</center><br/>";

        echo "<b><font color='red'>   $domanda</font></b>
		<form method='post' action='./vota_sondaggio.php'>";
        $num_opzioni = count( $opzioni );
        for ( $num1 = 0; $num1 < $num_opzioni; $num1++ ) {
            $opzione = $num1 + 1;
            echo "   <input type='radio' name='voto' value='$opzione' /> " . $opzioni[ $num1 ] . "<br/>";
        } # fine for $num1
        echo "   <input type='submit' name='vota' value='vota' />
		</form><br/>
		<a href='./vota_sondaggio.php'>Risultati sondaggio</a>";
        echo "</td></tr></table><br/><br/>";
    } # fine if (@is_file(DATI_DIR . "/sondaggio.php"))

    ###################################
    # LINK UTILI
    #
    echo "<table width='100%' style='padding:2px; border: 1px solid $sfondo_tab3; background-color: $sfondo_tab;' summary='links'>
	<caption>LINK UTILI</caption><tr><td align='left'>
	<a href='televideo.php' >Televideo</a>
	<a href='temporeale.php' >Risultati temporeale</a>
	<a href='probform.php'>Probabili formazioni</a>
	<a href='indisponibili.php'>Indisponibili</a>
	</td></tr></table><br/>";

    if ( $attiva_sponsors == "SI" )
        echo "
	<br/><table width='100%' style='padding:2px; border: 1px solid $sfondo_tab3; background-color: $sfondo_tab;' summary='sponsor'>
	<caption>SPONSORS</caption><tr><td align='center'>
	<br/>
	<script type='text/javascript'>
	

	</script>
	<br/><br/>
	</td></tr></table>";
    echo "</div></td><td valign='top' width='80%' align='center'>";
} # fine if ($menu_lato == "SI" AND $_SESSION['permessi'] == 0) {

elseif ( $menu_lato == "NO" and $_SESSION[ 'permessi' ] == 0 ) {
    ###################################
    # MENU TOP

    echo "<center><form method='post' action='voti.php'>
	<input type='submit' name='guarda_voti' value='Guarda i voti della giornata' /> n� <select name='giornata' onchange='submit()'>";

    for ( $num1 = "01"; $num1 < 50; $num1++ ) {
        if ( strlen( $num1 ) == 1 )
            $num1 = "0" . $num1;

        $percorso = "$percorso_cartella_voti/voti$num1$seconda_parte_pos_file_voti";

        if ( is_file( "$percorso" ) ) {
            echo "<option value='$num1'>$num1</option>";
        } # fine if
        else break;
    } # fine for $num1
    echo "</select>

	<input type='radio' name='ruolo_guarda' value='tutti' checked='checked'> Tutti |
	<input type='radio' name='ruolo_guarda' value='P'> P |
	<input type='radio' name='ruolo_guarda' value='D'> D |
	<input type='radio' name='ruolo_guarda' value='C'> C |";
    if ( $considera_fantasisti_come == "F" )
        echo "<input type='radio' name='ruolo_guarda' value='F'> F |";
    echo "<input type='radio' name='ruolo_guarda' value='A'> A
	</form>";

    echo "</center>
	<table align='center' bgcolor='$sfondo_tab'><tr>
	<td><form method='post' action='tab_calciatori.php'>
	<input type='submit' name='tab_calciatori' value='Guarda tutti'>
	<select name='ruolo_guarda' onchange='submit()'>
	<option value='tutti'>i calciatori</option>
	<option value='P'>i portieri</option>
	<option value='D'>i difensori</option>
	<option value='C'>i centrocampisti</option>";
    if ( $considera_fantasisti_come == "F" )
        echo "<option value='F'>i fantasisti</option>";
    echo "<option value='A'>gli attaccanti</option>
	</select></form></td>

	<td><form method='post' action='squadra.php'>
	<input type='submit' name='guarda_squadra' value='Guarda la squadra'>
	<select name='nome_squadra' onchange='submit()'>
	<option value='tutti'> di tutti</option>";

    for ( $num1 = 1; $num1 <= $linee; $num1++ ) {
        @list( $outente, $opass, $opermessi, $oemail, $ourl, $osquadra, $otorneo, $oserie, $ocitt�, $ocrediti, $ovariazioni, $ocambi, $oreg ) = explode( "<del>", $file[ $num1 ] );
        if ( ! $osquadra )
            $osquadra = "di $outente";
    } # fine for $num1

    echo "</select></form></td></tr><tr>
	<td align='center' colspan='2'>
	<table align='center' width='100%' bgcolor='$sfondo_tab'><tr>";

    if ( $mostra_giornate_in_mercato == "SI" ) {
        echo "<td align='center'><form method='post' action='guarda_giornata.php'>
		<input type='submit' name='guarda_giornata' value='Guarda la giornata'>
		n. <select name='giornata' onchange='submit()'>";
        for ( $num1 = "01"; $num1 < 50; $num1++ ) {
            if ( strlen( $num1 ) == 1 )
                $num1 = "0" . $num1;
            $giornata = "giornata$num1";
            if ( @is_file( DATI_DIR . "/$giornata" ) ) {
                echo "<option value='giornata$num1'>$num1</option>";
            } # fine if (is_dir($giornata))
            else break;
        } # fine for $num1
        echo "</select></form></td>";
    } # fine if ($mostra_giornate_in_mercato == "SI")

    if ( $num_calciatori_scambiabili > 0 ) {
        $scambi_proposti = @file( DATI_DIR . "/scambi.txt" );
        $num_scambi_proposti = count( $scambi_proposti );
        for ( $num1 = 0; $num1 < $num_scambi_proposti; $num1++ ) {
            $dati_scambio = explode( ",", $scambi_proposti[ $num1 ] );
            if ( $_SESSION[ 'utente' ] == $dati_scambio[ 4 ] ) {
                $tempo_off = $dati_scambio[ 7 ];
                $tempo_off = togli_acapo( $tempo_off );
                $anno_off = substr( $tempo_off, 0, 4 );
                $mese_off = substr( $tempo_off, 4, 2 );
                $giorno_off = substr( $tempo_off, 6, 2 );
                $ora_off = substr( $tempo_off, 8, 2 );
                $minuto_off = substr( $tempo_off, 10, 2 );
                $adesso = mktime( date( "H" ), date( "i" ), 0, date( "m" ), date( "d" ), date( "Y" ) );
                $sec_restanti = mktime( $ora_off, $minuto_off, 0, $mese_off, $giorno_off, $anno_off ) - $adesso;
                if ( $sec_restanti > 0 )
                    $richiesto = "SI";
            } # fine if ($_SESSION == $dati_scambio[4])
        } # fine for $num1

        echo "<td align='center'><form method='post' action='scambi_proposti.php'>";

        if ( $richiesto == "SI" )
            echo "<br/><font color='red' class='evidenziato'><b>>> </b></font>";
        echo "<input type='submit' name='guarda_scambi' value='Proposte di scambio'>";
        if ( $richiesto == "SI" )
            echo "<font color='red' class='evidenziato'><b> <<</b></font>";

        echo "</form></td>";
    } # fine if ($num_calciatori_scambiabili > 0)

    echo "<td align='center'><form method='post' action='messaggi.php'>
	<input type='submit' name='guarda_messaggi' value='Messaggi'>
	</form></td>

	<td align='center'><form method='post' action='cambi.php'>
	<input type='submit' name='guarda_messaggi' value='Cambi'>
	</form></td></tr></table></td></tr></table>";
} # fine else if ($menu_lato == "NO" AND $_SESSION['permessi'] == 0) {

else $menu = "Menu non disponibile";
#
# FINE MENU OPZIONI
######################################

?>
