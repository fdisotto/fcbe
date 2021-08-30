<?php

namespace FCBE\Model;

class TorneoModel extends BaseModel
{
    public int $id;
    public string $denom;
    public int $part;
    public int $serie;
    public $mercato_libero;
    public $tipo_calcolo;
    public $giornate_totali;
    public $ritardo_torneo;
    public $crediti_iniziali;
    public $numcalciatori;
    public $composizione_squadra;
    public $temp1;
    public $temp2;
    public $temp3;
    public $temp4;
    public $stato;
    public $modificatore_difesa;
    public $schemi;
    public $max_in_panchina;
    public $panchina_fissa;
    public $max_entrate_dalla_panchina;
    public $sostituisci_per_ruolo;
    public $sostituisci_per_schema;
    public $sostituisci_fantasisti_come_centrocampisti;
    public $numero_cambi_max;
    public $rip_cambi_numero;
    public $rip_cambi_giornate;
    public $rip_cambi_durata;
    public int $aspetta_giorni;
    public int $aspetta_ore;
    public int $aspetta_minuti;
    public $num_calciatori_scambiabili;
    public $scambio_con_soldi;
    public $vendi_costo;
    public $percentuale_vendita;
    public $soglia_voti_primo_gol;
    public $incremento_voti_gol_successivi;
    public $voti_bonus_in_casa;
    public $punti_partita_vinta;
    public $punti_partita_pareggiata;
    public $punti_partita_persa;
    public $differenza_punti_a_parita_gol;
    public $differenza_punti_zero_a_zero;
    public $min_num_titolari_in_formazione;
    public $punti_pareggio;
    public $punti_pos;
    public $reset_scadenz;
    public int $num_giocatori;
}
