<?php

if ( preg_match( '/\.(?:png|jpg|jpeg|gif|css|js)$/', $_SERVER[ "REQUEST_URI" ] ) ) {
    return false;
}

const FCBE = true;
define( "ROOT_DIR", realpath( dirname( __DIR__ ) ) );
const PAGES_DIR = ROOT_DIR . '/pages';
const DATI_DIR = ROOT_DIR . '/dati';
const INC_DIR = ROOT_DIR . '/inc';
const LOG_DIR = ROOT_DIR . '/logs';
const PUBLIC_DIR = ROOT_DIR . '/public';

require_once ROOT_DIR . '/vendor/autoload.php';

ini_set( 'display_errors', 1 );
error_reporting( E_ALL );

session_set_cookie_params( 60 * 60 * 24 );
session_start();

require_once DATI_DIR . "/dati_gen.php";
require_once INC_DIR . "/funzioni.php";

scrivi_log();

$r = strtok( trim( $_SERVER[ 'REQUEST_URI' ], '/' ), '?' );

if ( empty( $r ) || $r === 'index.php' ) {
    require_once PAGES_DIR . '/index.php';
} else {
    require_once PAGES_DIR . '/' . $r;
}
