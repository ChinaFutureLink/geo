<?php

namespace Fu\Geo;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\Psr6CacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Monolog\Logger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class HttpStack
{
    /**
     * @return HandlerStack
     */
    public static function getStack(): HandlerStack
    {
        $stack = HandlerStack::create();
//        $stack->push(
//            new CacheMiddleware(
//                new GreedyCacheStrategy(
//                    new DoctrineCacheStorage(
//                        new FilesystemCache('/tmp/cache/')
//                    ),
//                    86400 * 30 * 12
//                )
//            ),
//            'cache'
//        );
        $stack->push(
            new CacheMiddleware(
                new GreedyCacheStrategy(
                    new Psr6CacheStorage(
                        new FilesystemAdapter('geo')
                    ),
                    86400
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
