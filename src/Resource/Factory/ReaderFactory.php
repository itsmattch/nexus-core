<?php

namespace Itsmattch\Nexus\Resource\Factory;

use Itsmattch\Nexus\Exceptions\Resource\Factory\InvalidReaderException;
use Itsmattch\Nexus\Exceptions\Resource\Factory\ReaderNotFoundException;
use Itsmattch\Nexus\Resource\Component\Engine\Response;
use Itsmattch\Nexus\Resource\Component\Reader;
use Itsmattch\Nexus\Resource\Reader\JsonReader;

/** Static factory class for creating Reader instances. */
final class ReaderFactory
{
    /** Registry of predefined readers mapped to schemes. */
    private static array $registry = [
        'application/json' => JsonReader::class,
    ];

    /**
     * Associates an engine class with a scheme.
     *
     * @throws InvalidReaderException
     */
    public static function set(string $type, string $reader): void
    {
        if (!is_subclass_of($reader, Reader::class)) {
            throw new InvalidReaderException($reader);
        }
        self::$registry[$type] = $reader;
    }

    /**
     * Constructs an Engine based on a scheme of an
     * Address instance.
     *
     * @throws ReaderNotFoundException
     */
    public static function from(Response $response): Reader
    {
        $type = $response->getType();

        if (!isset(self::$registry[$type])) {
            throw new ReaderNotFoundException($type);
        }

        return new self::$registry[$type]($response);
    }

    /** Disallows instantiation of the factory. */
    private function __construct() {}
}