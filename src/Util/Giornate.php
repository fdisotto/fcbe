<?php

namespace FCBE\Util;

class Giornate
{
    /**
     * @return array
     */
    public static function getGiornateGiocate(): array
    {
        global $prima_parte_pos_file_voti, $seconda_parte_pos_file_voti;

        $files = glob($prima_parte_pos_file_voti . "*" . $seconda_parte_pos_file_voti);

        $giornate = [];
        foreach ($files as $file) {
            $giornata = str_replace($prima_parte_pos_file_voti, "", $file);
            $giornata = str_replace($seconda_parte_pos_file_voti, "", $giornata);

            $giornate[] = $giornata;
        }

        return $giornate;
    }
}
