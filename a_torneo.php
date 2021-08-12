<?php
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003-2015 by Antonello Onida
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

if ( $_SESSION[ 'valido' ] == "SI" and $_SESSION[ 'permessi' ] == 5 ) {
require_once "./a_menu.php";

if ( isset( $inserimento ) && $inserimento != "scrivi" && isset( $azione ) && $azione == "cancella" ) {
    $id = $_POST[ "itorneo" ];
    $itdenom = $_POST[ "itdenom" ];
    echo "
		<table width='100%' style='padding: 15px; background-color:$sfondo_tab'>
		<caption>Cancellazione torneo</caption>
		<tr><td align='center'>
		<br /><br />
		<b>Utilizzare la funzione di cancellazione solo alla fine del campionato e verificare che nel file tornei.php non ci siano righe vuote presenti!</b><br /><br />
		Sei sicuro di voler cancellare il torneo <b><u>$itdenom</u></b> (ID: $id)?<br /><br />
		<br /><br />
		<form method='post' action='a_torneo.php'>
		<input type='hidden' name='iitorneo' value='$id' />
		<input type='hidden' name='azione' value='cancella' />
		<input type='hidden' name='inserimento' value='scrivi' />
		<input type='submit' value='Cancella' /></form></td></tr></table>";
    echo "</div>";
    include( "./footer.php" );
    exit;
}

if ( isset( $inserimento ) && $inserimento == "scrivi" ) {
    if ( $azione == "nuovo" ) {
        $stringa = $N_otid . "," . $N_otdenom . "," . $N_otpart . ",0," . $N_otmercato_libero . "," . $N_ottipo_calcolo . "," . $N_otgiornate_totali . "," . $N_otritardo_torneo . "," . $N_otcrediti_iniziali . "," . $N_otnumcalciatori . "," . $N_otcomposizione_squadra . "," . $N_otquotacassa . ",0,0,0," . $N_otstato . "," . $N_otmodificatore_difesa . "," . $N_otschemi . "," . $N_otmax_in_panchina . "," . $N_otpanchina_fissa . "," . $N_otmax_entrate_dalla_panchina . "," . $N_otsostituisci_per_ruolo . "," . $N_otsostituisci_per_schema . "," . $N_otsostituisci_fantasisti_come_centrocampisti . "," . $N_otnumero_cambi_max . "," . $N_otrip_cambi_numero . "," . $N_otrip_cambi_giornate . "," . $N_otrip_cambi_durata . "," . $N_otaspetta_giorni . "," . $N_otaspetta_ore . "," . $N_otaspetta_minuti . "," . $N_otnum_calciatori_scambiabili . "," . $N_otscambio_con_soldi . "," . $N_otvendi_costo . "," . $N_otpercentuale_vendita . "," . $N_otsoglia_voti_primo_gol . "," . $N_otincremento_voti_gol_successivi . "," . $N_otvoti_bonus_in_casa . "," . $N_otpunti_partita_vinta . "," . $N_otpunti_partita_pareggiata . "," . $N_otpunti_partita_persa . "," . $N_otdifferenza_punti_a_parita_gol . "," . $N_otdifferenza_punti_zero_a_zero . "," . $N_otmin_num_titolari_in_formazione . "," . $N_otpunti_pareggio . "," . $N_otpunti_posizione[ 1 ] . "," . $N_otpunti_posizione[ 2 ] . "," . $N_otpunti_posizione[ 3 ] . "," . $N_otpunti_posizione[ 4 ] . "," . $N_otpunti_posizione[ 5 ] . "," . $N_otpunti_posizione[ 6 ] . "," . $N_otpunti_posizione[ 7 ] . "," . $N_otpunti_posizione[ 8 ] . "," . $N_otreset_scadenza . "," . "\n";
        $fp = fopen( $percorso_cartella_dati . "/tornei.php", "a+" );
        flock( $fp, LOCK_SH );
        fwrite( $fp, $stringa );
        flock( $fp, LOCK_UN );
        fclose( $fp );
        echo "<h1>Torneo creato</h1><br />
			$N_otid - $N_otdenom<br />
			<form method='post' action='a_torneo.php'>
			<input type='hidden' name='itorneo' value='$id' />
			<input type='submit' value='Ritorna' /></form>";
        exit;
    } elseif ( $azione == "modifica" ) {
        $stringa = $N_otid . "," . $N_otdenom . "," . $N_otpart . ",0," . $N_otmercato_libero . "," . $N_ottipo_calcolo . "," . $N_otgiornate_totali . "," . $N_otritardo_torneo . "," . $N_otcrediti_iniziali . "," . $N_otnumcalciatori . "," . $N_otcomposizione_squadra . "," . $N_otquotacassa . ",0,0,0," . $N_otstato . "," . $N_otmodificatore_difesa . "," . $N_otschemi . "," . $N_otmax_in_panchina . "," . $N_otpanchina_fissa . "," . $N_otmax_entrate_dalla_panchina . "," . $N_otsostituisci_per_ruolo . "," . $N_otsostituisci_per_schema . "," . $N_otsostituisci_fantasisti_come_centrocampisti . "," . $N_otnumero_cambi_max . "," . $N_otrip_cambi_numero . "," . $N_otrip_cambi_giornate . "," . $N_otrip_cambi_durata . "," . $N_otaspetta_giorni . "," . $N_otaspetta_ore . "," . $N_otaspetta_minuti . "," . $N_otnum_calciatori_scambiabili . "," . $N_otscambio_con_soldi . "," . $N_otvendi_costo . "," . $N_otpercentuale_vendita . "," . $N_otsoglia_voti_primo_gol . "," . $N_otincremento_voti_gol_successivi . "," . $N_otvoti_bonus_in_casa . "," . $N_otpunti_partita_vinta . "," . $N_otpunti_partita_pareggiata . "," . $N_otpunti_partita_persa . "," . $N_otdifferenza_punti_a_parita_gol . "," . $N_otdifferenza_punti_zero_a_zero . "," . $N_otmin_num_titolari_in_formazione . "," . $N_otpunti_pareggio . "," . $N_otpunti_pos . "," . $N_otreset_scadenza . "," . "\n";

        $id = $_POST[ "N_otid" ];
        $tornei = @file( $percorso_cartella_dati . "/tornei.php" );
        $num_tornei = 0;
        for ( $num0 = 0; $num0 < count( $tornei ); $num0++ ) {
            $num_tornei++;
        }

        for ( $num1 = 1; $num1 < $num_tornei; $num1++ ) {
            @list( $otid, $otdenom, $otpart, $otserie, $otmercato_libero, $ottipo_calcolo, $otgiornate_totali, $otritardo_torneo, $otcrediti_iniziali, $otnumcalciatori, $otcomposizione_squadra, $tquotacassa, $temp2, $temp3, $temp4, $otstato, $otmodificatore_difesa, $otschemi, $otmax_in_panchina, $otpanchina_fissa, $otmax_entrate_dalla_panchina, $otsostituisci_per_ruolo, $otsostituisci_per_schema, $otsostituisci_fantasisti_come_centrocampisti, $otnumero_cambi_max, $otrip_cambi_numero, $otrip_cambi_giornate, $otrip_cambi_durata, $otaspetta_giorni, $otaspetta_ore, $otaspetta_minuti, $otnum_calciatori_scambiabili, $otscambio_con_soldi, $otvendi_costo, $otpercentuale_vendita, $otsoglia_voti_primo_gol, $otincremento_voti_gol_successivi, $otvoti_bonus_in_casa, $otpunti_partita_vinta, $otpunti_partita_pareggiata, $otpunti_partita_persa, $otdifferenza_punti_a_parita_gol, $otdifferenza_punti_zero_a_zero, $otmin_num_titolari_in_formazione, $otpunti_pareggio, $otpunti_pos, $otreset_scadenza ) = explode( ",", $tornei[ $num1 ] );
            if ( $id == $otid )
                $tornei[ $num1 ] = $stringa;
        } # fine for $num1

        $fo = fopen( $percorso_cartella_dati . "/tornei.php", 'wb+' );
        flock( $fo, LOCK_EX );
        foreach ( $tornei as $N_tornei ) {
            fwrite( $fo, $N_tornei ) or die( "Non riesco a scrivere sul file!" );
        }
        flock( $fo, LOCK_UN );
        fclose( $fo );
        echo "<h1>Torneo modificato</h1><br />
			$N_otid - $N_otdenom<br />
			<form method='post' action='a_torneo.php'>
			<input type='hidden' name='itorneo' value='$id' />
			<input type='submit' value='Ritorna' /></form>";
        exit;
    } elseif ( $azione == "cancella" ) {
        $id = $_POST[ "iitorneo" ];
        $fp = @file( $percorso_cartella_dati . "/tornei.php" );
        $nt = 0;

        foreach ( $fp as $tornei ) {
            $at = explode( ",", trim( $tornei ) );
            if ( $id == $at[ 0 ] ) {
                echo " trovato ";
                echo $at[ 0 ] . " - " . $at[ 1 ] . " - " . $at[ 2 ] . " - " . $at[ 3 ] . " - " . $at[ 4 ] . " - " . $at[ 5 ] . " - " . $at[ 6 ] . "<br />";
                unset( $fp[ $nt ] );
                break;
            }
            $nt++;
        }

        #unset($fp[$id]);
        $fp = implode( "", $fp );
        $fo = fopen( $percorso_cartella_dati . "/tornei.php", 'wb+' );
        flock( $fo, LOCK_EX );
        fwrite( $fo, $fp );
        flock( $fo, LOCK_UN );
        fclose( $fo );
        echo "<h1>Torneo cancellato</h1><br />
			<form method='post' action='a_torneo.php'>
			<input type='submit' value='Ritorna' /></form>";
        exit;
    } else {
        echo "location: ./a_torneo.php?messgestutente=78";
        header( "location: ./a_torneo.php?messgestutente=78" );
        exit;
    }
} #fine if ($inserimento == "scrivi") {

else {
if ( ! isset( $itorneo ) ) {
    if ( ! @is_file( $percorso_cartella_dati . "/tornei.php" ) ) {
        $ini_file = "<?php die('ACCESSO VIETATO');?>" . "\n";
        $fp = fopen( $percorso_cartella_dati . "/tornei.php", "wb+" ) or die ( "errore fileopen" );
        flock( $fp, LOCK_EX ) or die ( "errore filelocl ex" );
        fwrite( $fp, $ini_file ) or die ( "errore fwrite" );
        flock( $fp, LOCK_UN ) or die ( "errore filelocl un" );
        fclose( $fp ) or die ( "errore fileclose" );
        if ( @chmod( $percorso_cartella_dati . "/tornei.php", 0664 ) )
            echo "CHMOD 664 impostato!<br />";
        unset ( $ini_file, $fp );
    }
    $dati_tornei = @file( $percorso_cartella_dati . "/tornei.php" );
    $dati_tornei = @array_slice( $dati_tornei, 1 );
    $conta_tornei = count( $dati_tornei );
    $a_tornei = array();
    $mostra_tornei = "<table width='100%' cellpadding='0' bgcolor='$sfondo_tab'>
			<caption>Gestione Tornei</caption>
			<tr><th scope='col'>ID</th>
			<th scope='col'>Denominazione</th>
			<th scope='col'>Parametri</th>
			<th scope='col'>Gestione</th>
			<th scope='col'>Elimina</th>
			</tr>";

    $elenco_id_tornei = array();
    # arrializzo e creo elenco tornei
    foreach ( $dati_tornei as $tornei ) {
        $at = explode( ",", trim( $tornei ) );
        $a_tornei[ trim( $at[ 0 ] ) ][] = trim( $at[ 1 ] );
        $a_tornei[ trim( $at[ 0 ] ) ][] = trim( $at[ 2 ] );
        $a_tornei[ trim( $at[ 0 ] ) ][] = trim( $at[ 4 ] );
        $a_tornei[ trim( $at[ 0 ] ) ][] = trim( $at[ 5 ] );
        $a_tornei[ trim( $at[ 0 ] ) ][] = trim( $at[ 6 ] );
        $elenco_id_tornei[] = $at[ 0 ];
        $mostra_tornei .= "<tr bgcolor='$sfondo_tab1'>
				<td align='center'>" . trim( $at[ 0 ] ) . "</td>
				<td align='left'>" . trim( $at[ 1 ] ) . "
				</td>
				<td align='center'>
				<form method='post' action='a_torneo.php'>
				<input type='hidden' name='itorneo' value='" . trim( $at[ 0 ] ) . "' />
				<input type='hidden' name='azione' value='vedi' />
				<input type='hidden' name='inserimento' value='NO' />
				<input type='image' src='./immagini/parametri.gif' name='submit' alt='Parametri' />
				</form>
				</td>
				<td align='center'>
				<form method='post' action='a_gestione_tornei.php'>
				<input type='hidden' name='itorneo' value='" . trim( $at[ 0 ] ) . "' />
				<input type='image' src='./immagini/gestione.gif' name='submit' alt='Gestione' />
				</form>
				</td>
				<td align='center'>
				<form method='post' action='a_torneo.php'>
				<input type='hidden' name='itorneo' value='" . trim( $at[ 0 ] ) . "' />
				<input type='hidden' name='itdenom' value='" . trim( $at[ 1 ] ) . "' />
				<input type='hidden' name='inserimento' value='NO' />
				<input type='hidden' name='azione' value='cancella' />
				<input type='image' src='./immagini/elimina.gif' name='submit' alt='Elimina' />
				</form>
				</td></tr>";
    }
    for ( $nnid = 1; $nnid < 100; $nnid++ ) {
        if ( ! in_array( $nnid, $elenco_id_tornei ) ) {
            $nt = $nnid;
            break;
        }
    }
    $mostra_tornei .= "	<tr><td colspan='5'>Crea un nuovo campionato (ID: $nt)
			<form method='post' action='a_torneo.php'>
			<input type='hidden' name='azione' value='nuovo' />
			<input type='hidden' name='itorneo' value='$nt' />
			<input type='hidden' name='inserimento' value='NO' />
			<input type='submit' value='Nuovo torneo' />
			</form></td></tr></table><br />";
    unset ( $at, $tornei );
    echo $mostra_tornei;

    if ( isset( $messgestutente ) ) {
        require_once( "./inc/avvisi.php" );
        echo "<br /><font class='evidenziato'>&nbsp;$avviso[$messgestutente]&nbsp;</font>";
    } # fine if ($messgestutente)
} else {
if ( $azione == "nuovo" ) {
    if ( $attiva_multi != "SI" )
        echo "<div align='center' class='evidenziato'><h2>ATTENZIONE</h2> multigestione non attivata, proseguite a vostro rischio e pericolo!!!</div><br /><br />";
    echo "<div align='center'>La procedura di configurazione del torneo si svolge in due fasi: questa e' la prima dove sono definite le caratteristiche generali del torneo. Occorrer&agrave; entrare in modifica per aggiungere le opzioni relarive alla modalit&agrave; di torneo scelta.</div><br /><br />";
    $otid = $itorneo;
} else {
    $tornei = @file( $percorso_cartella_dati . "/tornei.php" );
    list( $otid, $otdenom, $otpart, $otserie, $otmercato_libero, $ottipo_calcolo, $otgiornate_totali, $otritardo_torneo, $otcrediti_iniziali, $otnumcalciatori, $otcomposizione_squadra, $otquotacassa, $temp2, $temp3, $temp4, $otstato, $otmodificatore_difesa, $otschemi, $otmax_in_panchina, $otpanchina_fissa, $otmax_entrate_dalla_panchina, $otsostituisci_per_ruolo, $otsostituisci_per_schema, $otsostituisci_fantasisti_come_centrocampisti, $otnumero_cambi_max, $otrip_cambi_numero, $otrip_cambi_giornate, $otrip_cambi_durata, $otaspetta_giorni, $otaspetta_ore, $otaspetta_minuti, $otnum_calciatori_scambiabili, $otscambio_con_soldi, $otvendi_costo, $otpercentuale_vendita, $otsoglia_voti_primo_gol, $otincremento_voti_gol_successivi, $otvoti_bonus_in_casa, $otpunti_partita_vinta, $otpunti_partita_pareggiata, $otpunti_partita_persa, $otdifferenza_punti_a_parita_gol, $otdifferenza_punti_zero_a_zero, $otmin_num_titolari_in_formazione, $otpunti_pareggio, $otpunti_pos, $otreset_scadenza ) = explode( ",", $tornei[ $itorneo ] );
}
echo "<form name='torneo' method='post' action='a_torneo.php'>";
if ( $azione == "nuovo" )
    echo "<input type='hidden' name='azione' value='nuovo' />"; else echo "<input type='hidden' name='azione' value='modifica' />";
?>
<table width='100%' border='1' cellpadding='10' bgcolor='<?php echo $sfondo_tab; ?>'>
    <caption>Gestione Tornei</caption>
    <tr>
        <td>ID torneo</td>
        <td align="center"><input type="hidden" name="N_otid"
                value="<?php echo $otid ?>"/><?php echo "$otid"; ?></td>
        <td align="left">Progressivo ad uso interno non modificabile</td>
    </tr>
    <tr>
        <td>Denominazione</td>
        <td align="center"><input type="text" name="N_otdenom" value="<?php echo isset( $otdenom ) ? $otdenom : '' ?>" size="50"
                maxlength="50"/></td>
        <td align="left">Il nome del torneo</td>
    </tr>
    <tr>
        <td>Stato torneo</td>
        <td align="center">
            <select name="N_otstato">
                <option value="I" <?php if ( isset( $otstato ) && $otstato == "I" )
                    echo "selected"; ?> > Fase Iniziale
                </option>
                <option value="B" <?php if ( isset( $otstato ) && $otstato == "B" )
                    echo "selected"; ?> > Buste chiuse
                </option>
                <option value="R" <?php if ( isset( $otstato ) && $otstato == "R" )
                    echo "selected"; ?> > Mercato riparazione
                </option>
                <option value="A" <?php if ( isset( $otstato ) && $otstato == "A" )
                    echo "selected"; ?> > Mercato aperto
                </option>
                <option value="P" <?php if ( isset( $otstato ) && $otstato == "P" )
                    echo "selected"; ?> > Asta perenne
                </option>
                <option value="S" <?php if ( isset( $otstato ) && $otstato == "S" )
                    echo "selected"; ?> > Mercato sospeso
                </option>
                <option value="C" <?php if ( isset( $otstato ) && $otstato == "C" )
                    echo "selected"; ?> > Mercato chiuso
                </option>
                <option value="Z" <?php if ( isset( $otstato ) && $otstato == "Z" )
                    echo "selected"; ?> > Torneo non attivo
                </option>
            </select></td>
        <td align="left">Lo stato del mercato può essere:<br/>
            - "I" iniziale (fase di calcio mercato prima dell'inizio del campionato)<br/>
            - "A" aperto (consentite tutte le operazioni di mercato)<br/>
            - "P" asta perenne (consentite tutte le operazioni di mercato)<br/>
            - "S" sospeso (consentiti solo rilanci e vendita immediata di calciatori)<br/>
            - "C" chiuso (nessuna operazione di mercato consentita)<br/>
            - "R" riparazione (fase post-asta in cui si rettificano e completano le squadre - <b>solo
                $mercato_libero = "NO"</b>). <br/>
            - "B" buste chiuse (permette di fare offerte nascoste - <b>solo $mercato_libero = "NO"</b>).
        </td>
    </tr>
    <tr>
        <td>Partecipanti</td>
        <td align="center"><input type="text" name="N_otpart" value="<?php echo $otpart ?? '' ?>" size="4"
                maxlength="4"/></td>
        <td align="left">Totale dei partecipanti al torneo. 0 = infiniti.</td>
    </tr>
    <tr>
        <td>N&deg; serie</td>
        <td align="center">
            <select name="N_otserie">
                <option value="0" <?php if ( isset( $otserie ) && $otserie == 0 )
                    echo "selected"; ?> > 1 serie o girone
                </option>
                <option value="1" <?php if ( isset( $otserie ) && $otserie == 1 )
                    echo "selected"; ?> > 2 serie o gironi
                </option>
                <option value="2" <?php if ( isset( $otserie ) && $otserie == 2 )
                    echo "selected"; ?> > 3 serie o gironi
                </option>
                <option value="3" <?php if ( isset( $otserie ) && $otserie == 3 )
                    echo "selected"; ?> > 4 serie o gironi
                </option>
                <option value="4" <?php if ( isset( $otserie ) && $otserie == 4 )
                    echo "selected"; ?> > 5 serie o gironi
                </option>
            </select></td>
        <td align="left">Solo 1: da sviluppare.</td>
    </tr>
    <tr>
        <td>Tipo campionato</td>
        <td align="center">
            <select name="N_otmercato_libero">
                <option value="SI" <?php if ( isset( $otmercato_libero ) && $otmercato_libero == "SI" )
                    echo "selected"; ?> > Mercato libero
                </option>
                <option value="NO" <?php if ( isset( $otmercato_libero ) && $otmercato_libero == "NO" )
                    echo "selected"; ?> > Asta iniziale
                </option>
            </select></td>
        <td align="left">Modalit&agrave; di gioco che determina il comportamento della procedura.</td>
    </tr>
    <tr>
        <td>Tipo calcolo</td>
        <td align="center">
            <select name="N_ottipo_calcolo">
                <option value="V" <?php if ( isset( $ottipo_calcolo ) && $ottipo_calcolo == "V" )
                    echo "selected"; ?> > Somma di voti
                </option>
                <option value="P" <?php if ( isset( $ottipo_calcolo ) && $ottipo_calcolo == "P" )
                    echo "selected"; ?> > Somma dei punti
                </option>
                <option value="S" <?php if ( isset( $ottipo_calcolo ) && $ottipo_calcolo == "S" )
                    echo "selected"; ?> > Scontri diretti
                </option>
                <option value="N" <?php if ( isset( $ottipo_calcolo ) && $ottipo_calcolo == "N" )
                    echo "selected"; ?> > Nessun calcolo
                </option>
            </select></td>
        <td align="left">Modalit&agrave; di calcolo dei risultati</td>
    </tr>
    <tr>
        <td>Giornate totali</td>
        <td align="center">
            <input name="N_otgiornate_totali" type="text" size="3" maxlength="2"
                value="<?php echo $otgiornate_totali ?? '' ?>"/></td>
        <td align="left">Il numero di giornate complessive del campionato.</td>
    </tr>
    <tr>
        <td>Ritardo inizio torneo</td>
        <td align="center"><input name="N_otritardo_torneo" type="text" value="<?php echo $otritardo_torneo ?? '' ?>"
                size="3" maxlength="2"/></td>
        <td align="left">In caso di inizio ritardato indicare il n. delle giornate gi&agrave; giocate.</td>
    </tr>
    <tr>
        <td>Crediti iniziali</td>
        <td align="center"><input name="N_otcrediti_iniziali" type="text"
                value="<?php echo $otcrediti_iniziali ?? '' ?>" size="4" maxlength="4"/></td>
        <td align="left">Crediti iniziali, e da incrementare in caso di giornate di riparazione.</td>
    </tr>
    <tr>
        <td>Numero calciatori</td>
        <td align="center"><input name="N_otnumcalciatori" type="text" value="<?php echo $otnumcalciatori ?? '' ?>"
                size="3" maxlength="4"/></td>
        <td align="left">Il totale dei calciatori acquistabili.</td>
    </tr>
    <tr>
        <td>Composizione squadra</td>
        <td align="center"><input name="N_otcomposizione_squadra" type="text"
                value="<?php echo $otcomposizione_squadra ?? '' ?>" size="6" maxlength="5"/></td>
        <td align="left">Esempi: &quot;38806&quot;,&quot;38725&quot;,&quot;38815&quot;,&quot;38716&quot;. La
            somma deve essere uguale al numero dei calciatori previsti per questo campionato.
        </td>
    </tr>
    <tr>
        <td>Modificatore difesa</td>
        <td align="center">
            <select name="N_otmodificatore_difesa">
                <option value="SI" <?php if ( isset( $otmodificatore_difesa ) && $otmodificatore_difesa == "SI" )
                    echo "selected"; ?> > SI
                </option>
                <option value="NO" <?php if ( isset( $otmodificatore_difesa ) && $otmodificatore_difesa == "NO" )
                    echo "selected"; ?> > NO
                </option>
            </select></td>
        <td align="left">impostazione per il calcolo del punteggio con modificatore</td>
    </tr>
    <tr>
        <td>Schemi di gioco</td>
        <td align="center"><input type="text" name="N_otschemi" value="<?php echo $otschemi ?? '' ?>" size="40"
                maxlength="100"/></td>
        <td align="left">Gli schemi di gioco utilizzabili. Gli schemi a 5 numeri servono solo se si usano i
            fantasisti. Si possono aggiungere o togliere schemi. <br/>IMPORTANTE: separare gli schemi con un
            trattino: <br/>1343-1352-1451-1442-1433-1541-1532 - 13403-13502-14501-14402-14303-15401-15302
        </td>
    </tr>
    <tr>
        <td>Numero panchinari</td>
        <td align="center"><input name="N_otmax_in_panchina" type="text"
                value="<?php echo $otmax_in_panchina ?? '' ?>" size="3" maxlength="2"/></td>
        <td align="left">Numero di calciatori in panchina.</td>
    </tr>
    <tr>
        <td>Panchina fissa</td>
        <td align="center">
            <select name="N_otpanchina_fissa">
                <option value="SI" <?php if ( isset( $otpanchina_fissa ) && $otpanchina_fissa == "SI" )
                    echo "selected"; ?> > SI
                </option>
                <option value="NO" <?php if ( isset( $otpanchina_fissa ) && $otpanchina_fissa == "NO" )
                    echo "selected"; ?> > NO
                </option>
            </select></td>
        <td align="left">impostare a "SI" per avere la panchina (1222 come PDCA) altrimenti "NO" per la panchina
            libera
        </td>
    </tr>
    <tr>
        <td>Numero panchinari che possono entrare per sostituzione</td>
        <td align="center"><input name="N_otmax_entrate_dalla_panchina" type="text"
                value="<?php echo $otmax_entrate_dalla_panchina ?? '' ?>" size="3" maxlength="2"/>
        </td>
        <td align="left">Numero di calciatori in panchina che possono essere utilizzati per sostituire i
            titolari. Si possono fare sostituzioni per ruolo (il calciatore entra se un'altro del suo ruolo non
            ha giocato) o per schema (il calciatore entra se entrando lo schema che si forma &egrave; tra quelli
            consentiti). Se sia per ruolo che per schema sono a SI si sostituisce prima per ruolo.
        </td>
    </tr>
    <tr>
        <td>Panchina sostituzione per ruolo</td>
        <td align="center">
            <select name="N_otsostituisci_per_ruolo">
                <option value="SI" <?php if ( isset( $otsostituisci_per_ruolo ) && $otsostituisci_per_ruolo == "SI" )
                    echo "selected"; ?> > SI
                </option>
                <option value="NO" <?php if ( isset( $otsostituisci_per_ruolo ) && $otsostituisci_per_ruolo == "NO" )
                    echo "selected"; ?> > NO
                </option>
            </select></td>
        <td align="left">Nel caso in cui un calciatore titolare non prenda voto la sostituzione con il panchinaro avviene per ruolo. <b>Selezionare almeno una tra le opzioni di sostituzione (<u>per ruolo e per schema</u>), altrimenti non entreranno panchinari in caso di possibile sostituzione</b>.
        </td>
    </tr>
    <tr>
        <td>Panchina sostituisci per schema</td>
        <td align="center">
            <select name="N_otsostituisci_per_schema">
                <option value="SI" <?php if ( isset( $otsostituisci_per_schema ) && $otsostituisci_per_schema == "SI" )
                    echo "selected"; ?> > SI
                </option>
                <option value="NO" <?php if ( isset( $otsostituisci_per_schema ) && $otsostituisci_per_schema == "NO" )
                    echo "selected"; ?> > NO
                </option>
            </select></td>
        <td align="left">Qualora la sostituzione per ruolo non sia insufficiente a completare la rosa effettua
            la sostituzione per schema. <b>Selezionare almeno una tra le opzioni di sostituzione (<u>per ruolo e
                    per schema</u>), altrimenti non entreranno panchinari in caso di possibile sostituzione</b>.
        </td>
    </tr>
    <tr>
        <td>Sostituisci fantasisti come centrocampisti</td>
        <td align="center">
            <select name="N_otsostituisci_fantasisti_come_centrocampisti">
                <option value="SI" <?php if ( isset( $otsostituisci_fantasisti_come_centrocampisti ) && $otsostituisci_fantasisti_come_centrocampisti == "SI" )
                    echo "selected"; ?> >
                    SI
                </option>
                <option value="NO" <?php if ( isset( $otsostituisci_fantasisti_come_centrocampisti ) && $otsostituisci_fantasisti_come_centrocampisti == "NO" )
                    echo "selected"; ?> >
                    NO
                </option>
            </select></td>
        <td align="left">E' una impostazione utilizzata qualche anno fa; impostare a "SI", usato solo con
            sostituzioni per ruolo, massimo 1 fantasista. Attualmente non influente.
        </td>
    </tr>
    <tr>
        <td>Messaggeria</td>
        <td align="center">
            <select name="N_ottemp1">
                <option value="0" <?php if ( isset( $ottemp1 ) && $ottemp1 == "0" )
                    echo "selected"; ?> > Pubblica
                </option>
                <option value="1" <?php if ( isset( $ottemp1 ) && $ottemp1 == "1" )
                    echo "selected"; ?> > Privata
                </option>
            </select></td>
        <td align="left">La messaggeria pubblica condivide i messaggi con tutti i tornei del sito, mentre se
            privata &egrave; ristretta al solo torneo di riferimento.
        </td>
    </tr>
    <tr>
        <td>Quota cassa</td>
        <td align="center"><input name="N_otquotacassa" type="text" value="<?php echo $otquotacassa ?? '' ?>" size="4"
                maxlength="4"/></td>
        <td align="left">Indicare la quota che ogni giocatore deve versare</td>
    </tr>
    <?php
    if ( isset( $otmercato_libero ) && $otmercato_libero == "SI" ) {
        echo "<tr>
				<td>Numero totale dei cambi</td>
				<td align='center'><input name='N_otnumero_cambi_max' type='text' value='$otnumero_cambi_max' size='3' maxlength='2' /></td>
				<td align='left'>Numero di cambi totali che si possono effettuare in una stagione.</td>
				</tr>
				<tr>
				<td>Numero dei cambi in mercato di riparazione</td>
				<td align='center'><input name='N_otrip_cambi_numero' type='text' value='$otrip_cambi_numero' size='3' maxlength='2' /></td>
				<td align='left'>Numero di cambi extra che si possono effettuare una-tantum in fase di mercato di riparazione. <b>Impostare a 0 per disabilitare il mercato di riparazione.</b></td>
				</tr>
				<tr>
				<td>Giornate di riparazione</td>
				<td align='center'><input name='N_otrip_cambi_giornate' type='text' value='$otrip_cambi_giornate' size='30' maxlength='30' /></td>
				<td align='left'>Indicare le giornate dopo le quali &egrave; possibile effettuare il mercato di riparazione, separate da un - (trattino), ad esempio: <b>8-14-20-26-32</b>.</td>
				</tr>
				<tr>
				<td>Durata mercato riparazione</td>
				<td align='center'><select name='N_otrip_cambi_durata'>
				<option value='0'";
        if ( $otrip_cambi_durata == "0" )
            echo "selected";
        echo " > Una giornata</option>
				<option value='1'";
        if ( $otrip_cambi_durata == "1" )
            echo "selected";
        echo " > Due giornate</option>
				</select></td>
				<td align='left'>Indica se il mercato di riparazione dura una giornata, o due come da regolamento Gazzetta.</td>
				</tr>";
    } elseif ( isset( $otmercato_libero ) && $otmercato_libero == "NO" ) {
        echo "<tr>
				<td>Asta e scambi: aspetta giorni</td>
				<td align='center'><input name='N_otaspetta_giorni' type='text' value='$otaspetta_giorni' size='3' maxlength='2' /></td>
				<td align='left'>Indicare 01 per un giorno, 02 per due giorni e cos&igrave; via!</td>
				</tr>
				<tr>
				<td>Asta e scambi: aspetta ore</td>
				<td align='center'><input name='N_otaspetta_ore' type='text' value='$otaspetta_ore' size='3' maxlength='2' /></td>
				<td align='left'>Indicare 01 per una ora, 02 per due ore e cos&igrave; via!</td>
				</tr>
				<tr>
				<td>Asta e scambi: aspetta minuti</td>
				<td align='center'><input name='N_otaspetta_minuti' type='text' value='$otaspetta_minuti' size='3' maxlength='2' /></td>
				<td align='left'>Indicare 00 per nessun minuto, 02 per due e cos&igrave; via!</td>
				</tr>
				<tr>
				<td>Numero calciatori scambiabili</td>
				<td align='center'><input name='N_otnum_calciatori_scambiabili' type='text' value='$otnum_calciatori_scambiabili' size='3' maxlength='2' /></td>
				<td align='left'>Indica il totale dei calciatori che &egrave; possibile inserire in una offerta di scambio. <b>0 disabilita gli scambi</b>.</td>
				</tr>";

        $checkSI = "";
        $checkNO = "";
        if ( $otreset_scadenza == "SI" )
            $checkSI = "checked"; else $checkNO = "checked";
        echo "<tr><td>Reset timer asta</td><td align='center'>SI&nbsp;<input type='radio' name='N_otreset_scadenza' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_otreset_scadenza' value='NO' $checkNO /></td><td>Impostazione che consente di resettare il timer dopo un rilancio dell'offerta.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ( $otscambio_con_soldi == "SI" )
            $checkSI = "checked"; else $checkNO = "checked";
        echo "<tr><td>Offerta scambio con crediti</td><td align='center'>SI&nbsp;<input type='radio' name='N_otscambio_con_soldi' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_otscambio_con_soldi' value='NO' $checkNO /></td><td>Impostazione che consente di inserire anche dei fantacrediti nelle offerte di scambio.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ( $otvendi_costo == "SI" )
            $checkSI = "checked"; else $checkNO = "checked";
        echo "<tr><td>Vendita al costo</td><td align='center'>SI&nbsp;<input type='radio' name='N_otvendi_costo' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_otvendi_costo' value='NO' $checkNO /></td><td>Indica il comportamento in caso di vendita di un calciatore: SI vende al costo di acquisto, NO vende alla valutazione attuale.</td></tr>";

        echo "<tr>
				<td>Percentuale di vendita sul prezzo</td>
				<td align='center'><input name='N_otpercentuale_vendita' type='text' value='$otpercentuale_vendita' size='3' maxlength='3' /></td>
				<td align='left'>Indica il deprezzamento che subisce un calciatore in caso di vendita.</td>
				</tr>";
    }

    if ( isset( $ottipo_calcolo ) && ( $ottipo_calcolo == "P" || $ottipo_calcolo == "S" ) ) {
        echo "<tr>
				<td>soglia_voti_primo_gol</td>
				<td align='center'><input name='N_otsoglia_voti_primo_gol' type='text' value='$otsoglia_voti_primo_gol' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>incremento_voti_gol_successivi</td>
				<td align='center'><input name='N_otincremento_voti_gol_successivi' type='text' value='$otincremento_voti_gol_successivi' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>voti_bonus_in_casa</td>
				<td align='center'><input name='N_otvoti_bonus_in_casa' type='text' value='$otvoti_bonus_in_casa' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>punti_partita_vinta</td>
				<td align='center'><input name='N_otpunti_partita_vinta' type='text' value='$otpunti_partita_vinta' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>punti_partita_pareggiata</td>
				<td align='center'><input name='N_otpunti_partita_pareggiata' type='text' value='$otpunti_partita_pareggiata' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>punti_partita_persa</td>
				<td align='center'><input name='N_otpunti_partita_persa' type='text' value='$otpunti_partita_persa' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>differenza_punti_a_parita_gol</td>
				<td align='center'><input name='N_otdifferenza_punti_a_parita_gol' type='text' value='$otdifferenza_punti_a_parita_gol' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>differenza_punti_zero_a_zero</td>
				<td align='center'><input name='N_otdifferenza_punti_zero_a_zero' type='text' value='$otdifferenza_punti_zero_a_zero' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>min_num_titolari_in_formazione</td>
				<td align='center'><input name='N_otmin_num_titolari_in_formazione' type='text' value='$otmin_num_titolari_in_formazione' size='3' maxlength='2' /></td>
				<td align='left'>&nbsp;</td>
				</tr>
				<tr>
				<td>Punti pareggio</td>
				<td align='center'>
				<select name='N_otpunti_pareggio'>
				<option value='M'";
        if ( $otpunti_pareggio == "M" )
            ;
        echo " > Media</option>
				<option value='A'";
        if ( $otpunti_pareggio == "A" )
            echo "selected";
        echo " > Alta</option>
				<option value='B'";
        if ( $otpunti_pareggio == "B" )
            ;
        echo " > Bassa</option>
				</select></td>
				<td align='left'>Dati per i campionati a punti per posizione di giornata. Servono solo se si
				impostato un campionato a <u>P</u>unti. Impostare per la media, per i punti della posizione pi&ugrave; alta o per quelli della pi&ugrave; bassa.</td>
				</tr>
				<tr>
				<td>punti_posizione</td>
				<td align='center'><input name='N_otpunti_pos' type='text' value='$otpunti_pos' size='30' maxlength='30' /></td>
				<td align='left'>Indicare i punti da assegnare separandoli con un trattino. Variare a seconda del numero di giocatori.<br />Esempio: <b>10-8-6-5-4-2-1-0</b></td>
				</tr>
				";
    }

    echo "</table>";
    if ( !isset($otmercato_libero) || ! $otmercato_libero )
        echo "<p align='center'><b>Dopo aver confermato i dati sar&agrave; possibile configurare le specifiche del torneo!</b></p>";
    echo "<p align='center'>
			<input type='hidden' name='inserimento' value='scrivi' />
			<input type='submit' name='Submit' value='Registra dati' />
			</p></form>";
    }
    } #fine else if ($inserimento == "scrivi") {
    } # fine if ($_SESSION["utente"]
    else header( "location:./logout.php" );
    include( "./footer.php" );
    ?>
