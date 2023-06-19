<?php

namespace Itsmattch\Nexus\Stream\Factory;

use Itsmattch\Nexus\Exceptions\Stream\Factory\EngineNotFoundException;
use Itsmattch\Nexus\Exceptions\Stream\Factory\NotAnEngineException;
use Itsmattch\Nexus\Stream\Component\Address;
use Itsmattch\Nexus\Stream\Component\Engine;
use Itsmattch\Nexus\Stream\Engine\HttpEngine;

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
     * @param string $scheme The scheme to associate the engine with.
     * @param string $engine The class name of the engine.
     * @throws NotAnEngineException
     */
    public static function set(string $scheme, string $engine): void
    {
        if (!is_subclass_of($engine, Engine::class)) {
            throw new NotAnEngineException($engine);
        }
        self::$registry[$scheme] = $engine;
    }

    /**
     * Constructs an Engine based on a scheme of an
     * Address instance.
     *
     * @param Address $address The address instance to create an engine for.
     * @return Engine The engine instance.
     * @throws EngineNotFoundException
     */
    public static function from(Address $address): Engine
    {
        $scheme = $address->getScheme();

        if (!isset(self::$registry[$scheme])) {
            throw new EngineNotFoundException($scheme);
        }

        return new self::$registry[$scheme]($address);
    }

    /** Disallows instantiation of the factory. */
    private function __construct() {}
}