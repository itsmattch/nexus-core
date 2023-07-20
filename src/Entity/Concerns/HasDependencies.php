<?php

namespace Itsmattch\Nexus\Entity\Concerns;

/**
 * Allows the entities to define and manage dependencies.
 */
trait HasDependencies
{
    /**
     * A preset definition of dependencies.
     */
    protected array $dependencies = [];

    protected function bootDependencies(): void
    {
        // todo
    }
}