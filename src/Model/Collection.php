<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model as ModelContract;
use Itsmattch\Nexus\Contract\Model\Collection as CollectionContract;

class Collection implements CollectionContract, \Iterator, \Countable
{
    /**
     * A list of models.
     *
     * @var Model[]
     */
    private array $models;

    /**
     * The position of the iterator.
     *
     * @var int
     */
    private int $position = 0;

    public function addModel(ModelContract $model): void
    {
        $this->models[] = $model;
    }

    /**
     * Return the current element.
     */
    public function current(): Model
    {
        return $this->models[$this->position];
    }

    /**
     * Move forward to the next element.
     */
    public function next(): void
    {
        ++$this->position;
    }

    /**
     * Return the key of the current element.
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Checks if the current position is valid.
     */
    public function valid(): bool
    {
        return isset($this->models[$this->position]);
    }

    /**
     * Rewind the Iterator to the first element.
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Count elements of an object.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->models);
    }
}