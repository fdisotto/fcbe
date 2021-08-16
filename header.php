<?php

//error_reporting( E_ALL ^ E_NOTICE );
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

$clock[] = "Inizio " . microtime();
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
    if ( ! isset( $_SESSION[ 'utente' ] ) || $_SESSION[ 'utente' ] == "" )
        $infonome = "Visitatore"; else $infonome = $_SESSION[ 'utente' ];
    $torneo = $_SESSION[ 'torneo' ] ?? '';
    file_put_contents( $percorso_cartella_dati . "/log" . $torneo . ".txt", "$date - $infonome - $base:$xx1 - $visitatore_info\n", FILE_APPEND | LOCK_EX );
}

$acapo = "\n";

$chiusura_giornata = file_exists( $percorso_cartella_dati . "/chiusura_giornata.txt" ) ? (int)file_get_contents( $percorso_cartella_dati . "/chiusura_giornata.txt" ) : 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it" dir="ltr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="Content-Language" content="Italian"/>
    <meta name="Author" content="Antonello Onida - http://fantacalciobazar.sssr.it"/>
    <meta name="Description" content="FantacalcioBazar | Il migliore gestore di Fantacalcio on line"/>
    <meta name="Keywords" content="fantacalciobazar, fantacalcio, semplice, completo, online"/>
    <meta name="Robots" content="INDEX, FOLLOW"/>
    <link rel="stylesheet" type="text/css" media="all" href="./immagini/style.css"/>
    <style type="text/css">
        body {
            background-color: <?php echo $sfondo_tab1 ?>;
            color: <?php echo $carattere_colore ?>;
            font-family: <?php echo $carattere_tipo ?>;
            font-size: <?php echo $carattere_size ?>
        }

        caption {
            background-color: <?php echo $sfondo_tab2 ?>
        }

        .menu_s a {
            background: <?php echo $sfondo_tab3 ?> url(immagini/vmenuarrow.gif) no-repeat center left;
            color: <?php echo $carattere_colore_chiaro ?>
        }
    </style>

    <?php
    if ( isset( $a_fm ) && $a_fm == "SI" )
        echo "<link rel='stylesheet' type='text/css' href='./inc/fm_style.css' />" . $acapo;
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
<body>

<a name="top"></a>
<ul id="nav">

    <li><a href="index.php" title="Ritorna alla pagina iniziale del sito - accesskey = h" accesskey="h"><u>H</u>ome</a>
    </li>
    <li><a href="http://fantacalciobazar.altervista.org/comunica/index.php"
            title="Forum per discutere e chiedere informazioni di vario carattere - accesskey = f"
            accesskey="f"><u>F</u>orum</a></li>
    <li><a href="#top" title="Risale ad inizio pagina - accesskey = t" accesskey="t"><u>T</u>op</a></li>
</ul>
<div id="header">
    <div id="logo">
        <div style="float: left">
            <a href="index.php" title="<?php echo "$titolo_sito"; ?>"><?php echo "$titolo_sito"; ?></a>
        </div>
    </div>
    <div id="hmenu">
        <?php
        if ( $usa_cms == "SI" )
            link_pagine();
        if ( @$_SESSION[ 'valido' ] == "SI" and $_SESSION[ 'utente' ] == $admin_user ) {
            echo "<a href='./a_gestione.php'>gestione</a><a href='./a_torneo.php' title='Gestione tornei'>tornei</a>";
            if ( $usa_cms == "SI" )
                echo "<a href='./a_sito.php' title='Gestione contenuti testuali'>cms</a>";
            echo "<a href='./a_configura.php' title='Configurazione parametri generali'>config</a><a href='./logout.php' title='Disconnessione amministratore'>esci</a>";
        } elseif ( @$_SESSION[ 'valido' ] == "SI" ) {
            echo "<a href='./mercato.php'>Mercato</a>";

            if ( isset( $stato_mercato ) && ($stato_mercato == "A" or $stato_mercato == "P" or $stato_mercato == "C" or $stato_mercato == "S") ) {
                echo "<a href='./giornate.php'>Campionato</a>";
                if ( $ottipo_calcolo == "S" )
                    echo "<a href='./calendario.php'>Calendario</a>";
                if ( $mercato_libero == "NO" or $ottipo_calcolo == "S" )
                    echo "<a href='./classifica.php'>Classifica</a>";
            }
            echo "<a href='./logout.php'>Logout</a>";
        }
        echo "</div>
</div>
<table width='100%' cellpadding='5' align='center' summary='Tabella principale'>
<tr>
<td valign='top'>
";
        ?>
