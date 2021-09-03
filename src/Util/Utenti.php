<?php

namespace FCBE\Util;

use Exception;
use FCBE\Model\UtenteModel;
use Symfony\Component\Filesystem\Filesystem;

class Utenti
{
    /**
     * @return bool
     */
    public static function isAdminLogged(): bool
    {
        global $admin_user, $admin_pass;

        return self::isUserLogged() && $_SESSION[ 'utente' ] === $admin_user && $_SESSION[ 'pass' ] === $admin_pass && $_SESSION[ 'permessi' ] >= 5;
    }

    /**
     * @return bool
     */
    public static function isUserLogged(): bool
    {
        return isset( $_SESSION[ 'valido' ] ) && isset( $_SESSION[ 'utente' ] ) && $_SESSION[ 'valido' ] === "SI";
    }

    /**
     * @return string|null
     */
    public static function getUtente(): ?string
    {
        return self::isUserLogged() ? $_SESSION[ 'utente' ] : null;
    }

    /**
     * @param string $utente
     * @param int $id_torneo
     * @return UtenteModel|null
     */
    public static function existUtenteInTorneo( string $utente, int $id_torneo ): ?UtenteModel
    {
        $utenti = self::getUtentiInTorneo( $id_torneo );

        foreach ( $utenti as $u ) {
            if ( $u->username === $utente && $u->torneo === $id_torneo ) {
                return $u;
            }
        }

        return null;
    }

    /**
     * @param int $id_torneo
     * @return UtenteModel[]
     */
    public static function getUtentiInTorneo( int $id_torneo ): iterable
    {
        global $percorso_cartella_dati;

        $percorso_file = $percorso_cartella_dati . "/utenti_" . $id_torneo . ".php";

        // TODO Da reimplementare successivamente
        /*$utenti = [];
        if ( file_exists( $percorso_file ) ) {
            $rows = file( $percorso_file );

            $utenti = unserialize( $rows[ 1 ] );
        }*/

        $utenti = [];
        if ( file_exists( $percorso_file ) ) {
            $rows = explode( "\n", file_get_contents( $percorso_file ) );

            foreach ( $rows as $idx => $row ) {
                if ( $idx == 0 || empty( trim( $row ) ) ) {
                    continue;
                }

                $temp = explode( "<del>", $row );

                $utenti[] = new UtenteModel( [
                    'id'                 => $idx,
                    'username'           => $temp[ 0 ],
                    'password'           => $temp[ 1 ],
                    'permessi'           => $temp[ 2 ],
                    'email'              => $temp[ 3 ],
                    'url'                => $temp[ 4 ],
                    'squadra'            => $temp[ 5 ],
                    'torneo'             => $temp[ 6 ],
                    'serie'              => $temp[ 7 ],
                    'citta'              => $temp[ 8 ],
                    'crediti'            => $temp[ 9 ],
                    'variazioni'         => $temp[ 10 ],
                    'cambi'              => $temp[ 11 ],
                    'data_registrazione' => $temp[ 12 ],
                    'titolari'           => $temp[ 13 ],
                    'panchina'           => $temp[ 14 ],
                    'nome'               => $temp[ 15 ],
                    'cognome'            => $temp[ 16 ],
                ] );
            }
        }

        return $utenti;
    }

    /**
     * @param string $email
     * @param int $id_torneo
     * @return UtenteModel|null
     */
    public static function existEmailInTorneo( string $email, int $id_torneo ): ?UtenteModel
    {
        $utenti = self::getUtentiInTorneo( $id_torneo );

        foreach ( $utenti as $u ) {
            if ( $u->email === $email && $u->torneo === $id_torneo ) {
                return $u;
            }
        }

        return null;
    }

    /**
     * @param string $squadra
     * @param int $id_torneo
     * @return UtenteModel|null
     */
    public static function existSquadraInTorneo( string $squadra, int $id_torneo ): ?UtenteModel
    {
        $utenti = self::getUtentiInTorneo( $id_torneo );

        foreach ( $utenti as $u ) {
            if ( $u->squadra === $squadra && $u->torneo === $id_torneo ) {
                return $u;
            }
        }

        return null;
    }

    public static function creaUtente( UtenteModel $utente ): bool
    {
        global $percorso_cartella_dati;

        try {
            if ( $utente->torneo <= 0 ) {
                return false;
            }

            $filesystem = new Filesystem();

            $percorso_file = $percorso_cartella_dati . "/utenti_" . $utente->torneo . ".php";

            /*$utenti = self::getUtentiInTorneo( $utente->torneo );

            $utente->id = self::getNextId( $utente->torneo );
            $utenti[] = $utente;

            if ( ! $filesystem->exists( $percorso_file ) ) {
                $filesystem->touch( $percorso_file );
                $filesystem->chmod( $percorso_file, 0664 );
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $utenti ) );*/

            if ( ! $filesystem->exists( $percorso_file ) ) {
                $filesystem->touch( $percorso_file );
                $filesystem->chmod( $percorso_file, 0664 );
                $filesystem->appendToFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" );
            }

            $stringa = $utente->username . "<del>" . md5( $utente->password ) . "<del>" . $utente->permessi . "<del>" . $utente->email . "<del>" . $utente->url . "<del>" . $utente->squadra . "<del>" . $utente->torneo . "<del>" . $utente->serie . "<del>" . $utente->citta . "<del>" . $utente->crediti . "<del>" . $utente->variazioni . "<del>" . $utente->cambi . "<del>" . $utente->data_registrazione . "<del>0<del>0<del>" . $utente->nome . "<del>" . $utente->cognome . "<del>0<del>0<del>0<del>0<del>0<del>0<del>0<del>0\n";

            $filesystem->appendToFile( $percorso_file, $stringa );

            Logger::info( "User succesfully registered", $utente->toArray() );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Error during user registration", $e );
        }

        return false;
    }

    public static function approva( int $id_utente, int $id_torneo ): bool
    {
        try {
            $utente = self::getUtenteById( $id_utente, $id_torneo );
            $utente->permessi = 0;

            return self::modificaUtente( $utente, $id_torneo );
        } catch ( Exception $e ) {
            Logger::error( "Errore durante l'approvazione dell'utente" );
        }

        return false;
    }

    /**
     * @param int $id_utente
     * @param int $id_torneo
     * @return UtenteModel|null
     */
    public static function getUtenteById( int $id_utente, int $id_torneo ): ?UtenteModel
    {
        $utenti = self::getUtentiInTorneo( $id_torneo );

        foreach ( $utenti as $utente ) {
            if ( $utente->id === $id_utente ) {
                return $utente;
            }
        }

        return null;
    }

    public static function modificaUtente( UtenteModel $utente_model, int $id_torneo ): bool
    {
        global $percorso_cartella_dati;

        try {
            $percorso_file = sprintf( "%s/utenti_%u.php", $percorso_cartella_dati, $id_torneo );

            if ( ! file_exists( $percorso_file ) ) {
                return false;
            }

            $filesystem = new Filesystem();

            /* $utenti = self::getUtentiInTorneo( $utente_model->torneo );

            foreach ( $utenti as $idx => $utente ) {
                if ( $utente->id === $utente_model->id ) {
                    $utenti[ $idx ] = $utente_model;
                }
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $utenti ) );
            */

            $utenti = file( $percorso_file );

            $stringa = $utente_model->username . "<del>" . $utente_model->pass . "<del>" . $utente_model->permessi . "<del>" . $utente_model->email . "<del>" . $utente_model->url . "<del>" . $utente_model->squadra . "<del>" . $utente_model->torneo . "<del>" . $utente_model->serie . "<del>" . $utente_model->citta . "<del>" . $utente_model->crediti . "<del>" . $utente_model->variazioni . "<del>" . $utente_model->cambi . "<del>" . $utente_model->reg . "<del>0<del>0<del>" . $utente_model->nome . "<del>" . $utente_model->cognome . "<del>0<del>0<del>0<del>0<del>0<del>0<del>0<del>0\n";

            $utenti[ $utente_model->id ] = $stringa;
            $nuovo_file = implode( "", $utenti );

            file_put_contents( $percorso_file, $nuovo_file, LOCK_EX );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante l'aggiornamento dell'utente", (array)$e );
        }

        return false;
    }

    public static function eliminaUtente( int $id_utente, int $id_torneo ): bool
    {
        global $percorso_cartella_dati;

        try {
            $percorso_file = sprintf( "%s/utenti_%u.php", $percorso_cartella_dati, $id_torneo );

            if ( ! file_exists( $percorso_file ) ) {
                return false;
            }

            $utenti = file( $percorso_file );
            foreach ( $utenti as $idx => $utente ) {
                if ( $idx === 0 || empty( $utente ) ) {
                    continue;
                }

                if ( $idx === $id_utente ) {
                    $utenti[ $idx ] = "\n";
                    break;
                }
            }

            $nuovo_file = implode( "", $utenti );

            file_put_contents( $percorso_file, $nuovo_file, LOCK_EX );

            /*$filesystem = new Filesystem();

            $utenti = self::getUtentiInTorneo( $id_torneo );

            foreach ( $utenti as $idx => $utente ) {
                if ( $utente->id === $id_utente ) {
                    unset( $utenti[ $idx ] );
                }
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $utenti ) );*/

            Logger::info( sprintf( "Utente %u nel torneo %u eliminato con successo", $id_utente, $id_torneo ) );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante l'eliminazione dell'utente", (array)$e );
        }

        return false;
    }

    private static function getNextId( int $id_torneo ): int
    {
        $utenti = self::getUtentiInTorneo( $id_torneo );

        $id = 0;
        foreach ( $utenti as $utente ) {
            if ( $utente->id > $id ) {
                $id = $utente->id;
            }
        }

        return ++$id;
    }
}
