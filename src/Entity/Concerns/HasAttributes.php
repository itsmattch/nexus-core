<?php

namespace Itsmattch\NexusCore\Entity\Concerns;

/**
 * Allows the entities to define and manage attributes.
 */
trait HasAttributes
{
    /**
     * A preset definition of attributes.
     */
    protected array $attributes = [];

    /** todo */
    private array $internalAttributes = [];

    public function bootAttributes(): void
    {
        // todo
    }

    /** todo */
    public function setAttribute(string $name, mixed $value): void
    {
        // json => object/array recursively JsonSerializable
        // null => 'null'/is_null
        // bool => 'true'/'false'/is_bool
        // int => is_int/ctype_digit
        // float => is_numeric
        // string
        // null
    }
}