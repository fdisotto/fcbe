<?php

namespace FCBE\Util;

use FCBE\Model\UtenteModel;

class Utenti
{
    public static function isAdminLogged(): bool
    {
        global $admin_user, $admin_pass;

        return self::isUserLogged() && $_SESSION[ 'utente' ] === $admin_user && $_SESSION[ 'pass' ] === $admin_pass;
    }

    public static function isUserLogged(): bool
    {
        return isset( $_SESSION[ 'valido' ] ) && isset( $_SESSION[ 'utente' ] ) && $_SESSION[ 'valido' ] === "SI";
    }

    public static function getUtente(): ?string
    {
        return self::isUserLogged() ? $_SESSION[ 'utente' ] : null;
    }

    public static function existUtenteInTorneo( string $utente, int $id_torneo ): ?UtenteModel
    {
        $utenti = self::getUtentiInTorneo( $id_torneo );

        foreach ( $utenti as $u ) {
            if ( $u->utente === $utente && $u->torneo === $id_torneo ) {
                return $u;
            }
        }

        return null;
    }

    /**
     * @param $id_torneo
     * @return UtenteModel[]
     */
    public static function getUtentiInTorneo( int $id_torneo ): iterable
    {
        global $percorso_cartella_dati;

        $cacheKey = sprintf( "utenti_%s", $id_torneo );

        if ( $utenti = Cache::get( $cacheKey ) ) {
            return $utenti;
        }

        $percorso_file = $percorso_cartella_dati . "/utenti_" . $id_torneo . ".php";

        $utenti = [];
        if ( file_exists( $percorso_file ) ) {
            $rows = explode( "\n", file_get_contents( $percorso_file ) );

            foreach ( $rows as $idx => $row ) {
                if ( $idx == 0 || empty( trim( $row ) ) ) {
                    continue;
                }

                $temp = explode( "<del>", $row );

                $utenti[] = new UtenteModel( [
                    'id'         => $idx,
                    'utente'     => $temp[ 0 ],
                    'pass'       => $temp[ 1 ],
                    'permessi'   => $temp[ 2 ],
                    'email'      => $temp[ 3 ],
                    'url'        => $temp[ 4 ],
                    'squadra'    => $temp[ 5 ],
                    'torneo'     => $temp[ 6 ],
                    'serie'      => $temp[ 7 ],
                    'citta'      => $temp[ 8 ],
                    'crediti'    => $temp[ 9 ],
                    'variazioni' => $temp[ 10 ],
                    'cambi'      => $temp[ 11 ],
                    'reg'        => $temp[ 12 ],
                    'titolari'   => $temp[ 13 ],
                    'panchina'   => $temp[ 14 ],
                    'temp1'      => $temp[ 15 ],
                    'temp2'      => $temp[ 16 ],
                    'temp3'      => $temp[ 17 ],
                    'temp4'      => $temp[ 18 ],
                    'temp5'      => $temp[ 19 ],
                    'temp6'      => $temp[ 20 ],
                    'temp7'      => $temp[ 21 ],
                    'temp8'      => $temp[ 22 ],
                    'temp9'      => $temp[ 23 ],
                    'temp0'      => $temp[ 24 ],
                ] );
            }

            Cache::save( $cacheKey, $utenti );
        }

        return $utenti;
    }
}
