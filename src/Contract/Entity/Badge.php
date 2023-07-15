<?php

namespace Itsmattch\Nexus\Contract\Entity;

interface Badge
{
    public function getName(): string;

    public function setName(string $name): void;

    public function equals(Badge $badge): bool;

    public function setIdentity(Identity $identity): void;

    public function getIdentity(): ?Identity;
}