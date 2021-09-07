<?php


use FCBE\Util\Giornata;
use FCBE\Util\Utenti;
use FCBE\Util\Tornei;

require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";

global $messaggi, $percorso_cartella_dati, $iscrizione_online, $vedi_notizie, $attiva_rss, $mostra_voti_in_login, $considera_fantasisti_come, $mostra_giornate_in_login;

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

        <?php if ( ! empty( Tornei::getTornei() ) ): ?>
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

                <?php if ( count( $tornei = Tornei::getTornei() ) < 2 ): ?>
                    <input type="hidden" name="l_torneo" value="1">
                <?php else: ?>
                    <div class="row mb-3">
                        <label for="l_torneo" class="col-md-4 col-form-label">Torneo</label>
                        <div class="col-md-8">
                            <select name="l_torneo" id="l_torneo" class="form-select" aria-label="Torneo">
                                <option value="">Scegli il tuo torneo</option>
                                <?php foreach ( $tornei as $torneo ): ?>
                                    <option value="<?php echo $torneo->id ?>">
                                        <?php echo $torneo->nome ?>
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
    <div class="card py-2 my-4">
        <div class="card-title border-bottom">
            <div class="fs-6 text-uppercase text-center">Ultime news:</div>
        </div>
        <div class="card-body">
            <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column">
                <ul class="nav flex-column text-white">
                    <?php foreach ( $news as $idx => $new ): ?>
                        <li class="nav-item <?php echo $idx == count( $news ) - 1 ? '' : 'border-bottom' ?>">
                            <a href="./index.php?paginaid=<?php echo $new[ 'id' ] ?>" class="nav-link text-dark ps-0">

                            <span>
                                <i class="fa fa-chevron-right me-2"></i>
                                <small><?php echo $new[ 'date' ] ?></small>
                                <?php echo $new[ 'title' ] ?>
                            </span>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if ( $mostra_voti_in_login === "SI" && ! empty( $giornate = Giornata::getGiornateGiocate() ) ): ?>
    <div class="card py-2 my-4">
        <div class="card-title border-bottom">
            <div class="fs-6 text-uppercase text-center">Voti calciatori:</div>
        </div>
        <div class="card-body">
            <form method="get" name="vedi_voti" action="voti.php">
                <div class="row mb-3">
                    <label for="v_giornata" class="col-md-4 col-form-label">Giornata</label>
                    <div class="col-md-8">
                        <select name="v_giornata" id="v_giornata" class="form-select" aria-label="Vedi giornata">
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
                        <input class="form-check-input" type="radio" name="v_ruolo" value="tutti" id="tutti" checked>
                        <label class="form-check-label" for="tutti">
                            Tutti
                        </label>
                    </div>

                    <div class="form-check mx-2">
                        <input class="form-check-input" type="radio" name="v_ruolo" value="P" id="p">
                        <label class="form-check-label" for="p">
                            P
                        </label>
                    </div>

                    <div class="form-check mx-2">
                        <input class="form-check-input" type="radio" name="v_ruolo" value="D" id="d">
                        <label class="form-check-label" for="d">
                            D
                        </label>
                    </div>

                    <div class="form-check mx-2">
                        <input class="form-check-input" type="radio" name="v_ruolo" value="C" id="c">
                        <label class="form-check-label" for="c">
                            C
                        </label>
                    </div>

                    <?php if ( $considera_fantasisti_come === "F" ): ?>
                        <div class="form-check mx-2">
                            <input class="form-check-input" type="radio" name="v_ruolo" value="F" id="f">
                            <label class="form-check-label" for="f">
                                F
                            </label>
                        </div>
                    <?php else: ?>
                        <div class="form-check mx-2">
                            <input class="form-check-input" type="radio" name="v_ruolo" value="A" id="a">
                            <label class="form-check-label" for="a">
                                A
                            </label>
                        </div>
                    <?php endif ?>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Vedi</button>
                </div>
            </form>
        </div>
    </div>
<?php endif ?>

<?php if ( $mostra_giornate_in_login === "SI" && ! empty( $giornate = Giornata::getGiornateGiocate() ) && ! empty( $tornei = Tornei::getTornei() ) ): ?>
    <div class="card py-2 my-4">
        <div class="card-title border-bottom">
            <div class="fs-6 text-uppercase text-center">Voti tornei:</div>
        </div>

        <div class="card-body">
            <form action="guarda_giornata.php" method="get" name="vedi_giornate">

                <div class="row mb-3">
                    <label for="v_torneo" class="col-md-4 col-form-label">Torneo</label>
                    <div class="col-md-8">
                        <select name="v_torneo" id="v_torneo" class="form-select" aria-label="Scegli torneo">
                            <?php foreach ( $tornei as $torneo ): ?>
                                <option value="<?php echo $torneo->id ?>">
                                    <?php echo $torneo->nome ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="v_giornata" class="col-md-4 col-form-label">Giornata</label>
                    <div class="col-md-8">
                        <select name="v_giornata" id="v_giornata" class="form-select" aria-label="Scegli giornata">
                            <?php foreach ( $giornate as $giornata ): ?>
                                <option value="<?php echo $giornata ?>">
                                    n° <?php echo $giornata ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Vedi</button>
                </div>
            </form>
        </div>
    </div>
<?php endif ?>


<?php if ( $attiva_rss === "SI" && ! empty( $news = latest_feed_news() ) ): ?>
    <div class="card py-2 my-4">
        <div class="card-title border-bottom">
            <div class="fs-6 text-uppercase text-center">News calcio:</div>
        </div>
        <div class="card-body">
            <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column">
                <ul class="nav flex-column text-white">
                    <?php foreach ( $news as $idx => $new ): ?>
                        <li class="nav-item <?php echo $idx == count( $news ) - 1 ? '' : 'border-bottom' ?>">
                            <a href="<?php echo $new[ 'link' ] ?>" class="nav-link text-dark ps-0">

                            <span>
                                <i class="fa fa-chevron-right me-2"></i>
                                <small><?php echo substr( $new[ 'date' ], 0, 10 ) ?></small>
                                <?php echo $new[ 'title' ] ?>
                            </span>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif ?>
