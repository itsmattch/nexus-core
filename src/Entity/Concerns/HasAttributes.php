<?php

namespace Itsmattch\Nexus\Entity\Concerns;

/** todo */
trait HasAttributes
{
    /** todo */
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