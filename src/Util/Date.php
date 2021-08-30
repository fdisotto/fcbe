<?php

namespace FCBE\Util;

class Date
{
    public static function formatDate( int $timestamp ): ?string
    {
        return date( "d-m-Y H:i", $timestamp );
    }
}
