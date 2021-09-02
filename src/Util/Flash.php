<?php

namespace FCBE\Util;

class Flash
{
    const FLASH = 'FLASH_MESSAGES';

    public static function add( string $name, string $message )
    {
        if ( isset( $_SESSION[ self::FLASH ][ $name ] ) ) {
            unset( $_SESSION[ self::FLASH ][ $name ] );
        }
        $_SESSION[ self::FLASH ][ $name ] = [ 'message' => $message ];
    }

    public static function display( string $name ): ?array
    {
        if ( ! isset( $_SESSION[ self::FLASH ][ $name ] ) ) {
            return null;
        }

        $flash_message = $_SESSION[ self::FLASH ][ $name ];

        unset( $_SESSION[ self::FLASH ][ $name ] );

        return $flash_message;
    }
}
