<?php

namespace FCBE\Enum;

class TipoCalcolo
{
    const SOMMA_VOTI      = "V";
    const SOMMA_PUNTI     = "P";
    const SCONTRI_DIRETTI = "S";
    const NESSUN_CALCOLO  = "N";

    const TIPO_EXT = [
        self::SOMMA_VOTI      => "somma voti",
        self::SOMMA_PUNTI     => "somma punti",
        self::SCONTRI_DIRETTI => "scontri diretti",
        self::NESSUN_CALCOLO  => "nessun calcolo",
    ];
}
