<?php

namespace FCBE\Util;

class Flash
{
    const FLASH         = 'FLASH_MESSAGES';
    const FLASH_ERROR   = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO    = 'info';
    const FLASH_SUCCESS = 'success';

    public static function add( string $name, string $message, string $type )
    {
        if ( isset( $_SESSION[ self::FLASH ][ $name ] ) ) {
            unset( $_SESSION[ self::FLASH ][ $name ] );
        }
        $_SESSION[ self::FLASH ][ $name ] = [ 'message' => $message, 'type' => $type ];
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
