<?php

namespace Itsmattch\NexusCore\Assembler;

use Itsmattch\NexusCore\Contract\Assembler as AssemblerContract;
use Itsmattch\NexusCore\Contract\Entity;

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