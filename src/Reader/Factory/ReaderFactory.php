<?php

namespace Itsmattch\Nexus\Reader\Factory;

use Itsmattch\Nexus\Contract\Reader;
use Itsmattch\Nexus\Reader\JsonReader;

/**
 * Static factory class for creating Reader instances.
 */
final class ReaderFactory
{
    /**
     * Registry of predefined readers mapped to MIME types.
     */
    private static array $registry = [
        'application/json' => JsonReader::class,
    ];

    /**
     * Disallows instantiation of the factory.
     */
    private function __construct() {}

    /**
     * Associates an engine class with a scheme.
     */
    public static function set(string $type, string $reader): void
    {
        if (is_subclass_of($reader, Reader::class)) {
            self::$registry[$type] = $reader;
        }
    }

    /**
     * Constructs an Engine based on a scheme of an
     * Address instance.
     */
    public static function from(string $type): ?Reader
    {
        if (isset(self::$registry[$type])) {
            return new self::$registry[$type]();
        }
        return null;
    }
}