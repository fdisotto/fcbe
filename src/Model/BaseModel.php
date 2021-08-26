<?php

namespace FCBE\Model;

use Exception;
use ReflectionClass;
use stdClass;

class BaseModel extends stdClass
{

    /**
     * Base constructor.
     * @param array $attributes
     */
    public function __construct( array $attributes = array() )
    {
        $this->fillWithArray( $attributes );
    }

    public function fillWithArray( array $attributes = array() )
    {
        foreach ( $attributes as $name => $value ) {
            if ( property_exists( $this, $name ) ) {
                $this->{$name} = $value;
            }
        }
    }

    public static function __set_state( $an_array )
    {
        $calledClass = get_called_class();

        return new $calledClass( $an_array );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $reflectionClass = new ReflectionClass( get_class( $this ) );
        $array = array();
        foreach ( $reflectionClass->getProperties() as $property ) {
            $property->setAccessible( true );
            $array[ $property->getName() ] = $property->getValue( $this );
            $property->setAccessible( false );
        }

        return $array;
    }
}
