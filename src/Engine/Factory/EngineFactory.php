<?php

namespace Itsmattch\Nexus\Engine\Factory;

use Itsmattch\Nexus\Contract\Engine;
use Itsmattch\Nexus\Engine\Concrete\HttpEngine;

/** Static factory class for creating Engine instances. */
final class EngineFactory
{
    /** Registry of predefined engines mapped to schemes. */
    private static array $registry = [
        'https' => HttpEngine::class,
        'http' => HttpEngine::class,
    ];

    /**
     * Associates an engine class with a scheme.
     *
     * @param string $scheme The scheme.
     * @param string $engine A fully qualified class name
     * of a class extending Engine contract.
     */
    public static function set(string $scheme, string $engine): void
    {
        if (is_subclass_of($engine, Engine::class)) {
            self::$registry[$scheme] = $engine;
        }
    }

    /**
     * Creates an Engine based on a scheme.
     *
     * @param string $scheme The scheme.
     *
     * @return ?Engine The engine instance.
     */
    public static function from(string $scheme): ?Engine
    {
        if (isset(self::$registry[$scheme])) {
            return new self::$registry[$scheme]();
        }
        return null;
    }

    /** Disallows instantiation of the factory. */
    private function __construct() {}
}