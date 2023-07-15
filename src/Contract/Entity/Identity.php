<?php

namespace Itsmattch\Nexus\Contract\Entity;

interface Identity
{
    public function addKeys(string ...$names): void;

    public function hasKey(string $key): bool;

    public function getKeys(): array;

    public function getValues(): array;

    public function getValue(string $key): ?string;

    public function setValue(string $key, string $value): void;
}