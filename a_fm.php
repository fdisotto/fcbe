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
$a_fm = "SI"; # Controllo in header per il caricamento del CSS relativo
require_once "./controlla_pass.php";
require_once "./header.php";

if ( $_SESSION[ 'valido' ] == "SI" and $_SESSION[ 'permessi' ] = 5 ) {
    require_once "./a_menu.php";
    require_once "./inc/fm_class.php";

    // Aggiungere il nome dei files in questo array da proteggere
    // dalle opzioni di scrittura, rinomina, modifica, etc.
    // I nomi devono essere dentro apici e separati da una virgola.
    $protected_files = array();

    // Crea una istanza di DirPHP.
    $dirphp = new DirPHP( "d/m/y", $protected_files, $header ?? '', $footer ?? '' );

    // Questa è la password di protesione.
    // La password di default è 'default'.
    // E' inclusa una utility per la generazione in 'inc/make_hash.php'.
    $dirphp->security[ 'hash' ] = "c21f969b5f03d33d43e04f8f136e7682";

    // Questa funzione fa tutto il lavoro
    echo "<div class='dirphp'>";
    $dirphp->handle_events();
    echo "</div>";
} else {
    header( "location: logout.php?logout=2" );
}

require_once "./footer.php";
