<?php

namespace FCBE\Util;

class Response
{
    public static function redirect( string $page )
    {
        if ( headers_sent() ) {
            echo "<meta http-equiv='refresh' content='0; url=" . $page . "'>";
        } else {
            header( "Location: " . $page );
        }
        exit;
    }
}
