<?php

namespace FCBE\Util;

use DateTime;
use Exception;
use FCBE\Enum\StatoGiornata;
use FCBE\Model\SquadraModel;
use Symfony\Component\Filesystem\Filesystem;

class Giornata
{
    public static function getProssima(): string
    {
        $giornate = self::getGiornateGiocate();

        return ! empty( $giornate ) ? self::format( $giornate[ count( $giornate ) - 1 ] + 1 ) : "01";
    }

    /**
     * @return array
     */
    public static function getGiornateGiocate(): array
    {
        global $percorso_cartella_dati;
        $files = glob( $percorso_cartella_dati . "/giornata*_*_0" );

        $giornate = [];
        foreach ( $files as $file ) {
            preg_match( "/\/giornata(.*)_(.*)_0/i", $file, $tmp );

            if ( ! empty( $tmp ) ) {
                $giornate[] = $tmp[ 1 ];
            }
        }

        return $giornate;
    }

    public static function format( int $giornata ): string
    {
        return str_pad( $giornata, 2, "0", STR_PAD_LEFT );
    }

    public static function getCorrente(): string
    {
        $giornate = self::getGiornateGiocate();

        return ! empty( $giornate ) ? self::format( $giornate[ count( $giornate ) - 1 ] ) : "00";
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

    public static function esiste( int $giornata, int $torneo, int $serie ): bool
    {
        global $percorso_cartella_dati;

        $percorso_file = sprintf( "%s/giornata%s_%u_%u", $percorso_cartella_dati, self::format( $giornata ), $torneo, $serie );

        return file_exists( $percorso_file );
    }

    public static function scriviGiornata( int $giornata, string $formazioni, int $id_torneo, int $id_serie ): bool
    {
        global $percorso_cartella_dati;

        try {
            $filesystem = new Filesystem();

            $percorso_file = sprintf( "%s/giornata%s_%u_%u", $percorso_cartella_dati, self::format( $giornata ), $id_torneo, $id_serie );
            $percorso_file_iniziale = sprintf( "%s/giornata%s_%u_%u_iniziale", $percorso_cartella_dati, self::format( $giornata ), $id_torneo, $id_serie );

            $stringa_formazioni = sprintf( "#@& formazioni #@&\n%s#@& fine formazioni #@&", $formazioni );

            if ( ! $filesystem->exists( $percorso_file ) ) {
                $filesystem->touch( $percorso_file );
                $filesystem->chmod( $percorso_file, 0664 );
            }
            if ( ! $filesystem->exists( $percorso_file_iniziale ) ) {
                $filesystem->touch( $percorso_file_iniziale );
                $filesystem->chmod( $percorso_file_iniziale, 0664 );
            }

            $filesystem->dumpFile( $percorso_file, $stringa_formazioni );
            $filesystem->dumpFile( $percorso_file_iniziale, $stringa_formazioni );

            Logger::info( "Formazioni salvate!", [ "giornata" => $giornata, "formazioni" => $stringa_formazioni ] );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il salvataggio delle formazioni", (array)$e );
        }

        return false;
    }
}
