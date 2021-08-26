<?php

namespace FCBE\Util;

use FCBE\Model\TorneoModel;

class Tornei
{
    public static function getTorneo( $id_torneo )
    {
        $tornei = self::get_tornei();

        return array_search( $id_torneo, array_column( $tornei, 'id' ) );
    }

    /**
     * @return TorneoModel[]
     */
    public static function get_tornei(): iterable
    {
        global $percorso_cartella_dati;

        if ( $tornei = Cache::get( "tornei" ) ) {
            return $tornei;
        }

        $percorso_file = $percorso_cartella_dati . "/tornei.php";

        $tornei = [];
        if ( file_exists( $percorso_file ) ) {
            $rows = explode( "\n", file_get_contents( $percorso_file ) );

            foreach ( $rows as $idx => $row ) {
                if ( $idx == 0 || empty( trim( $row ) ) ) {
                    continue;
                }

                $temp = explode( ",", $row );

                $tornei[] = new TorneoModel( [
                    'id'                                         => $temp[ 0 ],
                    'denom'                                      => $temp[ 1 ],
                    'part'                                       => $temp[ 2 ],
                    'serie'                                      => $temp[ 3 ],
                    'mercato_libero'                             => $temp[ 4 ],
                    'tipo_calcolo'                               => $temp[ 5 ],
                    'giornate_totali'                            => $temp[ 6 ],
                    'ritardo_torneo'                             => $temp[ 7 ],
                    'crediti_iniziali'                           => $temp[ 8 ],
                    'numcalciatori'                              => $temp[ 9 ],
                    'composizione_squadra'                       => $temp[ 10 ],
                    'temp1'                                      => $temp[ 11 ],
                    'temp2'                                      => $temp[ 12 ],
                    'temp3'                                      => $temp[ 13 ],
                    'temp4'                                      => $temp[ 14 ],
                    'stato'                                      => $temp[ 15 ],
                    'modificatore_difesa'                        => $temp[ 16 ],
                    'schemi'                                     => $temp[ 17 ],
                    'max_in_panchina'                            => $temp[ 18 ],
                    'panchina_fissa'                             => $temp[ 19 ],
                    'max_entrate_dalla_panchina'                 => $temp[ 20 ],
                    'sostituisci_per_ruolo'                      => $temp[ 21 ],
                    'sostituisci_per_schema'                     => $temp[ 22 ],
                    'sostituisci_fantasisti_come_centrocampisti' => $temp[ 23 ],
                    'numero_cambi_max'                           => $temp[ 24 ],
                    'rip_cambi_numero'                           => $temp[ 25 ],
                    'rip_cambi_giornate'                         => $temp[ 26 ],
                    'rip_cambi_durata'                           => $temp[ 27 ],
                    'aspetta_giorni'                             => $temp[ 28 ],
                    'aspetta_ore'                                => $temp[ 29 ],
                    'aspetta_minuti'                             => $temp[ 30 ],
                    'num_calciatori_scambiabili'                 => $temp[ 31 ],
                    'scambio_con_soldi'                          => $temp[ 32 ],
                    'vendi_costo'                                => $temp[ 33 ],
                    'percentuale_vendita'                        => $temp[ 34 ],
                    'soglia_voti_primo_gol'                      => $temp[ 35 ],
                    'incremento_voti_gol_successivi'             => $temp[ 36 ],
                    'voti_bonus_in_casa'                         => $temp[ 37 ],
                    'punti_partita_vinta'                        => $temp[ 38 ],
                    'punti_partita_pareggiata'                   => $temp[ 39 ],
                    'punti_partita_persa'                        => $temp[ 40 ],
                    'differenza_punti_a_parita_gol'              => $temp[ 41 ],
                    'differenza_punti_zero_a_zero'               => $temp[ 42 ],
                    'min_num_titolari_in_formazione'             => $temp[ 43 ],
                    'punti_pareggio'                             => $temp[ 44 ],
                    'punti_pos'                                  => $temp[ 45 ],
                    'reset_scadenz'                              => $temp[ 46 ],
                ] );
            }

            Cache::save( "tornei", $tornei );
        }

        return $tornei;
    }
}
