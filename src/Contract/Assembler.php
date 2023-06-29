<?php

namespace Itsmattch\Nexus\Contract;

/** todo */
interface Assembler
{
    /** todo */
    public function addResource(string $name, array $resource): void;

    /** todo */
    public function setModel(Model $model): void;

    /** todo */
    public function assemble(): bool;
}