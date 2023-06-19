<?php

namespace Itsmattch\Nexus\Stream\Factory;

use Itsmattch\Nexus\Exceptions\Stream\Factory\NotAReaderException;
use Itsmattch\Nexus\Exceptions\Stream\Factory\ReaderNotFoundException;
use Itsmattch\Nexus\Stream\Component\Engine\Response;
use Itsmattch\Nexus\Stream\Component\Reader;
use Itsmattch\Nexus\Stream\Component\Resource;
use Itsmattch\Nexus\Stream\Reader\JsonReader;

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
     * todo
     * @throws NotAReaderException
     */
    public static function set(string $type, string $reader): void
    {
        if (!is_subclass_of($reader, Reader::class)) {
            throw new NotAReaderException($reader);
        }
        self::$registry[$type] = $reader;
    }

    /**
     * Constructs an Engine based on a scheme of an
     * Address instance.
     *
     * todo
     * @throws ReaderNotFoundException
     */
    public static function from(Response $response, Resource $resource): Reader
    {
        $type = $response->getType();

        if (!isset(self::$registry[$type])) {
            throw new ReaderNotFoundException($type);
        }

        return new self::$registry[$type]($response, $resource);
    }

    /** Disallows instantiation of the factory. */
    private function __construct() {}
}