<?php

namespace FCBE\Model;

class UtenteModel extends BaseModel
{
    public int    $id         = 0;
    public string $utente     = "";
    public string $pass       = "";
    public int    $permessi   = -1;
    public string $email      = "";
    public string $url        = "";
    public string $squadra    = "";
    public int    $torneo     = 0;
    public int    $serie      = 0;
    public string $citta      = "";
    public int    $crediti    = 0;
    public int    $variazioni = 0;
    public int    $cambi      = 0;
    public string $reg        = "";
    public int    $titolari   = 0;
    public int    $panchina   = 0;
    public string $nome       = "";
    public string $cognome    = "";
}
