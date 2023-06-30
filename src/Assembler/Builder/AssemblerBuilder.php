<?php

namespace Itsmattch\Nexus\Assembler\Builder;

use Itsmattch\Nexus\Contract\Assembler\Builder\AssemblerBuilder as AssemblerBuilderContract;

/** todo */
class AssemblerBuilder implements AssemblerBuilderContract
{
    private array $callableStack;

    public function callable(callable $callable): void
    {
        $this->callableStack[] = $callable;
    }

    public function call(array $array): array
    {
        $workingArray = [];
        foreach ($this->callableStack as $callable) {
            $workingArray = $callable($workingArray, $array);
        }
        return $workingArray;
    }
}