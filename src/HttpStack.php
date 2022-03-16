<?php

namespace Fu\Geo;

use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Monolog\Logger;

class HttpStack
{
    /**
     * @return HandlerStack
     */
    public static function getStack(): HandlerStack
    {
        $stack = HandlerStack::create();
        $stack->push(
            new CacheMiddleware(
                new GreedyCacheStrategy(
                    new DoctrineCacheStorage(
                        new FilesystemCache('/tmp/cache/')
                    ),
                    86400 * 30 * 12
                )
            ),
            'cache'
        );
        $stack->push(
            Middleware::log(
                AppLogger::getLog(),
                new MessageFormatter(),
                Logger::DEBUG
            )
        );
        return $stack;
    }
}
