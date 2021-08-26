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

use FCBE\Util\Giornate;
use FCBE\Util\Utenti;
use FCBE\Util\Tornei;

require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";

global $messaggi, $percorso_cartella_dati, $iscrizione_online, $vedi_notizie, $attiva_rss, $mostra_voti_in_login, $considera_fantasisti_come;

$login_error = "";

if ( isset( $_GET[ 'fallito' ] ) ) {
    switch ( (int)$_GET[ 'fallito' ] ) {
        case 1:
            $login_error = "Username o password errati o mancanti!";
            break;
        case 2:
            $login_error = "Password amministratore errata.\nE' stata inviata una mail di notifica.";
            break;
        case 3:
            $login_error = "Scegli il torneo dal menù a tendina";
            break;
    }
} elseif ( isset( $_GET[ 'nofile' ] ) ) {
    $login_error = "Database utenti non trovato!";
} elseif ( isset( $_GET[ 'logout' ] ) ) {
    switch ( $_GET[ 'logout' ] ) {
        case 1:
            $login_error = "Disconnesso!";
            break;
        case 2:
            $login_error = "Accesso riservato!";
            break;
        case 3:
            $login_error = "Rieseguire l'accesso";
            break;
    }
} elseif ( isset( $_GET[ 'nuovo' ] ) ) {
    $login_error = "Connesso!";
} elseif ( isset( $_GET[ 'iscritto' ] ) ) {
    $login_error = "Utente iscritto! Email inviata!";
} elseif ( isset( $_GET[ 'attesa' ] ) ) {
    $login_error = "Utente in attesa di autorizzazione!";
}
?>

<?php if ( ! empty( trim( $messaggi[ 5 ] ) ) ): ?>
    <div class="card mb-4">
        <div class="card-body">
            <p class="card-text">
                <?php echo html_entity_decode( $messaggi[ 5 ] ) ?>
            </p>
        </div>
    </div>
<?php endif ?>

<nav class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column bg-dark">
    <ul class="nav flex-column text-white">
        <?php foreach ( link_pagine_box() as $pagina ): ?>
            <li class="nav-item border-bottom">
                <a href="./index.php?paginaid=<?php echo $pagina[ 'id' ] ?>" class="nav-link text-white">
                    <i class="fa fa-chevron-right"></i>
                    <span class="ms-3">
                        <?php echo $pagina[ 'title' ] ?>
                    </span>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ( $iscrizione_online == "SI" ): ?>
            <li class="nav-item border-bottom">
                <a href="./iscrizione.php" class="nav-link text-white">
                    <i class="fa fa-chevron-right"></i>
                    <span class="ms-3">
                        Iscrizione
                    </span>
                </a>
            </li>
        <?php endif ?>

        <?php if ( file_exists( $percorso_cartella_dati . "/tornei.php" ) ): ?>
            <li class="nav-item border-bottom">
                <a href="./vedi_tornei.php" class="nav-link text-white">
                    <i class="fa fa-chevron-right"></i>
                    <span class="ms-3">
                        Tornei in corso
                    </span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ( link_categorie() as $categoria ): ?>
            <li class="nav-item border-bottom">
                <a href="./index.php?categoria=<?php echo $categoria[ 'id' ] ?>" class="nav-link text-white">
                    <i class="fa fa-chevron-right"></i>
                    <span class="ms-3">
                        <?php echo $categoria[ 'title' ] ?>
                    </span>
                </a>
            </li>
        <?php endforeach ?>
    </ul>
</nav>

<div class="card py-2 my-4">
    <div class="card-title border-bottom">
        <div class="fs-6 text-uppercase text-center">Accesso</div>
    </div>
    <div class="card-body">
        <?php if ( Utenti::isUserLogged() ): ?>
            <p>
                Ciao: <strong><?php echo Utenti::getUtente() ?></strong>
            </p>
            <p>
                <?php include "./inc/online.php" ?>
            </p>
        <?php else: ?>
            <?php if ( ! empty( $login_error ) ): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $login_error ?>
                </div>
            <?php endif ?>

            <form method="post" action="./login.php">
                <div class="row mb-3">
                    <label for="l_utente" class="col-md-4 col-form-label">Username</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="l_utente" name="l_utente">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="l_pass" class="col-md-4 col-form-label">Password</label>
                    <div class="col-md-8">
                        <input type="password" class="form-control" id="l_pass" name="l_pass">
                    </div>
                </div>

                <?php if ( count( $tornei = Tornei::get_tornei() ) < 2 ): ?>
                    <input type="hidden" name="l_torneo" value="1">
                <?php else: ?>
                    <div class="row mb-3">
                        <label for="l_torneo" class="col-md-4 col-form-label">Torneo</label>
                        <div class="col-md-8">
                            <select name="l_torneo" id="l_torneo" class="form-select" aria-label="Torneo">
                                <option value="">Scegli il tuo torneo</option>
                                <?php foreach ( $tornei as $torneo ): ?>
                                    <option value="<?php echo $torneo->id ?>">
                                        <?php echo $torneo->denom ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                <?php endif ?>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Accedi</button>
                </div>

                <p class="text-center mt-4">
                    <a href='./recuperopass.php'>Recupera password</a>
                </p>
            </form>
        <?php endif ?>
    </div>
</div>


<?php if ( ! empty( $links = link_pagine_link() ) ): ?>
    <nav class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column bg-dark">
        <ul class="nav flex-column text-white">
            <?php foreach ( $links as $link ): ?>
                <li class="nav-item border-bottom">
                    <a href="./index.php?paginaid=<?php echo $link[ 'id' ] ?>" class="nav-link text-white">
                        <i class="fa fa-chevron-right"></i>
                        <span class="ms-3">
                        <?php echo $link[ 'title' ] ?>
                    </span>
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </nav>
<?php endif ?>

<?php if ( (int)$vedi_notizie === 2 && ! empty( $news = ultime_notizie() ) ): ?>
    <div class="my-4 border-top pt-2">
        <p class="text-center fs-5">Ultime news:</p>
        <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column">
            <ul class="nav flex-column text-white">
                <?php foreach ( $news as $idx => $new ): ?>
                    <li class="nav-item <?php echo $idx == count( $news ) - 1 ? '' : 'border-bottom' ?>">
                        <a href="./index.php?paginaid=<?php echo $new[ 'id' ] ?>" class="nav-link text-dark">

                            <span>
                                <small><?php echo $new[ 'date' ] ?></small>
                                <?php echo $new[ 'title' ] ?>
                            </span>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php endif ?>

<?php if ( $mostra_voti_in_login === "SI" && ! empty( $giornate = Giornate::getGiornateGiocate() ) ): ?>
    <div class="card py-2 my-4">
        <div class="card-body">
            <form method="post" name="vedi_voti" action="voti.php">
                <div class="row mb-3">
                    <label for="giornata" class="col-md-4 col-form-label">Giornata</label>
                    <div class="col-md-8">
                        <select name="giornata" id="giornata" class="form-select" aria-label="Vedi giornata">
                            <?php foreach ( $giornate as $giornata ): ?>
                                <option value="<?php echo $giornata ?>">
                                    n° <?php echo $giornata ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    <div class="form-check mx-2">
                        <input class="form-check-input" type="radio" name="ruolo_guarda" value="tutti" id="tutti" checked>
                        <label class="form-check-label" for="tutti">
                            Tutti
                        </label>
                    </div>

                    <div class="form-check mx-2">
                        <input class="form-check-input" type="radio" name="ruolo_guarda" value="P" id="p">
                        <label class="form-check-label" for="p">
                            P
                        </label>
                    </div>

                    <div class="form-check mx-2">
                        <input class="form-check-input" type="radio" name="ruolo_guarda" value="D" id="d">
                        <label class="form-check-label" for="d">
                            D
                        </label>
                    </div>

                    <div class="form-check mx-2">
                        <input class="form-check-input" type="radio" name="ruolo_guarda" value="C" id="c">
                        <label class="form-check-label" for="c">
                            C
                        </label>
                    </div>

                    <?php if ( $considera_fantasisti_come === "F" ): ?>
                        <div class="form-check mx-2">
                            <input class="form-check-input" type="radio" name="ruolo_guarda" value="F" id="f">
                            <label class="form-check-label" for="f">
                                F
                            </label>
                        </div>
                    <?php else: ?>
                        <div class="form-check mx-2">
                            <input class="form-check-input" type="radio" name="ruolo_guarda" value="A" id="a">
                            <label class="form-check-label" for="a">
                                A
                            </label>
                        </div>
                    <?php endif ?>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary" name="guarda_voti" value="Voti della giornata">Vedi</button>
                </div>

                <input type="hidden" name="escludi_controllo" value="SI"/>
            </form>
        </div>
    </div>
<?php endif ?>


<?php if ( $attiva_rss === "SI" && ! empty( $news = latest_feed_news() ) ): ?>
    <div class="my-2 border-top pt-2">
        <p class="text-center fs-5">News calcio:</p>
        <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column">
            <ul class="nav flex-column text-white">
                <?php foreach ( $news as $new ): ?>
                    <li class="nav-item border-bottom">
                        <a target="_blank" href="<?php echo $new[ 'link' ] ?>" class="nav-link text-dark">
                            <small><?php echo substr( $new[ 'date' ], 0, 10 ) ?></small>
                            <span class="ms-1">
                                - <?php echo $new[ 'title' ] ?>
                            </span>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
<?php endif ?>

<?php

if ( $mostra_giornate_in_login == "SI" ) {
    $vedi_tornei_attivi = "<select name='itorneo'>";
    $tornei = @file( "$percorso_cartella_dati/tornei.php" );
    $num_tornei = 0;
    for ( $num1 = 0; $num1 < count( $tornei ); $num1++ ) {
        $num_tornei++;
    }

    for ( $num1 = 1; $num1 < $num_tornei; $num1++ ) {
        @list( $tid, $tdenom, $tpart, $tserie ) = explode( ",", trim( $tornei[ $num1 ] ) );
        $tdenom = preg_replace( "/\"/", "", $tdenom );

        if ( isset( $torneo_completo ) && $torneo_completo != "SI" )
            $vedi_tornei_attivi .= "<option value='$tid'>$tdenom</option>";
    } # fine for $num1

    $vedi_tornei_attivi .= "</select>";

    $giormerc = "<form method='post' action='guarda_giornata.php'>
	<input type='hidden' name='escludi_controllo' value='SI' />
	<input type='submit' name='guarda_giornata' value='Vedi' /> giornata n. <select name='giornata' onChange='submit()'>";

    for ( $num1 = 1; $num1 < 40; $num1++ ) {
        if ( strlen( $num1 ) == 1 )
            $num1 = "0" . $num1;
        $controlla_giornata = "giornata$num1";
        if ( @is_file( "$percorso_cartella_dati/$controlla_giornata" ) )
            $giormerc .= "<option value='$num1' selected>$num1</option>"; else break;
    } # fine for $num1

    $giormerc .= "</select><br/>" . $vedi_tornei_attivi . "</form><br/>";
    if ( $num1 > 1 )
        echo "<div class='articolo_d'>
	<div>" . $giormerc . "</div>
	<div>" . $mostra_voti_vedi . "</div>
	</div>";
}
?>
</div>
