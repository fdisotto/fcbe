<?php

use FCBE\Util\Utenti;
use FCBE\Enum\StatoMercato;
use FCBE\Enum\TipoCalcolo;

//error_reporting( E_ALL ^ E_NOTICE );
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

if ( isset( $attiva_log ) && $attiva_log == "SI" ) {
    $xx1 = $_SERVER[ 'SERVER_PORT' ];
    $giorno = date( "d", time() );
    $mese = date( "m", time() );
    $anno = date( "Y", time() );
    $ora = date( "H", time() );
    $minuto = date( "i", time() );
    $visitatore_info = $_SERVER[ 'REMOTE_ADDR' ];
    $base = "https://" . $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ];
    $x1 = "host $visitatore_info";
    $x2 = $_SERVER[ 'REMOTE_PORT' ];
    $date = "$giorno-$mese-$anno $ora:$minuto";

    $infonome = $_SESSION[ 'utente' ] ?? "Visitatore";

    $torneo = $_SESSION[ 'torneo' ] ?? '';
    file_put_contents( $percorso_cartella_dati . "/log" . $torneo . ".txt", "$date - $infonome - $base:$xx1 - $visitatore_info\n", FILE_APPEND | LOCK_EX );
}
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Description" content="FantacalcioBazar | Il migliore gestore di Fantacalcio on line"/>
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" media="all" href="./immagini/style.css"/>
    <style type="text/css">
        caption {
            background-color: <?php echo $sfondo_tab2 ?>
        }

        .menu_s a {
            background: <?php echo $sfondo_tab3 ?> url(immagini/vmenuarrow.gif) no-repeat center left;
        }
    </style>

    <?php
    if ( isset( $a_fm ) && $a_fm == "SI" )
        echo "<link rel='stylesheet' type='text/css' href='./inc/fm_style.css' />";
    ?>
    <!--[if lt IE 9]>
    <script src="./inc/js/jquery-1.10.2.min.js"></script>
    <![endif]-->
    <!--[if gte IE 9]><!-->
    <script src="./inc/js/jquery-2.0.3.min.js"></script>
    <!--<![endif]-->
    <script type="text/javascript">
        /* <![CDATA[ */
        $(document).ready(function () {
            /* CONFIG */
            /* set start (sY) and finish (fY) heights for the list items */
            sY = 24;
            fY = 375;
            /* end CONFIG */

            /* open first list item */
            animate(fY)

            $("#slide .top").click(function () {
                if (this.className.indexOf('clicked') == -1) {
                    animate(sY)
                    $('.clicked').removeClass('clicked');
                    $(this).addClass('clicked');
                    animate(fY)
                }
            });

            function animate(pY) {
                $('.clicked').animate({"height": pY + "px"}, 500);
            }

        });
        /* ]]> */
    </script>

    <title><?php echo $titolo_sito; ?></title>
</head>
<body class="bg-light">

<a id="top"></a>


<nav class="py-2 bg-dark fixed-top navbar-expand">
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

<header class="py-3 mb-4 border-bottom bg-white">
    <div class="container d-flex flex-wrap justify-content-center">
        <a href="./index.php" class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto text-decoration-none text-dark">
            <span class="fs-4">
                <?php echo $titolo_sito; ?>
            </span>
        </a>
    </div>
</header>

<table width='100%' cellpadding='5' summary='Tabella principale'>
    <tr>
        <td valign='top'>
