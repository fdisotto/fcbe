<?php

namespace FCBE\Util;

class Giornate
{
    public static function getProssima(): string
    {
        $giornate = self::getGiornateGiocate();

        return ! empty( $giornate ) ? str_pad( $giornate[ count( $giornate ) - 1 ] + 1, 2, "0", STR_PAD_LEFT ) : "01";
    }

    /**
     * @return array
     */
    public static function getGiornateGiocate(): array
    {
        global $percorso_cartella_dati;
        $files = glob( $percorso_cartella_dati . "/*_*_0" );

        $giornate = [];
        foreach ( $files as $file ) {
            preg_match( "/\/giornata(.*)_(.*)_(.*)/i", $file, $tmp );

            $giornate[] = $tmp[ 1 ];
        }

        return $giornate;
    }

    public static function getCorrente(): string
    {
        $giornate = self::getGiornateGiocate();

        return ! empty( $giornate ) ? str_pad( $giornate[ count( $giornate ) - 1 ], 2, "0", STR_PAD_LEFT ) : "00";
    }
}
