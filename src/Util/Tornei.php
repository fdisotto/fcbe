<?php

namespace FCBE\Util;

use Exception;
use FCBE\Model\TorneoModel;
use Symfony\Component\Filesystem\Filesystem;

class Tornei
{
    public static function getTorneo( int $id_torneo ): ?TorneoModel
    {
        $tornei = self::getTornei();

        foreach ( $tornei as $torneo ) {
            if ( $torneo->id === $id_torneo ) {
                return $torneo;
            }
        }

        return null;
    }

    /**
     * @return TorneoModel[]
     */
    public static function getTornei(): iterable
    {
        global $percorso_cartella_dati;

        $percorso_file = $percorso_cartella_dati . "/tornei.php";

        $tornei = [];
        if ( file_exists( $percorso_file ) ) {
            $rows = file( $percorso_file );

            $tornei = unserialize( $rows[ 1 ] );

            foreach ( $tornei as &$torneo ) {
                $torneo->giocatori_registrati = count( Utenti::getUtentiInTorneo( $torneo->id ) );
            }
        }

        return $tornei;
    }

    public static function creaTorneo( TorneoModel $torneo_model ): bool
    {
        global $percorso_cartella_dati;

        try {
            $filesystem = new Filesystem();

            $percorso_file = $percorso_cartella_dati . "/tornei.php";

            $torneo_model->id = self::getNextId();

            $tornei = self::getTornei();

            $tornei[] = $torneo_model;

            if ( ! $filesystem->exists( $percorso_file ) ) {
                $filesystem->touch( $percorso_file );
                $filesystem->chmod( $percorso_file, 0664 );
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $tornei ) );

            Logger::info( "Torneo salvato con successo", $torneo_model->toArray() );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante la creazione del torneo", (array)$e );
        }

        return false;
    }

    private static function getNextId(): int
    {
        $tornei = self::getTornei();

        $id = 0;
        foreach ( $tornei as $torneo ) {
            if ( $torneo->id > $id ) {
                $id = $torneo->id;
            }
        }

        return ++$id;
    }

    public static function modificaTorneo( TorneoModel $torneo_model ): bool
    {
        global $percorso_cartella_dati;

        try {
            $filesystem = new Filesystem();

            $percorso_file = $percorso_cartella_dati . "/tornei.php";

            $tornei = self::getTornei();

            foreach ( $tornei as $idx => $torneo ) {
                if ( $torneo->id === $torneo_model->id ) {
                    $tornei[ $idx ] = $torneo_model;
                }
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $tornei ) );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante la modifica del torneo", (array)$e );
        }

        return false;
    }

    public static function eliminaTorneo( int $id_torneo ): bool
    {
        global $percorso_cartella_dati;

        try {
            $filesystem = new Filesystem();

            $percorso_file = $percorso_cartella_dati . "/tornei.php";

            $tornei = self::getTornei();

            foreach ( $tornei as $idx => $torneo ) {
                if ( $torneo->id === $id_torneo ) {
                    unset( $tornei[ $idx ] );
                }
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $tornei ) );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante l'eliminazione del torneo", (array)$e );
        }

        return false;
    }
}
