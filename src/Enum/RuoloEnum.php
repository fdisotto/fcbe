<?php

namespace FCBE\Enum;

class RuoloEnum extends BaseEnum
{
    const PORTIERE       = "P";
    const DIFENSORE      = "D";
    const CENTROCAMPISTA = "C";
    const ATTACCANTE     = "A";

    const RUOLI = [
        0 => self::PORTIERE,
        1 => self::DIFENSORE,
        2 => self::CENTROCAMPISTA,
        3 => self::ATTACCANTE,
    ];

    const RUOLI_EXT = [
        self::PORTIERE       => "portiere",
        self::DIFENSORE      => "difensore",
        self::CENTROCAMPISTA => "centrocampista",
        self::ATTACCANTE     => "attaccante",
    ];
}
