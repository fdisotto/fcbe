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

        // TODO Da reimplementare successivamente
        /*$tornei = [];
        if ( file_exists( $percorso_file ) ) {
            $rows = file( $percorso_file );

            $tornei = unserialize( $rows[ 1 ] );

            foreach ( $tornei as &$torneo ) {
                $torneo->giocatori_registrati = count( Utenti::getUtentiInTorneo( $torneo->id ) );
            }
        }*/
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
                    'nome'                                       => $temp[ 1 ],
                    'partecipanti'                               => $temp[ 2 ],
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
                    'stato_mercato'                              => $temp[ 15 ],
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
                    'aspetta_giorni'                             => (int)$temp[ 28 ],
                    'aspetta_ore'                                => (int)$temp[ 29 ],
                    'aspetta_minuti'                             => (int)$temp[ 30 ],
                    'num_calciatori_scambiabili'                 => (int)$temp[ 31 ],
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
                    'giocatori_registrati'                       => count( Utenti::getUtentiInTorneo( $temp[ 0 ] ) ),
                ] );
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

            $stringa = "$torneo_model->id,$torneo_model->nome,$torneo_model->partecipanti,$torneo_model->serie,$torneo_model->mercato_libero,$torneo_model->tipo_calcolo,$torneo_model->giornate_totali,$torneo_model->ritardo_torneo,$torneo_model->crediti_iniziali,$torneo_model->numero_calciatori,$torneo_model->composizione_squadra,0,0,0,0,$torneo_model->stato_mercato,$torneo_model->modificatore_difesa,$torneo_model->schemi,$torneo_model->max_in_panchina,$torneo_model->panchina_fissa,$torneo_model->max_entrate_dalla_panchina,$torneo_model->sostituisci_per_ruolo,$torneo_model->sostituisci_per_schema,,$torneo_model->numero_cambi_max,$torneo_model->rip_cambi_numero,$torneo_model->rip_cambi_giornate,$torneo_model->rip_cambi_durata,$torneo_model->aspetta_giorni,$torneo_model->aspetta_ore,$torneo_model->aspetta_minuti,$torneo_model->num_calciatori_scambiabili,$torneo_model->scambio_con_soldi,$torneo_model->vendi_costo,$torneo_model->percentuale_vendita,$torneo_model->soglia_voti_primo_gol,$torneo_model->incremento_voti_gol_successivi,$torneo_model->voti_bonus_in_casa,$torneo_model->punti_partita_vinta,$torneo_model->punti_partita_pareggiata,$torneo_model->punti_partita_persa,$torneo_model->differenza_punti_a_parita_gol,$torneo_model->differenza_punti_zero_a_zero,$torneo_model->min_num_titolari_in_formazione,$torneo_model->punti_pareggio,$torneo_model->punti_pos,$torneo_model->reset_scadenz\n";

            if ( ! $filesystem->exists( $percorso_file ) ) {
                $filesystem->touch( $percorso_file );
                $filesystem->chmod( $percorso_file, 0664 );
                $filesystem->appendToFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" );
            }

            $filesystem->appendToFile( $percorso_file, $stringa );

            /*
            $tornei = self::getTornei();

            $tornei[] = $torneo_model;

            if ( ! $filesystem->exists( $percorso_file ) ) {
                $filesystem->touch( $percorso_file );
                $filesystem->chmod( $percorso_file, 0664 );
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $tornei ) );*/

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

            $tornei = file( $percorso_file );
            $riga = 0;
            foreach ( $tornei as $idx => $torneo ) {
                if ( $idx === 0 || empty( $torneo ) ) {
                    continue;
                }

                $tmp = explode( ",", $torneo );

                if ( (int)$tmp[ 0 ] === $torneo_model->id ) {
                    $riga = $idx;
                    break;
                }
            }

            if ( $riga > 0 ) {
                $stringa = "$torneo_model->id,$torneo_model->nome,$torneo_model->partecipanti,$torneo_model->serie,$torneo_model->mercato_libero,$torneo_model->tipo_calcolo,$torneo_model->giornate_totali,$torneo_model->ritardo_torneo,$torneo_model->crediti_iniziali,$torneo_model->numero_calciatori,$torneo_model->composizione_squadra,0,0,0,0,$torneo_model->stato_mercato,$torneo_model->modificatore_difesa,$torneo_model->schemi,$torneo_model->max_in_panchina,$torneo_model->panchina_fissa,$torneo_model->max_entrate_dalla_panchina,$torneo_model->sostituisci_per_ruolo,$torneo_model->sostituisci_per_schema,,$torneo_model->numero_cambi_max,$torneo_model->rip_cambi_numero,$torneo_model->rip_cambi_giornate,$torneo_model->rip_cambi_durata,$torneo_model->aspetta_giorni,$torneo_model->aspetta_ore,$torneo_model->aspetta_minuti,$torneo_model->num_calciatori_scambiabili,$torneo_model->scambio_con_soldi,$torneo_model->vendi_costo,$torneo_model->percentuale_vendita,$torneo_model->soglia_voti_primo_gol,$torneo_model->incremento_voti_gol_successivi,$torneo_model->voti_bonus_in_casa,$torneo_model->punti_partita_vinta,$torneo_model->punti_partita_pareggiata,$torneo_model->punti_partita_persa,$torneo_model->differenza_punti_a_parita_gol,$torneo_model->differenza_punti_zero_a_zero,$torneo_model->min_num_titolari_in_formazione,$torneo_model->punti_pareggio,$torneo_model->punti_pos,$torneo_model->reset_scadenz\n";

                $tornei[ $riga ] = $stringa;
                $nuovo_file = implode( "", $tornei );

                file_put_contents( $percorso_file, $nuovo_file, LOCK_EX );

                Logger::info( "Torneo aggiornato con successo", $torneo_model->toArray() );

                return true;
            }

            /*$tornei = self::getTornei();

            foreach ( $tornei as $idx => $torneo ) {
                if ( $torneo->id === $torneo_model->id ) {
                    $tornei[ $idx ] = $torneo_model;
                }
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $tornei ) );*/

            return false;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante la modifica del torneo", (array)$e );
        }

        return false;
    }

    public static function eliminaTorneo( int $id_torneo ): bool
    {
        global $percorso_cartella_dati;

        try {
            $percorso_file = $percorso_cartella_dati . "/tornei.php";

            $tornei = file( $percorso_file );
            foreach ( $tornei as $idx => $torneo ) {
                if ( $idx === 0 || empty( $torneo ) ) {
                    continue;
                }

                $tmp = explode( ",", $torneo );

                if ( (int)$tmp[ 0 ] === $id_torneo ) {
                    $tornei[ $idx ] = "\n";
                    break;
                }
            }

            $nuovo_file = implode( "", $tornei );

            file_put_contents( $percorso_file, $nuovo_file, LOCK_EX );

            Logger::info( "Torneo eliminato con successo", [ "id" => $id_torneo ] );

            /*
            $filesystem = new Filesystem();

            $tornei = self::getTornei();

            foreach ( $tornei as $idx => $torneo ) {
                if ( $torneo->id === $id_torneo ) {
                    unset( $tornei[ $idx ] );
                }
            }

            $filesystem->dumpFile( $percorso_file, "<?php die('ACCESSO VIETATO');?>\n" . serialize( $tornei ) );*/

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante l'eliminazione del torneo", (array)$e );
        }

        return false;
    }
}
