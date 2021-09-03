<?php

namespace FCBE\Util;

use Exception;
use FCBE\Model\SquadraGiocatoreModel;
use FCBE\Model\SquadraModel;

class Squadra
{
    /**
     * @param string $utente
     * @param int $id_torneo
     * @param int $id_serie
     * @return SquadraModel
     */
    public static function getSquadra( string $utente, int $id_torneo, int $id_serie ): SquadraModel
    {
        global $percorso_cartella_dati;

        $squadra = new SquadraModel();

        try {
            $percorso_file_squadra = sprintf( "%s/squadra_%s", $percorso_cartella_dati, $utente );
            $percorso_file_mercato = sprintf( "%s/mercato_%u_%u.txt", $percorso_cartella_dati, $id_torneo, $id_serie );

            if ( file_exists( $percorso_file_squadra ) && file_exists( $percorso_file_mercato ) ) {
                $torneo = Tornei::getTorneo( $id_torneo );
                $dati_squadra = file( $percorso_file_squadra );
                $titolari = array_filter( explode( ",", $dati_squadra[ 1 ] ), "trim" );
                $panchinari = array_filter( explode( ",", $dati_squadra[ 2 ] ), "trim" );

                $calciatori = file( $percorso_file_mercato );

                foreach ( $calciatori as $calciatore ) {
                    $tmp = explode( ",", $calciatore );

                    $anno_off = (int)substr( $tmp[ 5 ], 0, 4 );
                    $mese_off = (int)substr( $tmp[ 5 ], 4, 2 );
                    $giorno_off = (int)substr( $tmp[ 5 ], 6, 2 );
                    $ora_off = (int)substr( $tmp[ 5 ], 8, 2 );
                    $minuto_off = (int)substr( $tmp[ 5 ], 10, 2 );
                    $adesso = mktime( date( "H" ), date( "i" ), 0, date( "m" ), date( "d" ), date( "Y" ) );
                    $sec_restanti = mktime( $ora_off, $minuto_off, 0, $mese_off, $giorno_off, $anno_off ) - $adesso;

                    if ( $tmp[ 4 ] === $utente && ( $torneo->mercato_libero === "SI" || $sec_restanti <= 0 ) ) {
                        $calciatore = [
                            "codice"        => (int)$tmp[ 0 ],
                            "nome"          => trim( $tmp[ 1 ] ),
                            "ruolo"         => trim( $tmp[ 2 ] ),
                            "valore"        => (float)$tmp[ 3 ],
                            "proprietario"  => trim( $tmp[ 4 ] ),
                            "tempo_offerta" => (int)$tmp[ 5 ],
                        ];

                        if ( in_array( (int)$tmp[ 0 ], $titolari ) ) {
                            $squadra->titolari[] = new SquadraGiocatoreModel( $calciatore );
                        } elseif ( in_array( (int)$tmp[ 0 ], $panchinari ) ) {
                            $squadra->panchinari[] = new SquadraGiocatoreModel( $calciatore );
                        } else {
                            $squadra->tribuna[] = new SquadraGiocatoreModel( $calciatore );
                        }
                    }
                }
            }
        } catch ( Exception $e ) {
        }

        return $squadra;
    }
}
