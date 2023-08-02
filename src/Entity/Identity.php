<?php

namespace Itsmattch\NexusCore\Entity;

use Itsmattch\NexusCore\Contract\Entity\Identity as IdentityContract;

class Identity implements IdentityContract
{
    /**
     * @var array A list of identity keys.
     */
    protected array $keys = [];

    /**
     * @var array A list of key-value pairs.
     */
    protected array $values = [];

    public function addKeys(string ...$names): void
    {
        $this->keys = array_merge($this->keys, $names);
    }

    public function hasKey(string $key): bool
    {
        return in_array($key, $this->keys);
    }

    public function getKeys(): array
    {
        return $this->keys;
    }

    public function getValues(): array
    {
        return $this->values;
    }

    public function getValue(string $key): ?string
    {
        return $this->values[$key] ?? null;
    }

    public function setValue(string $key, string $value): void
    {
        $this->keys[] = $key;
        $this->values[$key] = $value;
    }
}