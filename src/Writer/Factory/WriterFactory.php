<?php

namespace Itsmattch\NexusCore\Writer\Factory;

use Itsmattch\NexusCore\Contract\Writer;
use Itsmattch\NexusCore\Writer\JsonWriter;

/**
 * Static factory class for creating Writer instances.
 */
final class WriterFactory
{
    /**
     * Registry of predefined readers mapped to MIME types.
     */
    private static array $registry = [
        'application/json' => JsonWriter::class,
    ];

    /**
     * Disallows instantiation of the factory.
     */
    private function __construct() {}

    /**
     * Associates an engine class with a scheme.
     */
    public static function set(string $type, string $writer): void
    {
        if (is_subclass_of($writer, Writer::class)) {
            self::$registry[$type] = $writer;
        }
    }

    /**
     * Constructs an Engine based on a scheme of an
     * Address instance.
     */
    public static function from(string $type): ?Writer
    {
        if (isset(self::$registry[$type])) {
            return new self::$registry[$type]();
        }
        return null;
    }
}