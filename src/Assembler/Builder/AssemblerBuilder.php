<?php

namespace Itsmattch\Nexus\Assembler\Builder;

use Closure;
use Itsmattch\Nexus\Contract\Assembler\Builder\AssemblerBuilder as AssemblerBuilderContract;
use Itsmattch\Nexus\Contract\Assembler\Builder\Callable\Invokable;

class AssemblerBuilder implements AssemblerBuilderContract
{
    /**
     * Stack of callable transformations
     * to be applied to the array.
     */
    private array $callableStack = [];

    public function callable(Closure|Invokable $callable): void
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