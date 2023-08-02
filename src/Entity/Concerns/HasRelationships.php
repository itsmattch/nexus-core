<?php

namespace Itsmattch\NexusCore\Entity\Concerns;

/**
 * Allows the entities to define and manage relationships.
 */
trait HasRelationships
{
    /**
     * A preset definition of relationships.
     */
    protected array $relationships = [];

    protected function bootRelationships(): void
    {
        // todo
    }
}