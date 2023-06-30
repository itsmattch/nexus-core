<?php

namespace Itsmattch\Nexus\Contract\Assembler\Builder;

/** todo */
interface AssemblerBuilder
{
    /** todo */
    public function callable(callable $callable): void;

    /** todo */
    public function call(array $array): array;
}