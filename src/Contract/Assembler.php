<?php

namespace Itsmattch\NexusCore\Contract;

/** todo */
interface Assembler
{
    /** todo */
    public function addResource(string $name, array $resource): void;

    /** todo */
    public function assemble(): bool;
}