<?php

namespace FCBE\Util;

use Alchemy\Zippy\Zippy;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

class File
{
    public static function move( string $origin, string $target ): bool
    {
        try {
            $filesystem = new Filesystem();

            $filesystem->copy( $origin, $target );

            return true;
        } catch ( Exception $e ) {
            Logger::error( "Errore durante la copia del file!", $e );
        }

        return false;
    }

    public static function exist( string $file ): bool
    {
        $filesystem = new Filesystem();

        return $filesystem->exists( $file );
    }

    public static function delete( string $file ): bool
    {
        try {
            $filesystem = new Filesystem();
            $filesystem->remove( $file );

            return true;
        } catch ( Exception $e ) {
            return false;
        }
    }

    public static function bytesInMB( int $bytes ): string
    {
        return number_format( self::bytesInKB( $bytes ) / 1024, 3 );
    }

    public static function bytesInKB( int $bytes ): string
    {
        return number_format( $bytes / 1024, 3 );
    }

    public static function creaZip( string $location, string $path ): bool
    {
        try {
            $zip = Zippy::load();
            $zip->create( $location, $path, true );

            return true;
        } catch ( Exception $e ) {
            return false;
        }
    }

    public static function glob( $pattern, $flags = 0 )
    {
        $files = glob( $pattern, $flags );
        foreach ( glob( dirname( $pattern ) . '/*', GLOB_ONLYDIR | GLOB_NOSORT ) as $dir ) {
            $files = array_merge( $files, self::glob( $dir . '/' . basename( $pattern ), $flags ) );
        }

        return $files;
    }

    public static function estraiZip( string $location, string $zipFile ): bool
    {
        try {
            $zip = Zippy::load();
            $archive = $zip->open( $zipFile );
            $archive->extract( $location );

            return true;
        } catch ( Exception $e ) {
            return false;
        }
    }
}
