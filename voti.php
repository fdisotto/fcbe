<?php
##################################################################################
#    FANTACALCIOBAZAR
#    Copyright (C) 2003-2007 by Antonello Onida (fantacalciobazar@sssr.it)
#    Copyright (C) 2001-2002 by Marco Maria Francesco De Santis (marcods@gmx.net)
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

use FCBE\Enum\RuoloEnum;
use FCBE\Util\Calciatori;
use FCBE\Util\Utenti;

require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

global $prima_parte_pos_file_voti, $seconda_parte_pos_file_voti;

$giornata = (int)$_GET[ 'v_giornata' ];
$ruolo = $_GET[ 'v_ruolo' ];

$calciatori = Calciatori::getCalciatoriGiornata( $giornata );
?>

    <div id="page-content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <h1 class="text-center">Voti della giornata <?php echo $giornata ?></h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="voti-datatable" data-page-length="100">
                            <thead>
                            <tr>
                                <th class="text-start">Num.</th>
                                <th class="text-start">Nome</th>
                                <th class="text-start">Ruolo</th>
                                <th class="text-start">Voto</th>
                                <th class="text-start">Voto FC</th>
                                <th class="text-start">Valore</th>
                                <th class="text-start">Squadra</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ( $calciatori as $calciatore ): ?>
                                <?php if ( $calciatore->ruolo === $ruolo || strtolower( $ruolo ) === "tutti" ): ?>
                                    <tr>
                                        <td>
                                            <a href="./stat_calciatore.php?num_calciatore=<?php echo $calciatore->codice ?>">
                                                <?php echo $calciatore->codice ?>
                                            </a>
                                        </td>
                                        <td><?php echo $calciatore->nome ?></td>
                                        <td><?php echo RuoloEnum::RUOLI_EXT[ $calciatore->ruolo ] ?></td>
                                        <td><?php echo $calciatore->voto ?></td>
                                        <td><?php echo $calciatore->voto_fc ?></td>
                                        <td><?php echo $calciatore->valore ?></td>
                                        <td><?php echo $calciatore->squadra ?></td>
                                    </tr>
                                <?php endif ?>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "./footer.php";
