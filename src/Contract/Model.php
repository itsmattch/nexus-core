<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Model\Identity;

interface Model
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getIdentities(): array;

    public function addIdentity(Identity $identity): void;

    public function hasIdentity(Identity $identity): bool;
}