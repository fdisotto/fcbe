<?php

namespace FCBE\Util;

use Nette\Caching\Cache as NetteCache;
use Nette\Caching\Storages\FileStorage;
use Throwable;

class Cache
{
    private static ?NetteCache $_instance = null;

    public static function save( string $key, $data, string $expiration = "1 day" )
    {
        return self::getInstance()->save( $key, serialize( $data ), [
            NetteCache::EXPIRATION => $expiration,
        ] );
    }

    private static function getInstance(): ?NetteCache
    {
        if ( is_null( self::$_instance ) ) {
            $fileStorage = new FileStorage( "./cache/data" );
            self::$_instance = new NetteCache( $fileStorage );
        }

        return self::$_instance;
    }

    public static function get( string $key )
    {
        try {
            return unserialize( self::getInstance()->load( $key ) );
        } catch ( Throwable $e ) {
            return null;
        }
    }

    public static function delete( string $key )
    {
        self::getInstance()->remove( $key );
    }
}
