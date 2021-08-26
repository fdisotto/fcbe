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

require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

global $messaggi, $vedi_notizie;
?>

    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8">
                <?php if ( isset( $_GET[ 'paginaid' ] ) ): ?>
                    <?php echo pagina( $_GET[ 'paginaid' ] ); ?>
                <?php elseif ( isset( $_GET[ 'categoria' ] ) ): ?>
                    <?php echo categoria( $_GET[ 'categoria' ] ); ?>
                <?php elseif ( isset( $_GET[ 'notiziaid' ] ) ): ?>
                    <?php echo notizia( $_GET[ 'notiziaid' ], $evidenzia ?? '' ); ?>
                <?php else: ?>
                    <?php if ( ! empty( trim( $messaggi[ 1 ] ) ) ): ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="card-text">
                                    <?php echo html_entity_decode( $messaggi[ 1 ] ) ?>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if ( ! empty( trim( $messaggi[ 3 ] ) ) || ! empty( trim( $messaggi[ 4 ] ) ) ): ?>
                        <div class="row mt-4">
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-text">
                                            <?php echo html_entity_decode( $messaggi[ 3 ] ) ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-text">
                                            <?php echo html_entity_decode( $messaggi[ 4 ] ) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endif ?>
                    <?php if ( $vedi_notizie >= 1 ): ?>
                        <?php notizie(); ?>
                    <?php endif ?>
                <?php endif ?>
            </div>

            <div class="col-12 col-md-4">
                <?php require_once "./menu_i.php"; ?>
            </div>
        </div>
    </div>
<?php
require_once "./footer.php";
