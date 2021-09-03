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
##################################################################################

use FCBE\Util\Utenti;

$scadenza_sessioni = 60 * 60 * 2;        # secondi x minuti x ore
session_set_cookie_params( $scadenza_sessioni );
session_start();

require_once "./dati/dati_gen.php";
require_once "./vendor/autoload.php";

global $admin_user, $admin_pass;

$login_utente = $_POST[ "l_utente" ];
$login_pass = $_POST[ "l_pass" ];
$login_torneo = $_POST[ "l_torneo" ];

if ( empty( $login_utente ) || empty( $login_pass ) ) {
    header( "location: index.php?fallito=1" );
} else {
    if ( Utenti::isAdminLogged() ) {
        header( "location: ./a_gestione.php" );
        exit;
    } elseif ( Utenti::isUserLogged() ) {
        header( "location: ./mercato.php" );
        exit;
    } else {
        if ( $login_utente === $admin_user && $login_pass === $admin_pass ) {
            $_SESSION[ "utente" ] = $admin_user;
            $_SESSION[ "pass" ] = $admin_pass;
            $_SESSION[ "admin" ] = "SI";
            $_SESSION[ "permessi" ] = 5;
            $_SESSION[ "valido" ] = "SI";
            $_SESSION[ 'csn' ] = $_SERVER[ 'SERVER_NAME' ];
            header( "location: a_gestione.php" );

            exit;
        } elseif ( $login_utente !== $admin_user ) {
            if ( $utente = Utenti::existUtenteInTorneo( $login_utente, $login_torneo ) ) {
                if ( $utente->password === md5( $login_pass ) ) {
                    if ( $utente->permessi >= 0 ) {
                        $_SESSION[ 'uid' ] = $utente->id;
                        $_SESSION[ 'utente' ] = $utente->username;
                        $_SESSION[ 'pass' ] = $utente->password;
                        $_SESSION[ 'permessi' ] = $utente->permessi;
                        $_SESSION[ 'email' ] = $utente->permessi;
                        $_SESSION[ 'url' ] = $utente->url;
                        $_SESSION[ 'citta' ] = $utente->citta;
                        $_SESSION[ 'squadra' ] = $utente->squadra;
                        $_SESSION[ 'torneo' ] = $utente->torneo;
                        $_SESSION[ 'serie' ] = $utente->serie;
                        $_SESSION[ 'valido' ] = "SI";
                        $_SESSION[ 'reg' ] = trim( $utente->data_registrazione );
                        $_SESSION[ 'titolari' ] = $utente->titolari;
                        $_SESSION[ 'panchina' ] = $utente->panchina;
                        $_SESSION[ 'temp1' ] = $utente->temp1;
                        $_SESSION[ 'temp2' ] = $utente->temp2;
                        $_SESSION[ 'temp3' ] = $utente->temp3;
                        $_SESSION[ 'temp4' ] = $utente->temp4;
                        $_SESSION[ 'temp5' ] = $utente->temp5;
                        $_SESSION[ 'temp6' ] = $utente->temp6;
                        $_SESSION[ 'temp7' ] = $utente->temp7;
                        $_SESSION[ 'temp8' ] = $utente->temp8;
                        $_SESSION[ 'temp9' ] = $utente->temp9;
                        $_SESSION[ 'temp0' ] = $utente->temp0;
                        $_SESSION[ 'csn' ] = $_SERVER[ 'SERVER_NAME' ];
                        header( "location: mercato.php" );
                    } else {
                        header( "location: index.php?attesa=1" );
                    }
                    exit;
                }
            }
        }
    }
}

header( "location: index.php?fallito=1" );
exit;
