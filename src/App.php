<?php

namespace FCBE;

class App
{
    const VERSION = "1.6.22-dev";

    public static function getVersion(): string
    {
        return self::VERSION;
    }
}
