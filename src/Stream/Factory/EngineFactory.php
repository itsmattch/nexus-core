<?php

namespace Itsmattch\Nexus\Stream\Factory;

use Itsmattch\Nexus\Stream\Component\Address;
use Itsmattch\Nexus\Stream\Component\Engine;
use Itsmattch\Nexus\Stream\Engine\FileEngine;
use Itsmattch\Nexus\Stream\Engine\FtpEngine;
use Itsmattch\Nexus\Stream\Engine\HttpEngine;

final class EngineFactory
{
    private static array $registry = [
        'https' => HttpEngine::class,
        'http' => HttpEngine::class,
        'ftp' => FtpEngine::class,
        'file' => FileEngine::class,
    ];

    public static function set(string $scheme, string $engine): void
    {
        self::$registry[$scheme] = $engine;
    }

    /** todo */
    public static function from(Address $address): Engine
    {
        return new self::$registry[$address->getScheme()]($address);
    }

    private function __construct() {}
}