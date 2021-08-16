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
##################################################################################
session_start();

# nel caso fosse settato register_globals = Off
reset( $_POST );
$conta = count( $_POST );
for ( $num1 = 0; $num1 < $conta; $num1++ ) {
    $var_POST = key( $_POST );
    $$var_POST = $_POST[ $var_POST ];
    next( $_POST );
} # fine for $num1

reset( $_GET );
$conta = count( $_GET );
for ( $num1 = 0; $num1 < $conta; $num1++ ) {
    $var_GET = key( $_GET );
    $$var_GET = strip_tags( $_GET[ $var_GET ] );
    next( $_GET );
} # fine for $num1

header( "Cache-control: private" );
require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";
require_once "./header.php";
?>

<div class="contenuto">
    <div id="articoli">
        <div id="sinistra">
            <div class="articoli_s">

                <?php
                if ( $usa_cms == "SI" && isset( $_GET[ 'paginaid' ] ) && strip_tags( $_GET[ 'paginaid' ] ) ) {
                    pagina( strip_tags( $_GET[ 'paginaid' ] ) );
                } elseif ( $usa_cms == "SI" && isset( $_GET[ 'categoria' ] ) && strip_tags( $_GET[ 'categoria' ] ) ) {
                    categoria( $_GET[ 'categoria' ] );
                } elseif ( $usa_cms == "SI" && isset( $_GET[ 'notiziaid' ] ) && strip_tags( $_GET[ 'notiziaid' ] ) ) {
                    notizia( $_GET[ 'notiziaid' ], strip_tags( htmlentities( ($evidenzia ?? '') ) ) );
                } elseif ( $usa_cms == "SI" && isset( $ricerca ) && strip_tags( $ricerca ) ) {
                    ricerca( strip_tags( htmlentities( $testo ) ) );
                } elseif ( $usa_cms == "SI" and $vedi_notizie >= 1 ) {
                    echo "<p style='float: left; margin: 10; padding-right: 10px;'>";
                    if ( $mostra_gall_index == "SI" )
                        immagine_casuale( 'sx', 0, 0 );
                    echo "</p>" . $acapo;

                    if ( trim( $messaggi[ 1 ] ) != "" )
                        echo "<div class='slogan'>" . html_entity_decode( $messaggi[ 1 ] ) . "</div><div style='clear:both;'>&nbsp;</div>" . $acapo;

                    if ( trim( $messaggi[ 3 ] ) or trim( $messaggi[ 4 ] ) )
                        echo "<div>" . $acapo;
                    if ( trim( $messaggi[ 3 ] ) != "" )
                        echo "<div class='box1'>" . html_entity_decode( $messaggi[ 3 ] ) . "</div>" . $acapo;
                    if ( trim( $messaggi[ 4 ] ) != "" )
                        echo "<div class='box2'>" . html_entity_decode( $messaggi[ 4 ] ) . "</div>" . $acapo;
                    if ( trim( $messaggi[ 3 ] ) or trim( $messaggi[ 4 ] ) )
                        echo "</div>" . $acapo;

                    echo "<div style='clear:both;'>&nbsp;</div>" . $acapo;
                    notizie();
                } elseif ( trim( $messaggi[ 1 ] ) != "" ) {
                    echo "<p style='float: left; margin: 10; padding-right: 10px;'>";
                    immagine_casuale( 'sx', 0, 0 );
                    echo "</p>" . $acapo;

                    if ( trim( $messaggi[ 1 ] ) != "" )
                        echo "<div class='slogan'>" . html_entity_decode( $messaggi[ 1 ] ) . "</div><div style='clear:both;'>&nbsp;</div>" . $acapo;

                    if ( trim( $messaggi[ 3 ] ) or trim( $messaggi[ 4 ] ) )
                        echo "<div>" . $acapo;
                    if ( trim( $messaggi[ 3 ] ) != "" )
                        echo "<div class='box1'>" . html_entity_decode( $messaggi[ 3 ] ) . "</div>" . $acapo;
                    if ( trim( $messaggi[ 4 ] ) != "" )
                        echo "<div class='box2'>" . html_entity_decode( $messaggi[ 4 ] ) . "</div>" . $acapo;
                    if ( trim( $messaggi[ 3 ] ) or trim( $messaggi[ 4 ] ) )
                        echo "</div>" . $acapo;

                    echo "<div style='clear:both;'>&nbsp;</div>" . $acapo;
                } else {
                    echo "<p style='float: left; margin: 0; padding-right: 10px;'>";
                    immagine_casuale( 'sx', 0, 0 );
                    echo "</p>.$acapo";
                    if ( trim( $messaggi[ 3 ] ) or trim( $messaggi[ 4 ] ) )
                        echo "<div>" . $acapo;
                    if ( trim( $messaggi[ 3 ] ) != "" )
                        echo "<div class='box1'>" . html_entity_decode( $messaggi[ 3 ] ) . "</div>" . $acapo;
                    if ( trim( $messaggi[ 4 ] ) != "" )
                        echo "<div class='box2'>" . html_entity_decode( $messaggi[ 4 ] ) . "</div>" . $acapo;
                    if ( trim( $messaggi[ 3 ] ) or trim( $messaggi[ 4 ] ) )
                        echo "</div>" . $acapo;

                    echo "<div style='clear:both;'>&nbsp;</div>" . $acapo;
                }

                echo "</div>
</div>
<div id='destra'>";
                include( "./menu_i.php" );
                echo "</div>";
                ?>
            </div>
            <?php
            include( "./footer.php" );
            ?>
