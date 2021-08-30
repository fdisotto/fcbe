<?php

namespace FCBE\Enum;

use ReflectionClass;
use ReflectionException;

abstract class BaseEnum
{
    private static $constCacheArray = null;

    public static function isValidName( $name, $strict = false ): bool
    {
        $constants = self::getConstants();

        if ( $strict ) {
            return array_key_exists( $name, $constants );
        }

        $keys = array_map( 'strtolower', array_keys( $constants ) );

        return in_array( strtolower( $name ), $keys );
    }

    public static function getConstants()
    {
        if ( self::$constCacheArray == null ) {
            self::$constCacheArray = [];
        }
        $calledClass = get_called_class();
        if ( ! array_key_exists( $calledClass, self::$constCacheArray ) ) {
            try {
                $reflect = new ReflectionClass( $calledClass );
            } catch ( ReflectionException $e ) {
                return null;
            }
            self::$constCacheArray[ $calledClass ] = $reflect->getConstants();
        }

        return self::$constCacheArray[ $calledClass ];
    }

    public static function isValidValue( $value, $strict = true ): bool
    {
        $values = array_values( self::getConstants() );

        return in_array( $value, $values, $strict );
    }
}
