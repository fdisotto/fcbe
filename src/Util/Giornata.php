<?php

namespace FCBE\Util;

use DateTime;
use Exception;
use FCBE\Enum\StatoGiornata;

class Giornata
{
    public static function getProssima(): string
    {
        $giornate = self::getGiornateGiocate();

        return ! empty( $giornate ) ? str_pad( $giornate[ count( $giornate ) - 1 ] + 1, 2, "0", STR_PAD_LEFT ) : "01";
    }

    /**
     * @return array
     */
    public static function getGiornateGiocate(): array
    {
        global $percorso_cartella_dati;
        $files = glob( $percorso_cartella_dati . "/*_*_0" );

        $giornate = [];
        foreach ( $files as $file ) {
            preg_match( "/\/giornata(.*)_(.*)_(.*)/i", $file, $tmp );

            $giornate[] = $tmp[ 1 ];
        }

        return $giornate;
    }

    public static function getCorrente(): string
    {
        $giornate = self::getGiornateGiocate();

        return ! empty( $giornate ) ? str_pad( $giornate[ count( $giornate ) - 1 ], 2, "0", STR_PAD_LEFT ) : "00";
    }

    public static function getStatoGiornata(): string
    {
        global $percorso_cartella_dati;

        $percorso_file = sprintf( "%s/chiusura_giornata.txt", $percorso_cartella_dati );

        return file_exists( $percorso_file ) ? StatoGiornata::CHIUSA : StatoGiornata::APERTA;
    }

    public static function getChiusuraGiornata(): string
    {
        global $percorso_cartella_dati;

        $percorso_file = sprintf( "%s/data_chigio.txt", $percorso_cartella_dati );

        if ( file_exists( $percorso_file ) ) {
            return file_get_contents( $percorso_file );
        }

        return date( "YmdHi" );
    }

    public static function saveChiusuraGiornata( DateTime $date ): bool
    {
        global $percorso_cartella_dati;

        try {
            $percorso_file = sprintf( "%s/data_chigio.txt", $percorso_cartella_dati );

            $data = $date->format( "YmdHi" );
            file_put_contents( $percorso_file, $data, LOCK_EX );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il salvataggio della chiusura giornata", (array)$e );
        }

        return false;
    }

    public static function chiudiGiornata(): bool
    {
        global $percorso_cartella_dati;

        try {
            $percorso_file = sprintf( "%s/chiusura_giornata.txt", $percorso_cartella_dati );

            file_put_contents( $percorso_file, 1, LOCK_EX );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante la chiusura della giornata", (array)$e );
        }

        return false;
    }

    public static function apriGiornata(): bool
    {
        global $percorso_cartella_dati;

        try {
            $percorso_file = sprintf( "%s/chiusura_giornata.txt", $percorso_cartella_dati );

            if ( file_exists( $percorso_file ) ) {
                unlink( $percorso_file );
            }

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante l'apertura della giornata", (array)$e );
        }

        return false;
    }
}
