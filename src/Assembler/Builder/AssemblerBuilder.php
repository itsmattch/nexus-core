<?php

namespace Itsmattch\NexusCore\Assembler\Builder;

use Closure;
use Itsmattch\NexusCore\Contract\Assembler\Builder\AssemblerBuilder as AssemblerBuilderContract;
use Itsmattch\NexusCore\Contract\Assembler\Builder\Callable\Invokable;

abstract class AssemblerBuilder implements AssemblerBuilderContract
{
    /**
     * Stack of callable transformations
     * to be applied to the array.
     */
    protected array $callableStack = [];

    public function callable(Closure|Invokable $callable): void
    {
        $this->callableStack[] = $callable;
    }
}