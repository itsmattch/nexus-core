<?php

namespace Itsmattch\Nexus\Contract\Model;

interface Badge
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getKeys(): array;

    public function addKeys(string ...$names): void;

    public function hasKey(string $name): bool;

    public function equals(Badge $badge): bool;

    public function setIdentity(Identity $identity): void;

    public function getIdentity(): ?Identity;
}