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
use FCBE\Model\UtenteModel;
use FCBE\Util\Flash;
use FCBE\Util\Tornei;
use FCBE\Util\Utenti;

require_once "./controlla_pass.php";
require_once "./inc/funzioni.php";
require_once "./header.php";

global $admin_user, $iscrizione_immediata_utenti;

$tornei = Tornei::getTornei();

if ( isset( $_POST[ 'registra_utente' ] ) ) {
    $inome = strip_tags( $_POST[ 'inome' ] );
    $icognome = strip_tags( $_POST[ 'icognome' ] );
    $iutente = strip_tags( $_POST[ 'iutente' ] );
    $ipass = strip_tags( $_POST[ 'ipass' ] );
    $ipass2 = strip_tags( $_POST[ 'ipass2' ] );
    $ipermessi = $iscrizione_immediata_utenti == 'NO' ? -1 : 0;
    $iemail = strip_tags( $_POST[ 'iemail' ] );
    $iemail2 = strip_tags( $_POST[ 'iemail2' ] );
    $iurl = strip_tags( $_POST[ 'iurl' ] );
    $icitta = strip_tags( $_POST[ 'icitta' ] );
    $isquadra = strip_tags( $_POST[ 'isquadra' ] );
    $itorneo = (int)$_POST[ 'itorneo' ];
    $iserie = 0;
    $icrediti = 0;
    $ivariazioni = 0;
    $icambi = 0;
    $ireg = $_POST[ 'ireg' ];
    $errors = [];

    if ( ! preg_match( "/^[a-z0-9][_\.a-z0-9-]+@([a-z0-9][0-9a-z-]+\.)+([a-z]{2,4})/", $_POST[ 'iemail' ] ) ) {
        $errors[] = "- email non corretta;";
    }

    if ( ! preg_match( "/[a-z']$/i", $_POST[ 'inome' ] ) ) {
        $errors[] = "- Nome non corretto; consentiti caratteri non numerici non accentati (usare l'apostrofo) e nessuno spazio;";
    }

    if ( ! preg_match( "/[a-z' ]$/i", $_POST[ 'icognome' ] ) ) {
        $errors[] = "- Cognome non corretto; consentiti caratteri non numerici non accentati (usare l'apostrofo);";
    }

    if ( ! preg_match( "/^[a-z0-9]{4,12}$/i", $_POST[ 'iutente' ] ) ) {
        $errors[] = "- Username non corretto; consentiti da 4 a 12 caratteri normali, non accentati e nessuno spazio;";
    }

    if ( ! preg_match( "/^[_a-z0-9-]{4,20}$/i", $_POST[ 'isquadra' ] ) ) {
        $errors[] = "- nome squadra non corretto; consentiti da 4 a 18 caratteri normali, non accentati e nessuno spazio;";
    }

    if ( ! preg_match( "/^[a-z0-9]{4,12}$/i", $_POST[ 'ipass' ] ) ) {
        $errors[] = "- password non corretta; consentiti da 4 a 12 caratteri normali, non accentati e nessuno spazio;";
    }

    if ( $ipass !== $ipass2 ) {
        $errors[] = "- le password non coincidono;";
    }

    if ( $iemail !== $iemail2 ) {
        $errors[] = "- gli indirizzi email non coincidono;";
    }

    if ( ! $itorneo ) {
        $errors[] = "- torneo non selezionato;";
    }

    if ( $iutente == $admin_user ) {
        $errors[] = "- nome utente già utilizzato;";
    }

    if ( Utenti::existUtenteInTorneo( $iutente, $itorneo ) ) {
        $errors[] = "- nome utente già utilizzato;";
    }
    if ( Utenti::existEmailInTorneo( $iemail, $itorneo ) ) {
        $errors[] = "- email già utilizzata;";
    }
    if ( Utenti::existSquadraInTorneo( $isquadra, $itorneo ) ) {
        $errors[] = "- nome squadra già utilizzata;";
    }

    if ( empty( $errors ) ) {
        $utente = new UtenteModel();
        $utente->utente = $iutente;
        $utente->pass = $ipass;
        $utente->utente = $iutente;
        $utente->permessi = $ipermessi;
        $utente->email = $iemail;
        $utente->url = $iurl;
        $utente->squadra = $isquadra;
        $utente->torneo = $itorneo;
        $utente->serie = $iserie;
        $utente->citta = $icitta;
        $utente->crediti = $icrediti;
        $utente->variazioni = $ivariazioni;
        $utente->cambi = $icambi;
        $utente->reg = $ireg;
        $utente->nome = $inome;
        $utente->cognome = $icognome;

        if ( Utenti::creaUtente( $utente ) ) {
            Flash::add( "success", "Utente registrato!" );

            echo "<meta http-equiv='refresh' content='0; url=a_aggUtente.php'>";
            exit;
        } else {
            Flash::add( "error", "Errore durante la registrazione dell'utente" );
        }
    }
}
?>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-title text-center my-3 border-bottom">
                        <div class="fs-5">Iscrizione utente</div>
                    </div>
                    <div class="card-body">
                        <?php if ( ! empty( $errors ) ): ?>
                            <div class="alert alert-danger text-center mb-4">
                                <p>
                                    Nei dati immessi nel precedente modulo sono stati riscontrati i seguenti errori:
                                </p>
                                <p class="mb-2">
                                    Si prega di verificare i dati precedentemente immessi, verificando la presenza di eventuali caratteri non consentiti, di compilare i campi richiesti e di inserire le conferme di password e email.
                                </p>

                                <ul class="list-group list-group-flush">
                                    <?php foreach ( $errors as $error ): ?>
                                        <li class="list-group-item list-group-item-danger">
                                            <strong><?php echo $error; ?></strong>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif ?>

                        <form class="row g-3 border-top mt-4" method="post" name="iscrizione" action="./a_aggUtente.php" autocomplete="off">
                            <div class="col-12 col-md-6 col-sm-6">
                                <label for="isquadra" class="form-label">Nome squadra *</label>
                                <input type="text" class="form-control" id="isquadra" name="isquadra" value="<?php echo $isquadra ?? '' ?>" required>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6">
                                <label for="itorneo" class="form-label">Torneo * <small>(<a href="./vedi_tornei.php" target="_blank">Visiona i tornei</a>)</small></label>
                                <select name="itorneo" id="itorneo" class="form-select" required>
                                    <option value="">Scegli il torneo</option>
                                    <?php foreach ( $tornei as $torneo ): ?>
                                        <?php $full = ( $torneo->partecipanti > 0 && $torneo->giocatori_registrati >= $torneo->partecipanti ); ?>
                                        <option <?php echo $torneo->id === ( $itorneo ?? 0 ) ? 'selected' : '' ?> value="<?php echo $torneo->id ?>" <?php echo ! $full ?: "disabled" ?>>
                                            <?php echo $torneo->nome . ( ! $full ?: "( Il torneo è pieno )" ) ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            </div>

                            <div class="col-12 col-md-6 col-sm-6">
                                <label for="inome" class="form-label">Nome *</label>
                                <input type="text" class="form-control" id="inome" name="inome" value="<?php echo $inome ?? '' ?>" required>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6">
                                <label for="icognome" class="form-label">Cognome *</label>
                                <input type="text" class="form-control" id="icognome" name="icognome" value="<?php echo $icognome ?? '' ?>" required>
                            </div>
                            <div class="col-12 col-md-4 col-sm-6">
                                <label for="iutente" class="form-label">Username *</label>
                                <input type="text" class="form-control" id="iutente" name="iutente" value="<?php echo $iutente ?? '' ?>" required>
                            </div>
                            <div class="col-12 col-md-4 col-sm-6">
                                <label for="ipass" class="form-label">Password *</label>
                                <input type="password" class="form-control" id="ipass" name="ipass" required>
                            </div>
                            <div class="col-12 col-md-4 col-sm-6">
                                <label for="ipass2" class="form-label">Conferma password *</label>
                                <input type="password" class="form-control" id="ipass2" name="ipass2" required>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6">
                                <label for="iemail" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="iemail" name="iemail" value="<?php echo $iemail ?? '' ?>" required>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6">
                                <label for="iemail2" class="form-label">Ripeti email *</label>
                                <input type="email" class="form-control" id="iemail2" name="iemail2" value="<?php echo $iemail2 ?? '' ?>" required>
                            </div>
                            <div class="col-12 col-md-4 col-sm-6">
                                <label for="iurl" class="form-label">Sito web</label>
                                <input type="url" class="form-control" id="iurl" name="iurl" value="<?php echo $iurl ?? '' ?>">
                            </div>
                            <div class="col-12 col-md-4 col-sm-6">
                                <label for="icitta" class="form-label">Città</label>
                                <input type="text" class="form-control" id="icitta" name="icitta" value="<?php echo $icitta ?? '' ?>">
                            </div>

                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="registra_utente">Registra utente</button>
                            </div>

                            <input type="hidden" name="ireg" value="<?php echo date( "d.m.Y H:i:s" ); ?>"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "./footer.php";
