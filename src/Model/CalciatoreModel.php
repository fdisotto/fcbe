<?php

namespace FCBE\Model;

class CalciatoreModel extends BaseModel
{
    public int    $codice;
    public int    $giornata;
    public string $nome;
    public string $squadra;
    public int    $attivo;
    public string $ruolo;
    public int    $presenza;
    public float  $voto_fc;
    public int    $min_inf_25;
    public int    $min_sup_25;
    public float  $voto;
    public int    $golsegnati;
    public int    $golsubiti;
    public int    $golvittoria;
    public int    $golpareggio;
    public int    $assist;
    public int    $ammonizione;
    public int    $espulsione;
    public int    $rigoretirato;
    public int    $rigoresubito;
    public int    $rigoreparato;
    public int    $rigoresbagliato;
    public int    $autogol;
    public int    $entrato;
    public int    $titolare;
    public int    $sv;
    public int    $casa;
    public int    $valore;
}
