<?php

namespace Itsmattch\Nexus\Contract\Model;

interface Identity
{
    public function getValues(): array;

    public function getValue(string $key): ?string;

    public function setValue(string $key, string $value): void;

    public function hasKey(string $key): bool;

    public function getKeys(): array;
}