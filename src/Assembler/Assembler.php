<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Contract\Assembler as AssemblerContract;
use Itsmattch\Nexus\Contract\Model;

abstract class Assembler implements AssemblerContract
{
    /**
     * Fully qualified class name of a model
     * that this repository discovers.
     */
    protected string $model = Model::class;

    /**
     * Fully qualified class names of the resources this
     * repository uses to discover models.
     */
    protected array $resources = [];
}