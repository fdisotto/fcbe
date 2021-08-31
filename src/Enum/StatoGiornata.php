<?php

namespace FCBE\Enum;

class StatoGiornata
{
    const APERTA = "A";
    const CHIUSA = "C";

    const STATO_EXT = [
        self::APERTA => "giornata aperta",
        self::CHIUSA => "giornata chiusa",
    ];
}
