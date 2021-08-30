<?php

namespace FCBE\Util;

class Voti
{
    public static function getFileVoti( int $giornata ): ?string
    {
        global $percorso_cartella_dati, $cartella_remota;

        $giornata = str_pad( $giornata, 2, "0", STR_PAD_LEFT );

        $percorso_file = sprintf( "%s/%s/MCC%s.txt", $percorso_cartella_dati, $cartella_remota, $giornata );

        if ( file_exists( $percorso_file ) ) {
            return $percorso_file;
        }

        return null;
    }
}
