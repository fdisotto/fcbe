<?PHP

use FCBE\Util\File;
use FCBE\Util\Flash;
use FCBE\Util\Response;
use FCBE\Util\Utenti;

require_once "./controlla_pass.php";
require_once "./header.php";

if ( ! Utenti::isAdminLogged() ) {
    header( "location: logout.php?logout=2" );
}

global $uploaddir;

if ( isset( $_POST[ 'upload_voti' ] ) && isset( $_FILES[ 'file_voti' ] ) ) {
    $file = $_FILES[ 'file_voti' ];

    if ( $file[ 'type' ] !== "text/plain" ) {
        Flash::add( "error", "Il file deve essere un file di testo!" );
    } else {
        if ( File::move( $file[ 'tmp_name' ], rtrim( $uploaddir, "/" ) . "/" . $file[ 'name' ] ) )
            Flash::add( "success", "File caricato con successo!" );
    }

    Response::redirect( $_SERVER[ 'REQUEST_URI' ] );
}
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-title text-center my-3 border-bottom">
                        <div class="fs-5">Upload file voti</div>
                    </div>

                    <div class="card-body text-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12 col-md-6">
                                <form method="post" enctype="multipart/form-data" action="a_upload.php">
                                    <div class="mb-3">
                                        <label for="file_voti" class="form-label">
                                            Tramite questa funzione viene caricato il file nella cartella <strong><?php echo $uploaddir ?></strong>.
                                        </label>
                                        <input class="form-control" type="file" id="file_voti" name="file_voti" required>
                                    </div>

                                    <div>
                                        <button class="btn btn-primary" type="submit" name="upload_voti">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "./footer.php";
