<?php
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003-2008 by Antonello Onida
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

    if ( isset( $_POST[ 'fdc' ] ) ) {
        echo "file da creare: $fdc";
    }

    if ( isset( $scrivi ) && $scrivi == "SI" ) {
        $fpc = fopen( $fdc, "a+" );
        fclose( $fpc );
        echo "File $fdc creato</h1>";
    }

    $oggetto_da_controllare = array();
    $oggetto_da_controllare[] = $percorso_cartella_dati;
    $oggetto_da_controllare[] = $percorso_cartella_dati . "/messaggi";
    $oggetto_da_controllare[] = $percorso_cartella_dati . "/cache";
    $oggetto_da_controllare[] = $percorso_cartella_dati . "/copia";
    $oggetto_da_controllare[] = $dir_immagini;
    $oggetto_da_controllare[] = $percorso_cartella_dati . "/dati_gen.php";
    $oggetto_da_controllare[] = $percorso_cartella_dati . "/tornei.php";
    $oggetto_da_controllare[] = $percorso_cartella_dati . "/testi.php";
    $oggetto_da_controllare[] = $percorso_cartella_dati . "/db10.txt";
    $conta = 0;

    echo "<table width='100%' cellpadding='5' cellspacing='0' bgcolor='$sfondo_tab'>
	<caption>
	Verifica installazione
	</caption>
	<tr>
	<th width='50%' scope='col'>Descrizione</th>
	<th width='20%' scope='col'>Stato</th>
	<th scope='col'>Azione</th>
	</tr>";

    foreach ( $oggetto_da_controllare as $controllo ) {
        $ef = 0;
        $ep = 0;
        if ( $conta % 2 )
            $colore = "#FFFFFF"; else $colore = "$colore_riga_alt";

        echo "<tr bgcolor=$colore>
		<td width='50%'>Verifica permessi cartella: <b>$controllo</b></td>
		<td width='20%' align='center'>";

        if ( is_dir( $controllo ) ) {
            echo "<b><font color='green'>cartella trovata</font></b><br/>";
        } elseif ( is_file( $controllo ) ) {
            echo "<b><font color='green'>file trovato</font></b><br/>";
        } elseif ( ! is_file( $controllo ) ) {
            echo "<font color='red'>file non trovato</font><br/>";
            $errore[] = "<u>$controllo</u>: crea il file <b>$controllo</b>!";
            $ef = 1;
        } else echo "<b><font color='green'>cartella non presente</font></b><br/>";

        if ( @is_writable( $controllo ) ) {
            echo "<font color='green'>scrivibile</font>&nbsp;";
        } else {
            echo "<b><font color='red'>non scrivibile</font></b>&nbsp;";
            $errore[] = "<u>$controllo</u>: permessi di scrittura non corretti!";
            $ep = 1;
        }

        if ( @is_readable( $controllo ) ) {
            echo "<font color='green'>leggibile</font>&nbsp;";
        } else {
            echo "<b><font color='red'>non leggibile</font></b>&nbsp;";
            $errore[] = "<u>$controllo</u>: permessi di lettura non corretti!";
            $ep = 1;
        }

        if ( $ef == 1 ) {
            $azione = "<form method='post' action='a_verifiche.php'>
            <input type='hidden' name='fdc' value='$controllo'>
            <input type='hidden' name='scrivi' value='SI'>
            <input type='submit' value='Crea file $controllo'>	
            </form>";
        } elseif ( $ep == 1 ) {
        } else $azione = "&nbsp;";

        echo "</td><td>$azione</td></tr>";
        $conta++;
    }

    echo "<tr><td>";

    echo "<p align='left'>";
    echo "Creazione URL sito: http://" . $_SERVER[ 'HTTP_HOST' ] . dirname( $_SERVER[ 'PHP_SELF' ] );
    echo "</p>";
    echo "<p align='left'>";
    echo "Creazione path assoluto sito: " . $_SERVER[ 'DOCUMENT_ROOT' ] . dirname( $_SERVER[ 'PHP_SELF' ] );
    echo "</p>";

    $mcg = '';
    if ( $chiusura_giornata == 1 ) {
        $mcg = "<b style='color:red'>La procedura si &egrave; messa in chiusura giornata</b>.";
    }

    echo "<p align='left'>Data attuale: " . ( $data_attuale ?? date( 'd-m-Y' ) ) . "<br/>Data chiusura giornata: " . ( $verdatachiusura ?? '' ) . "<br/>Chiusura Giornata: $chiusura_giornata - $mcg</p>";

    if ( $vedi_notizie == 0 ) {
        echo "<p align='left'>";
        echo "Le notizie in prima pagina sono disattivate";
        echo "</p>";
        notizie();
    }

    if ( isset( $errore ) ) {
        $errori = implode( "<br />", $errore );
    }
    if ( isset( $errori ) ) {
        echo "<p align='left'>$errori</p>";
    }

    pr( $_SESSION );

    ob_start();
    phpinfo();
    $phpinfo = ob_get_contents();
    ob_end_clean();
    $phpinfo = preg_replace( '%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo );

    echo "
    <style type='text/css'>
        #phpinfo {}
        #phpinfo pre {margin: 0; font-family: monospace;}
        #phpinfo a:link {color: #009; text-decoration: none; background-color: #fff;}
        #phpinfo a:hover {text-decoration: underline;}
        #phpinfo table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
        #phpinfo .center {text-align: center;}
        #phpinfo .center table {margin: 1em auto; text-align: left;}
        #phpinfo .center th {text-align: center !important;}
        #phpinfo td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
        #phpinfo h1 {font-size: 150%;}
        #phpinfo h2 {font-size: 125%;}
        #phpinfo .p {text-align: left;}
        #phpinfo .e {background-color: #ccf; width: 300px; font-weight: bold;}
        #phpinfo .h {background-color: #99c; font-weight: bold;}
        #phpinfo .v {background-color: #ddd; max-width: 300px; overflow-x: auto; word-wrap: break-word;}
        #phpinfo .v i {color: #999;}
        #phpinfo img {float: right; border: 0;}
        #phpinfo hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
    </style>
    <div id='phpinfo'>
        $phpinfo
    </div>
    ";

    echo "</td></tr></table>";
} # fine if ($_SESSION valido)
else {
    header( "location: logout.php?logout=2" );
}
require_once "./footer.php";
