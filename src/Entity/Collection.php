<?php

namespace Itsmattch\NexusCore\Entity;

use Itsmattch\NexusCore\Contract\Entity as EntityContract;
use Itsmattch\NexusCore\Contract\Entity\Collection as CollectionContract;

class Collection implements CollectionContract, \Iterator, \Countable
{
    /**
     * @var array<Entity> A list of entities.
     */
    private array $entities;

    /**
     * The position of the iterator.
     */
    private int $position = 0;

    public function addEntity(EntityContract $entity): void
    {
        $this->entities[] = $entity;
    }

    public function current(): Entity
    {
        return $this->entities[$this->position];
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function valid(): bool
    {
        return isset($this->entities[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return count($this->entities);
    }
}