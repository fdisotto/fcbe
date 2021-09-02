<?php

namespace FCBE\Model;

use FCBE\Enum\StatoMercato;
use FCBE\Enum\TipoCalcolo;

class TorneoModel extends BaseModel
{
    public int    $id                             = 0;
    public string $nome                           = "";
    public int    $partecipanti                   = 0;
    public int    $serie                          = 0;
    public string $mercato_libero                 = "SI";
    public string $tipo_calcolo                   = TipoCalcolo::SOMMA_VOTI;
    public int    $giornate_totali                = 38;
    public int    $ritardo_torneo                 = 0;
    public int    $crediti_iniziali               = 250;
    public int    $numero_calciatori              = 25;
    public string $composizione_squadra           = "38806";
    public string $modificatore_difesa            = "NO";
    public string $stato_mercato                  = StatoMercato::FASE_INIZIALE;
    public string $schemi                         = "";
    public int    $max_in_panchina                = 0;
    public string $panchina_fissa                 = "NO";
    public int    $max_entrate_dalla_panchina     = 0;
    public string $sostituisci_per_ruolo          = "SI";
    public string $sostituisci_per_schema         = "NO";
    public int    $numero_cambi_max               = 0;
    public int    $rip_cambi_numero               = 0;
    public string $rip_cambi_giornate             = "";
    public int    $rip_cambi_durata               = 0;
    public int    $aspetta_giorni                 = 0;
    public int    $aspetta_ore                    = 0;
    public int    $aspetta_minuti                 = 0;
    public int    $num_calciatori_scambiabili     = 0;
    public string $reset_scadenz                  = "NO";
    public string $scambio_con_soldi              = "NO";
    public string $vendi_costo                    = "NO";
    public float  $percentuale_vendita            = 0;
    public float  $soglia_voti_primo_gol          = 0;
    public float  $incremento_voti_gol_successivi = 0;
    public float  $voti_bonus_in_casa             = 0;
    public float  $punti_partita_vinta            = 0;
    public float  $punti_partita_pareggiata       = 0;
    public float  $punti_partita_persa            = 0;
    public float  $differenza_punti_a_parita_gol  = 0;
    public float  $differenza_punti_zero_a_zero   = 0;
    public int    $min_num_titolari_in_formazione = 0;
    public string $punti_pareggio                 = "M";
    public string $punti_pos                      = "";
    public int    $giocatori_registrati           = 0;
}
