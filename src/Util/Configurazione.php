<?php

namespace FCBE\Util;

use Exception;

class Configurazione
{
    public static function saveConfigurazione( array $configurazione ): bool
    {
        global $percorso_cartella_dati;

        try {
            $n_contenuto_dati = <<<CONTENT
<?php
\$titolo_sito = "{$configurazione['titolo_sito']}";
\$admin_nome = "{$configurazione['admin_nome']}";
\$email_mittente = "{$configurazione['email_mittente']}";
\$admin_user = "{$configurazione['admin_user']}";
\$admin_pass = "{$configurazione['admin_pass']}";
\$iscrizione_online = "{$configurazione['iscrizione_online']}";
\$iscrizione_immediata_utenti = "{$configurazione['iscrizione_immediata_utenti']}";
\$mostra_voti_in_login = "{$configurazione['mostra_voti_in_login']}";
\$trasferiti_ok = "{$configurazione['trasferiti_ok']}";
\$mostra_giornate_in_login = "{$configurazione['mostra_giornate_in_login']}";
\$mostra_giornate_in_mercato = "{$configurazione['mostra_giornate_in_mercato']}";
\$file_voti_fonte = "Gazzetta dello Sport";
\$statistiche = "SI";
\$menu_lato = "SI";
\$foto_calciatori = "SI";
\$foto_path = "immagini/foto/";
\$consenti_logo = "SI";
\$vedi_campetto = "SI";
\$riduci = "100";
\$riduci1 = "100";
\$orientamento_campetto = "1";

\$percorso_cartella_dati = "./dati";
\$percorso_cartella_scontri = "./dati/scontri";
\$percorso_cartella_voti = "./dati";
\$uploaddir = "./dati/{$configurazione['cartella_remota']}";
\$manutenzione = "NO";
\$attiva_log = "SI";
\$attiva_rss = "SI";
\$url_rss = 'https://www.gazzetta.it/rss/serie-a.xml';
\$usa_cms = "SI";
\$vedi_notizie = "{$configurazione['vedi_notizie']}";

\$temp1	= "";
\$temp2	= "";
\$temp3	= "";
\$temp4	= "";
\$temp5	= "";
\$temp6	= "";
\$temp7	= "";
\$temp8	= "";
\$temp9	= "";
\$temp0	= "";

# PARAMETRI NON CONFIGURABILI DA FORM

\$attiva_sponsors = 'SI';
\$usa_tinyMCE = 'SI';
\$separatore_campi_file_calciatori = '|';
\$num_colonna_numcalciatore_file_calciatori = 1;
\$num_colonna_nome_file_calciatori = 3;
\$num_colonna_ruolo_file_calciatori = 6;
\$simbolo_portiere_file_calciatori = '0';
\$simbolo_difensore_file_calciatori = '1';
\$simbolo_centrocampista_file_calciatori = '2';
\$simbolo_fantasista_file_calciatori = '';
\$simbolo_attaccante_file_calciatori = '3';
\$considera_fantasisti_come = 'C';
\$num_colonna_squadra_file_calciatori = 4;

# Composizione del file con i voti di giornata (dati/votiXX.txt)
\$separatore_campi_file_voti = '|';
\$num_colonna_numcalciatore_file_voti = 1;
\$num_colonna_vototot_file_voti = 8;
\$num_colonna_votogiornale_file_voti = 11;
\$num_colonna_valore_calciatori = 28;

# Posizione del file dei voti da copiare (se non viene copiato a mano), può
# essere anche una URL (http://...). Se il file contiene anche 01,02,... in
# corripondeza alla giornata utilizzare anche la 2°,3°,4° e 5° variabile.
\$prima_parte_pos_file_voti = "dati/{$configurazione['cartella_remota']}/MCC";
\$cartella_remota = "{$configurazione['cartella_remota']}";
\$risparmia_risorse = 'NO';
\$num_giornata_file_voti = 'SI';
\$num_giornata_file_voti_doppio = 'SI';
\$seconda_parte_pos_file_voti = '.txt';

# Composizione del file con i dati delle statistiche (dati/file);
\$ncs_codice = 1;
\$ncs_giornata = 2;
\$ncs_nome = 3;
\$ncs_squadra = 4;
\$ncs_attivo = 5;
\$ncs_ruolo = 6;
\$ncs_presenza = 7;
\$ncs_votofc = 8;
\$ncs_mininf25 = 9;
\$ncs_minsup25 = 10;
\$ncs_voto = 11;
\$ncs_golsegnati = 12;
\$ncs_golsubiti = 13;
\$ncs_golvittoria = 14;
\$ncs_golpareggio = 15;
\$ncs_assist = 16;
\$ncs_ammonizione = 17;
\$ncs_espulsione = 18;
\$ncs_rigoretirato = 19;
\$ncs_rigoresubito = 20;
\$ncs_rigoreparato = 21;
\$ncs_rigoresbagliato = 22;
\$ncs_autogol = 23;
\$ncs_entrato = 24;
\$ncs_titolare = 25;
\$ncs_sv = 26;
\$ncs_casa = 27;
\$ncs_valore = 28;
CONTENT;

            $percorso_file = sprintf( "%s/dati_gen.php", $percorso_cartella_dati );
            file_put_contents( $percorso_file, $n_contenuto_dati, LOCK_EX );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il salvataggio del file dati_gen.php", (array)$e );
        }

        return false;
    }
}
