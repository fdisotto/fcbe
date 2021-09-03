<?php

namespace FCBE\Model;

class SquadraGiocatoreModel extends BaseModel
{
    public int    $codice;
    public string $nome;
    public string $ruolo;
    public float  $valore;
    public string $proprietario;
    public int    $tempo_offerta;
}
