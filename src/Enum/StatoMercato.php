<?php

namespace FCBE\Enum;

class StatoMercato
{
    const FASE_INIZIALE       = "I";
    const MERCATO_APERTO      = "A";
    const BUSTE_CHIUSE        = "B";
    const MERCATO_RIPARAZIONE = "R";
    const ASTA_PERENNE        = "P";
    const MERCATO_SOSPESO     = "S";
    const MERCATO_CHIUSO      = "C";
    const TORNEO_NON_ATTIVO   = "Z";

    const STATO_EXT = [
        self::FASE_INIZIALE       => "fase iniziale",
        self::MERCATO_APERTO      => "mercato aperto",
        self::BUSTE_CHIUSE        => "buste chiuse",
        self::MERCATO_RIPARAZIONE => "mercato riparazione",
        self::ASTA_PERENNE        => "asta perenne",
        self::MERCATO_SOSPESO     => "mercato sospeso",
        self::MERCATO_CHIUSO      => "mercato chiuso",
        self::TORNEO_NON_ATTIVO   => "torneo non attivo",
    ];
}
