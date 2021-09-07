<?php

use FCBE\Util\File;
use FCBE\Util\Flash;
use FCBE\Util\Response;
use FCBE\Util\Utenti;

require_once "./controlla_pass.php";
require_once "./header.php";

if ( ! Utenti::isAdminLogged() ) {
    header( "location: logout.php?logout=2" );
}

global $percorso_cartella_dati;

$nome_file_backup = "./backup/copia.zip";

$action = $_GET[ 'action' ] ?? '';

if ( ! empty( $action ) ) {
    if ( $action === "crea" ) {
        if ( File::creaZip( $nome_file_backup, $percorso_cartella_dati ) ) {
            Flash::add( "success", "Backup creato con successo!" );
        } else {
            Flash::add( "error", "Errore durante la creazione del backup!" );
        }
    } elseif ( $action === "cancella" ) {
        if ( File::delete( $nome_file_backup ) ) {
            Flash::add( "success", "Backup eliminato con successo!" );
        } else {
            Flash::add( "error", "Errore durante l'eliminazione del backup!" );
        }
    } elseif ( $action === "estrai" ) {
        if ( File::estraiZip( ".", $nome_file_backup ) ) {
            Flash::add( "success", "Estrazione completata!" );
        } else {
            Flash::add( "error", "Errore durante l'estrazione!" );
        }
    }

    Response::redirect( $_SERVER[ 'PHP_SELF' ] );
}
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-title text-center my-3 border-bottom">
                        <div class="fs-5">Backup cartella dati</div>
                    </div>

                    <div class="card-body text-center">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-6">
                                <?php if ( File::exist( $nome_file_backup ) ): ?>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <a href="<?php echo $nome_file_backup ?>" download="copia.zip">
                                                <i class="fa fa-cloud-download"></i> Scarica Backup
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            Creato il:
                                            <?php echo date( "d F Y H:i:s ", filemtime( $nome_file_backup ) ) ?>
                                        </li>
                                        <li class="list-group-item">
                                            Peso file:
                                            <?php echo File::bytesInKB( filesize( $nome_file_backup ) ) ?> Kib.
                                        </li>
                                        <li class="list-group-item">
                                            <a href="<?php echo $_SERVER[ 'PHP_SELF' ] ?>?action=crea" class="btn btn-primary">Aggiorna</a>
                                            <a href="<?php echo $_SERVER[ 'PHP_SELF' ] ?>?action=estrai" class="btn btn-primary">Estrai</a>
                                            <a href="<?php echo $_SERVER[ 'PHP_SELF' ] ?>?action=cancella" class="btn btn-primary">Cancella</a>
                                        </li>
                                    </ul>
                                <?php else: ?>
                                    <a href="<?php echo $_SERVER[ 'PHP_SELF' ] ?>?action=crea" class="btn btn-primary">Crea backup</a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "./footer.php";
