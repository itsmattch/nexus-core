<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Model\Collection;

interface Repository
{
    /** todo */
    public function setAction(string $name, Action $action): void;

    /** todo */
    public function setBlueprint(Blueprint $blueprint): void;

    /** todo */
    public function setModel(string $class): void;

    /** todo */
    public function collect(): bool;

    /** todo */
    public function getCollection(): Collection;
}