<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model as ModelContract;
use Itsmattch\Nexus\Contract\Model\Collection as CollectionContract;

class Collection implements CollectionContract, \Iterator, \Countable
{
    /**
     * @var Model[] A list of models.
     */
    private array $models;

    /**
     * The position of the iterator.
     */
    private int $position = 0;

    public function addModel(ModelContract $model): void
    {
        $this->models[] = $model;
    }

    public function current(): Model
    {
        return $this->models[$this->position];
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
        return isset($this->models[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = 0;
    }

    public function count(): int
    {
        return count($this->models);
    }
}