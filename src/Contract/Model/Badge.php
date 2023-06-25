<?php

namespace Itsmattch\Nexus\Contract\Model;

/** Represents a set of data that the model can identify with */
interface Badge
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getKeys(): array;

    public function addKey(string $name): void;

    public function hasKey(string $name): bool;

    public function equals(Badge $badge): bool;
}