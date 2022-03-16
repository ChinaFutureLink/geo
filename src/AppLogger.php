<?php

namespace Fu\Geo;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppLogger
{
    /**
     * @return Logger
     */
    public static function getLog(): Logger
    {
        $log = new Logger('geo');
//        $log->pushHandler(new StreamHandler('/tmp/geo.log', Logger::DEBUG));
        $log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
        return $log;
    }
}