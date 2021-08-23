<?PHP
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

if ( $_SESSION[ 'valido' ] == "SI" and $_SESSION[ 'permessi' ] >= 4 ) {
    require_once "./a_menu.php";
    $path = preg_replace( "/a_upload.php/", $uploaddir . "/", $_SERVER[ "SCRIPT_FILENAME" ] );

    if ( ! is_writable( $uploaddir ) )
        echo "La cartella $uploaddir non &egrave; scrivibile!<br /> Impostare CHMOD 775.<br />";
    if ( ! is_readable( $uploaddir ) )
        echo "La cartella $uploaddir non &egrave; leggibile!<br /> Impostare CHMOD 775.<br />";

    if ( ! isset( $funz ) ) {
        $funz = "uno";
    }

    switch ( $funz ) {
        case 'uno':
            echo "<table width='100%' align='center' class='border' cellpadding='10' bgcolor='$sfondo_tab'>
	        <caption>Funzione upload file voti</caption>
	        <tr valign ='top'><td align='center'><br/><br/>Tramite questa funzione viene caricato il file <br/>nella cartella <b>$path</b>.<br/><br/>";
            echo "<form method='post' enctype='multipart/form-data' action='a_upload.php'>";
            echo "<input type='file' name='filevoti' size='30' />";
            echo "<input type='hidden' name='MAX_FILE_SIZE' value='100000' />";
            echo "<input type='hidden' name='funz' value='due' />";
            echo "<br/><br/><input type='submit' value='UPLOAD' /><br/><br/></td></tr></table>";
            break;
        case 'due':
            if ( $_FILES[ 'filevoti' ] ) {
                echo "<table width='100%' align='center' class='border' cellpadding='10' bgcolor='$sfondo_tab'>
				<caption>Funzione upload file voti</caption><tr><td align='left'><pre>";
                if ( move_uploaded_file( $_FILES[ 'filevoti' ][ 'tmp_name' ], $path . $_FILES[ 'filevoti' ][ 'name' ] ) ) {
                    echo "Il file &egrave; valido, e inviato con successo.  Ecco alcune informazioni:\n";
                    if ( @chmod( $path . $_FILES[ 'filevoti' ][ 'name' ], 0664 ) ) {
                        echo "CHMOD 644 impostato!<br />";
                    }
                } else {
                    echo "Possibile attacco tramite file upload! Alcune informazioni:\n";
                }
                print_r( $_FILES );
                echo "</pre></td></tr></table>";
            } else echo "Il campo file &egrave; vuoto; ritenta!";
    }
} # fine if ($_SESSION == "SI")
else header( "location: logout.php?logout=2" );
include( "./footer.php" );
?>
