<?php

use FCBE\Util\Logger;
use FCBE\Util\Utenti;
use FCBE\Enum\StatoMercato;
use FCBE\Enum\TipoCalcolo;

error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

require_once "./dati/dati_gen.php";
require_once "./inc/funzioni.php";

global $titolo_sito, $attiva_log, $a_fm;

if ( $attiva_log == "SI" ) {
    $ip = $_SERVER[ 'REMOTE_ADDR' ];
    $url = ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' ? "https" : "http" ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    $infonome = $_SESSION[ 'utente' ] ?? "Visitatore";

    $torneo = $_SESSION[ 'torneo' ] ?? 0;

    Logger::info( "Visita", [
        "utente" => $infonome,
        "ip"     => $ip,
        "url"    => $url,
        "torneo" => $torneo,
    ] );
}
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="FantacalcioBazar | Il migliore gestore di Fantacalcio on line"/>

    <link rel="stylesheet" href="./assets/vendor/bootstrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="./assets/vendor/font-awesome/css/font-awesome.min.css">

    <link rel="stylesheet" href="./assets/vendor/datatables/datatables.min.css">
    <link rel="stylesheet" href="./assets/vendor/datatables/DataTables-1.11.0/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" type="text/css" media="all" href="./immagini/style.css"/>

    <?php
    if ( $a_fm == "SI" )
        echo "<link rel='stylesheet' type='text/css' href='./inc/fm_style.css' />";
    ?>

    <title><?php echo $titolo_sito; ?></title>
</head>
<body class="bg-light">

<a id="top"></a>

<nav class="py-2 bg-dark navbar-expand">
    <div class="container d-flex flex-wrap">
        <ul class="nav me-auto">
            <li class="nav-item">
                <a href="./index.php" class="nav-link link-light px-2">Home</a>
            </li>
            <?php foreach ( link_pagine() as $pagina ): ?>
                <li class="nav-item">
                    <a href="index.php?paginaid=<?php echo $pagina[ 'id' ] ?>" class="nav-link link-light px-2">
                        <?php echo $pagina[ 'title' ] ?>
                    </a>
                </li>
            <?php endforeach; ?>

            <?php if ( Utenti::isAdminLogged() ): ?>
                <li class="nav-item">
                    <a href="./a_gestione.php" class="nav-link link-light px-2">
                        Gestione
                    </a>
                </li>

                <li class="nav-item">
                    <a href="./a_torneo.php" class="nav-link link-light px-2">
                        Tornei
                    </a>
                </li>

                <li class="nav-item">
                    <a href="./a_sito.php" class="nav-link link-light px-2">
                        CMS
                    </a>
                </li>

                <li class="nav-item">
                    <a href="./a_configura.php" class="nav-link link-light px-2">
                        Config
                    </a>
                </li>

                <li class="nav-item">
                    <a href="./logout.php" class="nav-link link-light px-2">
                        Esci
                    </a>
                </li>
            <?php elseif ( Utenti::isUserLogged() ): ?>
                <li class="nav-item">
                    <a href="./mercato.php" class="nav-link link-light px-2">
                        Mercato
                    </a>
                </li>

                <?php if ( isset( $stato_mercato ) && ( $stato_mercato == StatoMercato::MERCATO_APERTO || $stato_mercato == StatoMercato::ASTA_PERENNE || $stato_mercato == StatoMercato::MERCATO_CHIUSO || $stato_mercato == StatoMercato::MERCATO_SOSPESO ) ): ?>
                    <li class="nav-item">
                        <a href="./giornate.php" class="nav-link link-light px-2">
                            Campionato
                        </a>
                    </li>
                <?php endif ?>

                <?php if ( isset( $ottipo_calcolo ) && $ottipo_calcolo == TipoCalcolo::SCONTRI_DIRETTI ): ?>
                    <li class="nav-item">
                        <a href="./calendario.php" class="nav-link link-light px-2">
                            Calendario
                        </a>
                    </li>
                <?php endif ?>

                <?php if ( isset( $ottipo_calcolo ) && isset( $mercato_libero ) && ( $mercato_libero == "NO" || $ottipo_calcolo == TipoCalcolo::SCONTRI_DIRETTI ) ): ?>
                    <li class="nav-item">
                        <a href="./classifica.php" class="nav-link link-light px-2">
                            Classifica
                        </a>
                    </li>
                <?php endif ?>

                <li class="nav-item">
                    <a href="./logout.php" class="nav-link link-light px-2">
                        Esci
                    </a>
                </li>
            <?php endif ?>
        </ul>
        <ul class="nav">
            <li class="nav-item">
                <a target="_blank" href="http://fantacalciobazar.altervista.org" class="nav-link link-light px-2">Forum</a>
            </li>
            <li class="nav-item">
                <a href="#top" class="nav-link link-light px-2">Top</a>
            </li>
        </ul>
    </div>
</nav>

<header class="py-3 border-bottom bg-white">
    <div class="container">
        <div class="d-flex align-items-center">
            <button class="navbar-toggle btn btn-outline-dark d-md-none d-block" id="navbar-toggler">
                <span class="fa fa-bars" aria-hidden="true"></span>
            </button>

            <span class="fs-4 ms-3">
                <?php echo $titolo_sito; ?>
            </span>
        </div>
    </div>
</header>

<div id="wrapper" class="d-block d-md-flex">
    <?php if ( ! isset( $hide_left_menu ) ): ?>
        <?php if ( Utenti::isAdminLogged() && $_SERVER[ 'SCRIPT_NAME' ] != "/index.php" ): ?>
            <?php require_once "./a_menu.php"; ?>
        <?php elseif ( Utenti::isUserLogged() && $_SERVER[ 'SCRIPT_NAME' ] != "/index.php" ): ?>
            <?php require_once "./menu.php"; ?>
        <?php endif ?>
    <?php endif ?>

    <div id="page-content-wrapper">
