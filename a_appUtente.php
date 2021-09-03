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
use FCBE\Util\Flash;
use FCBE\Util\Tornei;
use FCBE\Util\Utenti;

require_once "./controlla_pass.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

if ( ! Utenti::isAdminLogged() ) {
    header( "location: logout.php?logout=2" );
}

$tornei = Tornei::getTornei();

if ( isset( $_POST[ 'approva_utente' ] ) ) {
    $id_utente = (int)$_POST[ 'utente' ];
    $id_torneo = (int)$_POST[ 'torneo' ];
    if ( Utenti::approva( $id_utente, $id_torneo ) ) {
        Flash::add( "success", "Utente approvato!" );
    } else {
        Flash::add( "error", "Errore durante l'approvazione dell'utente" );
    }

    echo "<meta http-equiv='refresh' content='0; url=a_appUtente.php'>";
    exit;
}
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-title text-center my-3 border-bottom">
                        <div class="fs-5">Approvazione utenti</div>
                    </div>
                    <div class="card-body">
                        <?php foreach ( $tornei as $torneo ): ?>
                            <table class="table table-condensed table-striped caption-top mb-5">
                                <caption>Torneo: <?php echo $torneo->nome ?></caption>
                                <thead>
                                <tr>
                                    <th scope="col">Utente</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Squadra</th>
                                    <th scope="col"></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ( Utenti::getUtentiInTorneo( $torneo->id ) as $utente ): ?>
                                    <?php if ( $utente->permessi <= -1 ): ?>
                                        <tr>
                                            <td><?php echo $utente->username ?></td>
                                            <td><?php echo $utente->email ?></td>
                                            <td><?php echo $utente->squadra ?></td>
                                            <td>
                                                <a class="btn btn-info btn-sm text-white" data-bs-toggle="collapse" href="#utente-<?php echo $utente->username ?>" role="button" aria-expanded="false" aria-controls="utente-<?php echo $utente->username ?>">
                                                    <i class="fa fa-eye"></i> Vedi
                                                </a>

                                                <form method="post" action="./a_appUtente.php" class="d-inline">
                                                    <input type="hidden" name="utente" value="<?php echo $utente->id ?>">
                                                    <input type="hidden" name="torneo" value="<?php echo $utente->torneo ?>">
                                                    <button type="submit" name="approva_utente" class="btn btn-success btn-sm text-white">
                                                        <i class="fa fa-check"></i> Approva
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="utente-<?php echo $utente->username ?>">
                                            <td colspan="4">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Username</th>
                                                        <th>Squadra</th>
                                                        <th>Torneo</th>
                                                        <th>Serie</th>
                                                        <th>Email</th>
                                                        <th>Sito web</th>
                                                        <th>Città</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><?php echo $utente->username ?></td>
                                                        <td><?php echo $utente->squadra ?></td>
                                                        <td>
                                                            <?php echo $torneo->nome ?> (ID: <?php echo $utente->torneo ?>)
                                                        </td>
                                                        <td><?php echo $utente->serie ?></td>
                                                        <td><?php echo $utente->email ?></td>
                                                        <td><?php echo $utente->url ?></td>
                                                        <td><?php echo $utente->citta ?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "./footer.php";
