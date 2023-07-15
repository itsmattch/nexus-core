<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Contract\Assembler as AssemblerContract;
use Itsmattch\Nexus\Contract\Entity;

abstract class Assembler implements AssemblerContract
{
    /**
     * Fully qualified class name of an entity
     * that this repository discovers.
     */
    protected string $entity = Entity::class;

    /**
     * Fully qualified class names of the resources this
     * repository uses to discover entities.
     */
    protected array $resources = [];
}