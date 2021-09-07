<?php

namespace FCBE\Util;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger as LoggerAlias;

class Logger
{
    public static function info( $message, $context = [] )
    {
        self::getLogger()->notice( $message, (array)$context );
    }

    private static function getLogger(): LoggerAlias
    {
        $logger = new LoggerAlias( "fcbe" );

        $filename = "./logs/log.txt";

        $logRotate = new RotatingFileHandler( $filename );

        $logger->pushHandler( $logRotate );

        return $logger;
    }

    public static function debug( $message, $context = [] )
    {
        self::getLogger()->notice( $message, (array)$context );
    }

    public static function error( $message, $context = [] )
    {
        self::getLogger()->error( $message, (array)$context );
    }

    public static function warning( $message, $context = [] )
    {
        self::getLogger()->warning( $message, (array)$context );
    }
}
