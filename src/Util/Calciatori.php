<?php

namespace FCBE\Util;

use FCBE\Enum\RuoloEnum;
use FCBE\Model\CalciatoreModel;

class Calciatori
{
    /**
     * @param int $giornata
     * @return CalciatoreModel[]
     */
    public static function getCalciatoriGiornata( int $giornata ): iterable
    {
        global $prima_parte_pos_file_voti, $seconda_parte_pos_file_voti, $separatore_campi_file_calciatori;

        $cacheKey = sprintf( "mcc_%s", $giornata );

        if ( $calciatori = Cache::get( $cacheKey ) ) {
            return $calciatori;
        }

        $percorso_file = sprintf( "%s%s%s", $prima_parte_pos_file_voti, str_pad( $giornata, 2, "0", STR_PAD_LEFT ), $seconda_parte_pos_file_voti );

        $calciatori = [];
        if ( file_exists( $percorso_file ) ) {
            $rows = explode( "\n", file_get_contents( $percorso_file ) );

            foreach ( $rows as $row ) {
                if ( empty( trim( $row ) ) ) {
                    continue;
                }

                $temp = explode( $separatore_campi_file_calciatori, $row );

                $calciatori[] = new CalciatoreModel( [
                    "codice"           => (int)$temp[ 0 ],
                    "giornata"         => (int)$temp[ 1 ],
                    "nome"             => trim( $temp[ 2 ], '"' ),
                    "squadra"          => trim( $temp[ 3 ], '"' ),
                    "attivo"           => (int)$temp[ 4 ],
                    "ruolo"            => RuoloEnum::RUOLI[ $temp[ 5 ] ],
                    "presenza"         => (int)$temp[ 6 ],
                    "voto_fc"          => (float)$temp[ 7 ],
                    "min_inf_25"       => (int)$temp[ 8 ],
                    "min_sup_25"       => (int)$temp[ 9 ],
                    "voto"             => (float)$temp[ 10 ],
                    "gol_segnati"      => (int)$temp[ 11 ],
                    "gol_subiti"       => (int)$temp[ 12 ],
                    "gol_vittoria"     => (int)$temp[ 13 ],
                    "gol_pareggio"     => (int)$temp[ 14 ],
                    "assist"           => (int)$temp[ 15 ],
                    "ammonizione"      => (int)$temp[ 16 ],
                    "espulsione"       => (int)$temp[ 17 ],
                    "rigore_tirato"    => (int)$temp[ 18 ],
                    "rigore_subito"    => (int)$temp[ 19 ],
                    "rigore_parato"    => (int)$temp[ 20 ],
                    "rigore_sbagliato" => (int)$temp[ 21 ],
                    "autogol"          => (int)$temp[ 22 ],
                    "entrato"          => (int)$temp[ 23 ],
                    "titolare"         => (int)$temp[ 24 ],
                    "sv"               => (int)$temp[ 25 ],
                    "casa"             => (int)$temp[ 26 ],
                    "valore"           => (int)$temp[ 27 ],
                ] );
            }

            Cache::save( $cacheKey, $calciatori );
        }

        return $calciatori;
    }
}
