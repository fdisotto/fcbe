<?PHP
##################################################################################
#    FANTACALCIOBAZAR EVOLUTION
#    Copyright (C) 2003 - 2009 by Antonello Onida
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
use FCBE\Enum\StatoGiornata;
use FCBE\Util\Giornata;
use FCBE\Util\Updater;
use FCBE\Util\Utenti;
use FCBE\Util\Voti;

require_once "./controlla_pass.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

global $cartella_remota;

if ( ! Utenti::isAdminLogged() ) {
    header( "location: logout.php?logout=2" );
}

Updater::check();

$giornata_prossima = Giornata::getProssima();
$giornata_corrente = Giornata::getCorrente();

$status_update = [];
// Scarica il file calciatori.txt dal repository
if ( isset( $_POST[ 'carica_calciatori' ] ) ) {
    if ( Updater::saveCalciatori() ) {
        $status_update = [
            "status"  => true,
            "message" => "File calciatori.txt aggiornato con successo!",
        ];
    } else {
        $status_update = [
            "status"  => false,
            "message" => "Errore durante la copia del file calciatori.txt!",
        ];
    }
} elseif ( isset( $_POST[ 'preleva_voti' ] ) ) {
    if ( Updater::saveGiornata( $giornata_prossima ) ) {
        $status_update = [
            "status"  => true,
            "message" => "File MCC$giornata_prossima.txt salvato con successo!!",
        ];
    } else {
        $status_update = [
            "status"  => false,
            "message" => "Errore durante la copia del file MCC$giornata_prossima.txt",
        ];
    }
} elseif ( isset( $_POST[ 'cambia_data' ] ) ) {
    $data = new DateTime( $_POST[ 'chiusura_giornata_date' ] );
    if ( Giornata::saveChiusuraGiornata( $data ) ) {
        $status_update = [
            "status"  => true,
            "message" => "Cambio data effettuato!",
        ];
    } else {
        $status_update = [
            "status"  => false,
            "message" => "Errore durante il cambio data!",
        ];
    }
} elseif ( isset( $_POST[ 'chiudi_giornata' ] ) ) {
    if ( Giornata::chiudiGiornata() ) {
        $status_update = [
            "status"  => true,
            "message" => "Giornata chiusa!",
        ];
    } else {
        $status_update = [
            "status"  => false,
            "message" => "Errore durante la chiusura della giornata!",
        ];
    }
} elseif ( isset( $_POST[ 'apri_giornata' ] ) ) {
    if ( Giornata::apriGiornata() ) {
        $status_update = [
            "status"  => true,
            "message" => "Giornata aperta!",
        ];
    } else {
        $status_update = [
            "status"  => false,
            "message" => "Errore durante l'apertura della giornata!",
        ];
    }
}

$giornate_giocate = Giornata::getGiornateGiocate();
$calciatori_info = Updater::getCalciatoriInfo();
$giornata_prossima_info = Updater::getGiornataInfo( $giornata_prossima );
$giornata_corrente_info = Updater::getGiornataInfo( $giornata_corrente );
$stato_giornata = Giornata::getStatoGiornata();
$status_giornata = StatoGiornata::STATO_EXT[ $stato_giornata ];
$chiusura_giornata = Giornata::getChiusuraGiornata();
$data_chiusura_giornata = date( "d-m-Y", strtotime( $chiusura_giornata ) );
$ora_chiusura_giornata = date( "H:i", strtotime( $chiusura_giornata ) );
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php if ( ! empty( $status_update ) ): ?>
                    <div class="alert alert-<?php echo $status_update[ 'status' ] ? 'info' : 'danger' ?> text-center">
                        <?php echo $status_update[ 'message' ] ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-title text-center my-3 border-bottom">
                        <div class="fs-5">Giornate</div>
                    </div>
                    <div class="card-body">
                        <?php foreach ( $giornate_giocate as $giornata ): ?>
                            <a href="a_giornata.php?num_giornata=<?php echo $giornata ?>" type="button" class="badge p-2 bg-dark text-white">
                                <?php echo $giornata ?>
                            </a>
                        <?php endforeach ?>

                        <hr>

                        <p class="text-center">
                            Cartella voti remota: <strong><?php echo $cartella_remota ?></strong>
                        </p>

                        <?php if ( $calciatori_info[ 'url' ] && $calciatori_info[ 'remote' ] > $calciatori_info[ 'local' ] ): ?>
                            <div class="alert alert-info text-center">
                                E' disponibile un aggiornamento del file <strong>calciatori.txt</strong>
                            </div>
                        <?php endif ?>

                        <?php if ( $giornata_corrente_info[ 'url' ] && $giornata_corrente_info[ 'remote' ] > $giornata_corrente_info[ 'local' ] ): ?>
                            <div class="alert alert-info text-center">
                                E' disponibile un aggiornamento del file <strong>MCC<?php echo $giornata_corrente ?>.txt</strong>
                            </div>
                        <?php endif ?>

                        <div class="row">
                            <div class="col-12 col-md-4">
                                <form method='post' action='./a_gestione.php'>
                                    <input type="submit" class="btn btn-primary" name="preleva_voti" <?php echo Voti::getFileVoti( $giornata_prossima ) ? "disabled" : "" ?> value="Preleva MCC<?php echo $giornata_prossima ?>.txt"/>
                                </form>
                            </div>
                            <div class="col-12 col-md-4">
                                <form method='post' action='./a_crea_giornata.php'>
                                    <input type="hidden" name="giornata" value="<?php echo $giornata_prossima ?>"/>
                                    <input type="submit" class="btn btn-primary" name="crea_giornata" <?php echo empty( Voti::getFileVoti( $giornata_prossima ) ) ? "disabled" : "" ?> value="Crea la giornata <?php echo $giornata_prossima ?>"/>
                                </form>
                            </div>

                            <?php if ( (int)$giornata_corrente <= 0 ): ?>
                                <div class="col-12 col-md-4">
                                    <form method='post' action='./a_gestione.php'>
                                        <input type="submit" class="btn btn-primary" name="carica_calciatori" <?php echo empty( $calciatori_info[ 'url' ] ) || ( $calciatori_info[ 'remote' ] <= $calciatori_info[ 'local' ] ) ? "disabled" : "" ?> value="Carica calciatori.txt"/>
                                    </form>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-title text-center my-3 border-bottom">
                        <div class="fs-5">Chiusura giornata</div>
                    </div>
                    <div class="card-body">
                        <p class="text-center">
                            Stato giornata: <span class="badge <?php echo $stato_giornata === StatoGiornata::APERTA ? 'bg-success' : 'bg-danger' ?> sf-6"><?php echo $status_giornata ?></span>
                        </p>

                        <p class="text-center">
                            La prossima chiusura automatica è fissata per il giorno:<br>
                            <strong><?php echo $data_chiusura_giornata ?></strong> alle ore <strong><?php echo $ora_chiusura_giornata ?></strong>
                        </p>

                        <div class="text-center">
                            <?php if ( $stato_giornata == StatoGiornata::CHIUSA ): ?>
                                <form method="post" action="./a_gestione.php">
                                    <input type="submit" name="apri_giornata" value="Apri giornata" class="btn btn-success"/>
                                </form>
                            <?php else: ?>
                                <form method="post" action="./a_gestione.php">
                                    <input type="submit" name="chiudi_giornata" value="Chiudi giornata" class="btn btn-danger"/>
                                </form>
                            <?php endif ?>
                        </div>

                        <div class="mt-3 text-center">
                            <form action="./a_gestione.php" method="post">
                                <label for="chiusura_giornata_date"></label>
                                <input id="chiusura_giornata_date" name="chiusura_giornata_date" type="text" value="<?php echo date( "d-m-Y H:i", strtotime( $chiusura_giornata ) ) ?>">

                                <button type="submit" class="btn btn-primary mt-3" name="cambia_data">Cambia data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-title text-center my-3 border-bottom">
                        <div class="fs-5">Statistiche</div>
                    </div>
                    <div class="card-body">
                        <?php require_once './inc/online.php' ?>
                        <?php require_once './inc/flount.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "./footer.php";
