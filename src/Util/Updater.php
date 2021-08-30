<?php

namespace FCBE\Util;

use DateTime;
use Exception;
use FCBE\Model\Updater\CalciatoriUpdaterModel;
use FCBE\Model\Updater\GiornataUpdaterModel;
use FCBE\Model\Updater\UpdaterModel;

class Updater
{
    const REPOSITORY = "https://fcbemirror.fdisotto.com/updates.json";

    private static UpdaterModel $_updates;

    public static function check()
    {
        try {
            $data = json_decode( file_get_contents( self::REPOSITORY ), true );

            self::$_updates = new UpdaterModel();
            self::$_updates->calciatori = new CalciatoriUpdaterModel( $data[ 'files' ][ 'calciatori' ] );

            foreach ( $data[ 'files' ][ 'giornate' ] as $giornata ) {
                self::$_updates->giornate[ $giornata[ 'giornata' ] ] = new GiornataUpdaterModel( $giornata );
            }
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il check updates", (array)$e );
        }
    }

    public static function getCalciatoriInfo(): array
    {
        global $percorso_cartella_dati;

        try {
            $percorso_file = $percorso_cartella_dati . "/calciatori.txt";

            return [
                "local"  => file_exists( $percorso_file ) ? filemtime( $percorso_file ) : null,
                "remote" => ( new DateTime( self::$_updates->calciatori->last_update ) )->getTimestamp(),
                "url"    => self::$_updates->calciatori->url,
            ];
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il parse del file calciatori.txt", (array)$e );

            return [
                "local"  => null,
                "remote" => null,
                "url"    => null,
            ];
        }
    }

    public static function getGiornataInfo( int $giornata ): array
    {
        global $percorso_cartella_dati, $cartella_remota;

        $giornata = str_pad( $giornata, 2, "0", STR_PAD_LEFT );

        if ( ! isset( self::$_updates->giornate[ $giornata ] ) ) {
            return [
                "local"  => null,
                "remote" => null,
                "url"    => null,
            ];
        }

        $percorso_file = sprintf( "%s/%s/MCC%s.txt", $percorso_cartella_dati, $cartella_remota, $giornata );

        try {
            return [
                "local"  => file_exists( $percorso_file ) ? filemtime( $percorso_file ) : null,
                "remote" => ( new DateTime( self::$_updates->giornate[ $giornata ]->last_update ) )->getTimestamp(),
                "url"    => self::$_updates->giornate[ $giornata ]->url,
            ];
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il parse della giornata `$giornata`", (array)$e );

            return [
                "local"  => null,
                "remote" => null,
                "url"    => null,
            ];
        }
    }

    public static function saveCalciatori(): bool
    {
        global $percorso_cartella_dati;

        try {
            $content = file_get_contents( self::$_updates->calciatori->url );
            file_put_contents( $percorso_cartella_dati . "/calciatori.txt", $content, LOCK_EX );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il salvataggio del file calciatori.txt", (array)$e );
        }

        return false;
    }

    public static function saveGiornata( int $giornata ): bool
    {
        global $percorso_cartella_dati, $cartella_remota;

        try {
            $giornata = str_pad( $giornata, 2, "0", STR_PAD_LEFT );

            $content = file_get_contents( self::$_updates->giornate[ $giornata ]->url );

            $percorso_file = sprintf( "%s/%s/MCC%s.txt", $percorso_cartella_dati, $cartella_remota, $giornata );
            file_put_contents( $percorso_file, $content, LOCK_EX );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante il salvataggio del file MCC$giornata.txt", (array)$e );
        }

        return false;
    }

}
