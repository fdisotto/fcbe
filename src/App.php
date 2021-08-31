<?php

namespace FCBE;

class App
{
    const VERSION = "2.0.22-dev";

    public static function getVersion(): string
    {
        return self::VERSION;
    }
}
