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
require_once("./controlla_pass.php");
include("./header.php");

if ($_SESSION['valido'] == "SI" and $_SESSION['permessi'] == 5) {
    echo "<script type='text/javascript' src='./inc/js/picker.js'></script>";
    require("./a_menu.php");

    if (isset($verifiche_config) && $verifiche_config == 2) {
        $n_contenuto_dati = "<?php
############################################################################
# FANTACALCIOBAZAR EVOLUTION
# Copyright (C) 2003-2010 by Antonello Onida 
#
# PARAMETRI VISUALIZZAZIONE ED ESTETICA\n\n";
        $n_contenuto_dati .= "\$titolo_sito						= '" . htmlentities($N_titolo_sito) . "';\n";
        $n_contenuto_dati .= "\$admin_nome 						= '$N_admin_nome';\n";
        $n_contenuto_dati .= "\$email_mittente 					= '$N_email_mittente';\n";
        $n_contenuto_dati .= "\$admin_user 						= '$N_admin_user';\n";
        $n_contenuto_dati .= "\$admin_pass 						= '$N_admin_pass';\n";
        $n_contenuto_dati .= "\$iscrizione_online				= '$N_iscrizione_online';\n";
        $n_contenuto_dati .= "\$iscrizione_immediata_utenti		=	'$N_iscrizione_immediata_utenti';\n";
        $n_contenuto_dati .= "\$mostra_voti_in_login 			= '$N_mostra_voti_in_login';\n";
        $n_contenuto_dati .= "\$trasferiti_ok       			= '$N_trasferiti_ok';\n";
        $n_contenuto_dati .= "\$mostra_giornate_in_login 		= '$N_mostra_giornate_in_login';\n";
        $n_contenuto_dati .= "\$mostra_giornate_in_mercato 		= '$N_mostra_giornate_in_mercato';\n";
        $n_contenuto_dati .= "\$mostra_immagini_in_login 		= '$N_mostra_immagini_in_login';\n";
        $n_contenuto_dati .= "\$dir_immagini 					= '$N_dir_immagini';\n";
        $n_contenuto_dati .= "\$larghezza_immagine 				= '$N_larghezza_immagine';\n";
        $n_contenuto_dati .= "\$larghezza_immagine_casuale 		= '$N_larghezza_immagine_casuale';\n";
        $n_contenuto_dati .= "\$file_voti_fonte					= '$N_file_voti_fonte';\n";
        $n_contenuto_dati .= "\$statistiche 					= '$N_statistiche';\n";
        $n_contenuto_dati .= "\$menu_lato 						= '$N_menu_lato';\n";
        $n_contenuto_dati .= "\$foto_calciatori 				= '$N_foto_calciatori';\n";
        $n_contenuto_dati .= "\$foto_path 						= '$N_foto_path';\n";
        $n_contenuto_dati .= "\$consenti_logo					=	'$N_consenti_logo';\n";
        $n_contenuto_dati .= "\$vedi_campetto					=	'$N_vedi_campetto';\n";
        $n_contenuto_dati .= "\$riduci							=	'$N_riduci';\n";
        $n_contenuto_dati .= "\$riduci1							=	'$N_riduci1';\n";
        $n_contenuto_dati .= "\$orientamento_campetto			=	'$N_orientamento_campetto';\n\n";
        $n_contenuto_dati .= "\$sfondo_tab						=	'$N_sfondo_tab';\n";
        $n_contenuto_dati .= "\$sfondo_tab1						=	'$N_sfondo_tab1';\n";
        $n_contenuto_dati .= "\$sfondo_tab2						=	'$N_sfondo_tab2';\n";
        $n_contenuto_dati .= "\$sfondo_tab3						=	'$N_sfondo_tab3';\n";
        $n_contenuto_dati .= "\$bgtabtitolari					=	'$N_bgtabtitolari';\n";
        $n_contenuto_dati .= "\$bgtabpanchinari					=	'$N_bgtabpanchinari';\n";
        $n_contenuto_dati .= "\$colore_riga_alt					=	'$N_colore_riga_alt';\n";
        $n_contenuto_dati .= "\$carattere_tipo					=	'$N_carattere_tipo';\n";
        $n_contenuto_dati .= "\$carattere_size					=	'$N_carattere_size';\n";
        $n_contenuto_dati .= "\$carattere_colore				=	'$N_carattere_colore';\n";
        $n_contenuto_dati .= "\$carattere_colore_chiaro			=	'$N_carattere_colore_chiaro';\n\n";
        $n_contenuto_dati .= "\$percorso_cartella_dati 			=	'$N_percorso_cartella_dati';\n";
        $n_contenuto_dati .= "\$percorso_cartella_scontri 		=	'$N_percorso_cartella_scontri';\n";
        $n_contenuto_dati .= "\$percorso_cartella_voti 			=	'$N_percorso_cartella_voti';\n";
        $n_contenuto_dati .= "\$uploaddir 						=	'$N_uploaddir';\n";
        $n_contenuto_dati .= "\$manutenzione 					=	'$N_manutenzione';\n";
        $n_contenuto_dati .= "\$attiva_log 						=	'$N_attiva_log';\n";
        $n_contenuto_dati .= "\$attiva_rss 						= '$N_attiva_rss';\n";
        $n_contenuto_dati .= "\$url_rss							= '$N_url_rss';\n";
        $n_contenuto_dati .= "\$attiva_multi 					= '$N_attiva_multi';\n\n";
        $n_contenuto_dati .= "\$attiva_shoutbox 				= '$N_attiva_shoutbox';\n";
        $n_contenuto_dati .= "\$usa_cms 						= '$N_usa_cms';\n";
        $n_contenuto_dati .= "\$vedi_notizie 					= '$N_vedi_notizie';\n";
        $n_contenuto_dati .= "\$temp1	= '';\n";
        $n_contenuto_dati .= "\$temp2	= '';\n";
        $n_contenuto_dati .= "\$temp3	= '';\n";
        $n_contenuto_dati .= "\$temp4	= '';\n";
        $n_contenuto_dati .= "\$temp5	= '';\n";
        $n_contenuto_dati .= "\$temp6	= '';\n";
        $n_contenuto_dati .= "\$temp7	= '';\n";
        $n_contenuto_dati .= "\$temp8	= '';\n";
        $n_contenuto_dati .= "\$temp9	= '';\n";
        $n_contenuto_dati .= "\$temp0	= '';\n\n\n\n";

# Dati non configurabili da form

        $n_contenuto_dati .= "# PARAMETRI NON CONFIGURABILI DA FORM\n\n";
        $n_contenuto_dati .= "\$attiva_sponsors = 'SI';\n";
        $n_contenuto_dati .= "\$usa_tinyMCE = 'SI';\n";
        $n_contenuto_dati .= "\$separatore_campi_file_calciatori = '|';\n";
        $n_contenuto_dati .= "\$num_colonna_numcalciatore_file_calciatori = 1;\n";
        $n_contenuto_dati .= "\$num_colonna_nome_file_calciatori = 3;\n";
        $n_contenuto_dati .= "\$num_colonna_ruolo_file_calciatori = 6;\n";
        $n_contenuto_dati .= "\$simbolo_portiere_file_calciatori = '0';\n";
        $n_contenuto_dati .= "\$simbolo_difensore_file_calciatori = '1';\n";
        $n_contenuto_dati .= "\$simbolo_centrocampista_file_calciatori = '2';\n";
        $n_contenuto_dati .= "\$simbolo_fantasista_file_calciatori = '';\n";
        $n_contenuto_dati .= "\$simbolo_attaccante_file_calciatori = '3';\n";
        $n_contenuto_dati .= "\$considera_fantasisti_come = 'C';\n";
        $n_contenuto_dati .= "\$num_colonna_squadra_file_calciatori = 4;\n\n";

        $n_contenuto_dati .= "# Composizione del file con i voti di giornata (dati/votiXX.txt)\n";
        $n_contenuto_dati .= "\$separatore_campi_file_voti = '|';\n";
        $n_contenuto_dati .= "\$num_colonna_numcalciatore_file_voti = 1;\n";
        $n_contenuto_dati .= "\$num_colonna_vototot_file_voti = 8;\n";
        $n_contenuto_dati .= "\$num_colonna_votogiornale_file_voti = 11;\n";
        $n_contenuto_dati .= "\$num_colonna_valore_calciatori = 28;\n\n";

        $n_contenuto_dati .= "# Posizione del file dei voti da copiare (se non viene copiato a mano), pu�\n";
        $n_contenuto_dati .= "# essere anche una URL (http://...). Se il file contiene anche 01,02,... in\n";
        $n_contenuto_dati .= "# corripondeza alla giornata utilizzare anche la 2�,3�,4� e 5� variabile.\n";
        $n_contenuto_dati .= "\$prima_parte_pos_file_voti = '$N_prima_parte_pos_file_voti';\n";
        $n_contenuto_dati .= "\$cartella_remota ='$N_cartella_remota';\n";
        $n_contenuto_dati .= "\$abilita_stat ='$N_abilita_stat';\n";
        $n_contenuto_dati .= "\$risparmia_risorse ='$N_risparmia_risorse';\n";
        $n_contenuto_dati .= "\$num_giornata_file_voti = 'SI';\n";
        $n_contenuto_dati .= "\$num_giornata_file_voti_doppio = 'SI';\n";
        $n_contenuto_dati .= "\$seconda_parte_pos_file_voti = '.txt';\n\n";

        $n_contenuto_dati .= "# Dati non configurabili da form\n\n";
        $n_contenuto_dati .= "\$sito_principale='http://fcbe.sssr.it/dati/';\n";
        $n_contenuto_dati .= "\$sito_mirror='http://fantadownload.altervista.org/mirrorFCBE/dati/';\n";
        $n_contenuto_dati .= "\$sito_mirror_custom='https://fcbemirror.fdisotto.com/dati/';\n\n";
        $n_contenuto_dati .= "# Composizione del file con i dati delle statistiche (dati/file);\n";
        $n_contenuto_dati .= "\$ncs_codice = 1;\n";
        $n_contenuto_dati .= "\$ncs_giornata = 2;\n";
        $n_contenuto_dati .= "\$ncs_nome = 3;\n";
        $n_contenuto_dati .= "\$ncs_squadra = 4;\n";
        $n_contenuto_dati .= "\$ncs_attivo = 5;\n";
        $n_contenuto_dati .= "\$ncs_ruolo = 6;\n";
        $n_contenuto_dati .= "\$ncs_presenza = 7;\n";
        $n_contenuto_dati .= "\$ncs_votofc = 8;\n";
        $n_contenuto_dati .= "\$ncs_mininf25 = 9;\n";
        $n_contenuto_dati .= "\$ncs_minsup25 = 10;\n";
        $n_contenuto_dati .= "\$ncs_voto = 11;\n";
        $n_contenuto_dati .= "\$ncs_golsegnati = 12;\n";
        $n_contenuto_dati .= "\$ncs_golsubiti = 13;\n";
        $n_contenuto_dati .= "\$ncs_golvittoria = 14;\n";
        $n_contenuto_dati .= "\$ncs_golpareggio = 15;\n";
        $n_contenuto_dati .= "\$ncs_assist = 16;\n";
        $n_contenuto_dati .= "\$ncs_ammonizione = 17;\n";
        $n_contenuto_dati .= "\$ncs_espulsione = 18;\n";
        $n_contenuto_dati .= "\$ncs_rigoretirato = 19;\n";
        $n_contenuto_dati .= "\$ncs_rigoresubito = 20;\n";
        $n_contenuto_dati .= "\$ncs_rigoreparato = 21;\n";
        $n_contenuto_dati .= "\$ncs_rigoresbagliato = 22;\n";
        $n_contenuto_dati .= "\$ncs_autogol = 23;\n";
        $n_contenuto_dati .= "\$ncs_entrato = 24;\n";
        $n_contenuto_dati .= "\$ncs_titolare = 25;\n";
        $n_contenuto_dati .= "\$ncs_sv = 26;\n";
        $n_contenuto_dati .= "\$ncs_casa = 27;\n";
        $n_contenuto_dati .= "\$ncs_valore = 28;\n\n";
        $n_contenuto_dati .= "?>";

        if (@fopen($percorso_cartella_dati . "/dati_gen.php", "w+")) {
            $file_dati = fopen($percorso_cartella_dati . "/dati_gen.php", "wb+");
            flock($file_dati, LOCK_EX);
            $n_contenuto_dati = trim($n_contenuto_dati);
            fwrite($file_dati, $n_contenuto_dati);
            flock($file_dati, LOCK_UN);
            fclose($file_dati);
            echo "<br/><br/><center><h3>Modifiche dati_gen.php salvate.</h3></center><br/><br/><br/><br/><br/>";
            echo "<meta http-equiv='refresh' content='0; url=a_gestione.php?messgestutente=30'>";
            exit;
        } # fine if (fopen("$percorso_cartella_dati/dati_gen.php","w+"))
        else {
            echo "<br/><br/><center><h3>Modifiche dati_gen.php non salvate.</h3></center><br/><br/><br/><br/><br/>";
            echo "<meta http-equiv='refresh' content='0; url=a_gestione.php?messgestutente=31'>";
            exit;
        }
    } # fine if ($verifiche_config == 2) {

    else if (isset($verifiche_config) && $verifiche_config == 1) {
        $procedi = "SI";
    } # fine else if ($verifiche_config == 1) {

    else {
        echo "<form name='form_configura' action='./a_configura.php' method='post'>
		<table bgcolor='$sfondo_tab' width='100%' border='1'>
		<caption>CONFIGURAZIONE VISUALIZZAZIONE</caption>

		<tr><td width='20%'>Titolo sito</td><td width='20%'><input type='text' value='$titolo_sito' name='N_titolo_sito' size=40 maxlength=50 /></td><td width='50%'>&nbsp;</td></tr>

		<tr><td>Nome amministratore</td><td><input type='text' value='$admin_nome' name='N_admin_nome' size=40 maxlength=40 /></td><td>Nome del Presidente che sar&agrave; visualizzato nei vari messaggi.</td></tr>

		<tr><td>Indirizzo email amministratore</td><td><input type='text' value='$email_mittente' name='N_email_mittente' size=40 maxlength=40 /></td><td>Indirizzo email del Presidente di Lega.</td></tr>

		<tr><td>Login amministratore</td><td><input type='text' value='$admin_user' name='N_admin_user' size=15 maxlength=15 /></td><td>Nome dell'amministratore per accedere al pannello di controllo (max 15 caratteri).</td></tr>

		<tr><td>Password amministratore</td><td><input type='text' value='$admin_pass' name='N_admin_pass' size=15 maxlength=15 /></td><td>Pass dell'amministratore per accedere al pannello di controllo (max 15 caratteri).</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($iscrizione_online == "SI") $checkSI = "checked";
        else $checkNO = "checked";
        echo "<tr><td>Iscrizione online</td><td align='center'>SI&nbsp;<input type='radio' name='N_iscrizione_online' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_iscrizione_online' value='NO' $checkNO /></td><td><b>SI</b> consente l'iscrizione all'utente online - <b>NO</b> sar&agrave; l'amministratore ad effettuare le iscrizioni manualmente.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($iscrizione_immediata_utenti == "SI") $checkSI = "checked";
        else $checkNO = "checked";
        echo "<tr><td>Iscrizione immediata utenti</td><td align='center'>SI&nbsp;<input type='radio' name='N_iscrizione_immediata_utenti' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_iscrizione_immediata_utenti' value='NO' $checkNO /></td><td><b>NO</b> imposta a -1 il flag permessi in gestione utenti; dovr&agrave; essere attivato dalla gestione utenti.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($mostra_voti_in_login == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Voti in prima pagina</td><td align='center'>SI&nbsp;<input type='radio' name='N_mostra_voti_in_login' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_mostra_voti_in_login' value='NO' $checkNO /></td><td>Consente di visualizzare i voti senza loggarsi in prima pagina.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($risparmia_risorse == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Risparmia risorse</td><td align='center'>SI&nbsp;<input type='radio' name='N_risparmia_risorse' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_risparmia_risorse' value='NO' $checkNO /></td><td>Consente di limitare l'utilizzo di molte risorse sul server accellerando il caricamento delle pagine.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if (isset($trasferiti_ok) && $trasferiti_ok == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Cambia trasferiti</td><td align='center'>SI&nbsp;<input type='radio' name='N_trasferiti_ok' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_trasferiti_ok' value='NO' $checkNO /></td><td>Consente di abilitare la procedura per il cambio dei trasferiti, senza che questi vengano conteggiati nel totale dei cambi.</td></tr>";

        $ATT1 = "";
        $ATT2 = "";
        $ATT3 = "";
        $ATT4 = "";
        if ($abilita_stat == "AUTO") $ATT1 = "selected";
        if ($abilita_stat == "PRINCIPALE") $ATT2 = "selected";
        if ($abilita_stat == "MIRROR") $ATT3 = "selected";
        if ($abilita_stat == "OFF") $ATT4 = "selected";

        echo "<tr><td>Server esterno</td><td align='center'><select name='N_abilita_stat'><option value='AUTO' $ATT1>AUTOMATICO</option><option value='PRINCIPALE' $ATT2>PRINCIPALE</option><option value='MIRROR' $ATT3>MIRROR</option><option value='OFF'$ATT4>OFF</option></select></td><td>Seleziona da quale server esterno caricare le risorse.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($mostra_giornate_in_login == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Giornate in prima pagina</td><td align='center'>SI&nbsp;<input type='radio' name='N_mostra_giornate_in_login' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_mostra_giornate_in_login' value='NO' $checkNO /></td><td>Consente di visualizzare le giornate senza loggarsi in prima pagina.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($mostra_giornate_in_mercato == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Giornate in mercato</td><td align='center'>SI&nbsp;<input type='radio' name='N_mostra_giornate_in_mercato' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_mostra_giornate_in_mercato' value='NO' $checkNO /></td><td>Consente di visualizzare le giornate in mercato.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($usa_cms == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Utilizza CMS</td><td align='center'>SI&nbsp;<input type='radio' name='N_usa_cms' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_usa_cms' value='NO' $checkNO /></td><td>Utilizza il CMS Alessia di Antonello Onida da richiedere separatamente.</td></tr>
				<tr><td>Notizie in index</td><td><input type='text' value='$vedi_notizie' name='N_vedi_notizie' size=2 maxlength=1 /></td><td>0 - disabilitato 1 - blocco in index - 2 - blocco in index e blocco laterale in menu.</td></tr>";


        $checkSI = "";
        $checkNO = "";
        if ($attiva_shoutbox == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Attiva shoutbox</td><td align='center'>SI&nbsp;<input type='radio' name='N_attiva_shoutbox' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_attiva_shoutbox' value='NO' $checkNO /></td><td>Attiva lo shoutbox in prima pagina.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($mostra_immagini_in_login == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Galleria immagini</td><td align='center'>SI&nbsp;<input type='radio' name='N_mostra_immagini_in_login' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_mostra_immagini_in_login' value='NO' $checkNO /></td><td>Mostra una galleria di immagini nella prima pagina.</td></tr>

		<tr><td>Cartella immagini</td><td><input type='text' value='$dir_immagini' name='N_dir_immagini' size=40 maxlength=40 /></td><td>Indica la cartella dove sono situate le immagini per la galleria.</td></tr>

		<tr><td>Larghezza immagini</td><td><input type='text' value='$larghezza_immagine' name='N_larghezza_immagine' size=4 maxlength=4 /></td><td>Indica la larghezza delle immagini mostrate nella galleria IN PIXEL.</td></tr>

		<tr><td>Larghezza immagini casuali</td><td><input type='text' value='$larghezza_immagine_casuale' name='N_larghezza_immagine_casuale' size=4 maxlength=4 /></td><td>Indica la larghezza delle immagini casuali della funzione immagine_casuale () IN PIXEL.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($statistiche == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Statistiche avanzate</td><td align='center'>SI&nbsp;<input type='radio' name='N_statistiche' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_statistiche' value='NO' $checkNO /></td><td>$statistiche - Se si dispone di un file statistiche (es. MCCxx.dat) consente mi mostrare statistiche avanzate.</td></tr>

		<tr><td>Fonte voti</td><td><input type='text' value='$file_voti_fonte' name='N_file_voti_fonte' size=40 maxlength=40 /></td><td>Origine del file voti (Gazzetta, Corriere, Fantacalcio.it).</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($menu_lato == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Menu laterale</td><td align='center'>SI&nbsp;<input type='radio' name='N_menu_lato' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_menu_lato' value='NO' $checkNO /></td><td>SI vizualizza menu a lato - NO il menu viene mostrato sopra DA FARE!!!!</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($foto_calciatori == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Foto calciatori</td><td align='center'>SI&nbsp;<input type='radio' name='N_foto_calciatori' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_foto_calciatori' value='NO' $checkNO /></td><td>Se si dispone delle foto dei calciatori queste saranno visualizzate in varie pagine.</td></tr>

		<tr><td>Path foto calciatori</td><td><input type='text' value='$foto_path' name='N_foto_path' size=40 maxlength=40 /></td><td>Indica la cartella contenente le foto dei calciatori.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($consenti_logo == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Logo squadra</td><td align='center'>SI&nbsp;<input type='radio' name='N_consenti_logo' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_consenti_logo' value='NO' $checkNO /></td><td>Funzione non completata</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($vedi_campetto == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Immagine campetto</td><td align='center'>SI&nbsp;<input type='radio' name='N_vedi_campetto' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_vedi_campetto' value='NO' $checkNO /></td><td>Visualizzazione grafica della squadra in campo</td></tr>

		<tr><td>Dimensionamento campetto</td><td><input type='text' value='$riduci' name='N_riduci' size=4 maxlength=3 /></td><td>Riduzione delle dimensioni del solo campetto da 40% a 200%</td></tr>

		<tr><td>Dimensionamento campetto completa</td><td><input type='text' value='$riduci1' name='N_riduci1' size=4 maxlength=3 /></td><td>Riduzione delle dimensioni del campetto maglie comprese da 40% a 200%</td></tr>

		<tr><td>Orientamento campetto</td><td><input type='text' value='$orientamento_campetto' name='N_orientamento_campetto' size=2 maxlength=1 /></td><td> 1 = orizzontale - 0 = verticale</td></tr>

		<tr><td>Sfondo tabelle</td><td valign='middle'><input type='text' value='$sfondo_tab' name='N_sfondo_tab' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_sfondo_tab'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td bgcolor='$sfondo_tab'>variabile per cambiare il colore di sfondo delle tabelle</td></tr>

		<tr><td>Sfondo BODY</td><td><input type='text' value='$sfondo_tab1' name='N_sfondo_tab1' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_sfondo_tab1'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td><td bgcolor='$sfondo_tab1'>variabile per cambiare il colore di sfondo del BODY</td></tr>

		<tr><td>Sfondo intestazione</td><td><input type='text' value='$sfondo_tab2' name='N_sfondo_tab2' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_sfondo_tab2'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td bgcolor='$sfondo_tab2'>Per il caption delle tabelle</td></tr>

		<tr><td>Sfondo menu</td><td><input type='text' value='$sfondo_tab3' name='N_sfondo_tab3' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_sfondo_tab3'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td bgcolor='$sfondo_tab3'><font color='$carattere_colore_chiaro'>variabile per cambiare il colore di sfondo del menu.</font></td></tr>

		<tr><td>Colore titolari</td><td><input type='text' value='$bgtabtitolari' name='N_bgtabtitolari' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_bgtabtitolari'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td bgcolor='$bgtabtitolari'>Colore di sfondo tabella titolari in squadra</td></tr>

		<tr><td>Colore panchinari</td><td><input type='text' value='$bgtabpanchinari' name='N_bgtabpanchinari' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_bgtabpanchinari'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td bgcolor='$bgtabpanchinari'>Colore di sfondo tabella titolari in squadra</td></tr>

		<tr><td>Colore riga alternata</td><td><input type='text' value='$colore_riga_alt' name='N_colore_riga_alt' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_colore_riga_alt'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td bgcolor='$colore_riga_alt'>Colore per meglio visualizzare e definire le righe di una tabella</td></tr>

		<tr><td>Tipo carattere</td><td><input type='text' value='$carattere_tipo' name='N_carattere_tipo' size=40 maxlength=40 /></td><td>Personalizzare il carattere. Funzione da migliorare.</td></tr>

		<tr><td>Dimensione carattere</td><td><input type='text' value='$carattere_size' name='N_carattere_size' size=4 maxlength=4 /></td><td>Selezionare le dimensioni del carattere di base. Funzione da migliorare.</td></tr>

		<tr><td>Colore carattere</td><td><input type='text' value='$carattere_colore' name='N_carattere_colore' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"javascript:TCPopup(document.forms['form_configura'].elements['N_carattere_colore'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td>Selezionare il colore di base. Funzione da migliorare.</td></tr>

		<tr><td>Colore alternativo carattere</td><td><input type='text' value='$carattere_colore_chiaro' name='N_carattere_colore_chiaro' size=8 maxlength=7 />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<a href=\"javascript:TCP.popup(document.forms['form_configura'].elements['N_carattere_colore_chiaro'],1)\"><img width='40' height='15' border='0' alt='Seleziona il colore' src='./immagini/cp.jpg' /></a></td>
		<td bgcolor='$sfondo_tab3'>Esempio:<font color='$carattere_colore_chiaro'>Colore carattere alternativo da utilizzarsi con il colore della tabella menu</font></td></tr>

		<tr><td>Percorso cartella dati</td><td><input type='text' value='$percorso_cartella_dati' name='N_percorso_cartella_dati' size=40 maxlength=40 /></td><td>Indicare dove saranno registrati i dati; esempio <b>./dati</b></td></tr>

		<tr><td>Percorso cartella scontri</td><td><input type='text' value='$percorso_cartella_scontri' name='N_percorso_cartella_scontri' size=40 maxlength=40 /></td><td>Selezionare la cartella dove sono contenuti i template degli scontri; esempio <b>scontri</b> senza alcun slash.</td></tr>

		<tr><td>Percorso cartella voti</td><td><input type='text' value='$percorso_cartella_voti' name='N_percorso_cartella_voti' size=40 maxlength=40 /></td><td><u>Solitamente uguale alla cartella dati</u>; esempio <b>./voti</b></td></tr>
		
		<tr><td>Prima parte posizione file voti</td><td><input type='text' value='$prima_parte_pos_file_voti' name='N_prima_parte_pos_file_voti' size=40 maxlength=40 /></td><td><u>Solitamente <b>dati/XXXX/MCC</b> dove XXXX e' l'anno</td></tr>
		
		<tr><td>Cartella remota download file voti</td><td><input type='text' value='$cartella_remota' name='N_cartella_remota' size=4 maxlength=4 /></td><td>Solitamente si utilizza l'anno di inizio del campionato. Es: 2012</td></tr>

		<tr><td>Cartella per upload</td><td><input type='text' value='$uploaddir' name='N_uploaddir' size=40 maxlength=40 /></td><td>Nome cartella dove uploadare i file dati dentro la cartelle <b>$percorso_cartella_dati</b>; per esempio <b>2006</b>.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($manutenzione == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Manutenzione sito</td><td align='center'>SI&nbsp;<input type='radio' name='N_manutenzione' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_manutenzione' value='NO' $checkNO /></td><td></td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($attiva_log == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Attiva log dati</td><td align='center'>SI&nbsp;<input type='radio' name='N_attiva_log' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_attiva_log' value='NO' $checkNO /></td><td></td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($attiva_rss == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Attiva lettore RSS</td><td align='center'>SI&nbsp;<input type='radio' name='N_attiva_rss' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_attiva_rss' value='NO' $checkNO /></td><td>Attiva lettore interno di RSS in index.</td></tr>";

        echo "<tr><td>URL RSS feed</td><td><input type='text' value='$url_rss ' name='N_url_rss' size=40 maxlength=40 /></td><td>Indirizzo al file RSS.</td></tr>";

        $checkSI = "";
        $checkNO = "";
        if ($attiva_multi == "SI") $checkSI = "checked";
        else $checkNO = "checked";

        echo "<tr><td>Attiva gestione multicampionati</td><td align='center'>SI&nbsp;<input type='radio' name='N_attiva_multi' value='SI' $checkSI />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NO&nbsp;<input type='radio' name='N_attiva_multi' value='NO' $checkNO /></td><td>Funzione da migliorare</td></tr>";

        echo "</table><input type='hidden' name='verifiche_config' value='2' />
		<center><input type='submit' value='Salva le modifiche' /></center>
		</form>";
    } # fine else

} # fine if ($_SESSION valido)
else header("location: logout.php?logout=2");
include("./footer.php");
?>
