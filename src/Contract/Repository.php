<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Model\Collection;

/**
 * todo
 *
 * @link https://nexus.itsmattch.com/the-basics/repository Repositories Documentation
 */
interface Repository
{
    /**
     * @param string $name The name of the action.
     * @param Action $action The Action object to be set.
     */
    public function setAction(string $name, Action $action): void;

    /**
     * @param Blueprint $blueprint The Blueprint object to
     * be set.
     */
    public function setBlueprint(Blueprint $blueprint): void;

    /**
     * @param string $class The fully qualified class name
     * of the Model to be set.
     */
    public function setModel(string $class): void;

    /**
     * Collects models into a Collection.
     *
     * @return bool Returns true if the collection process
     * was successful, false otherwise.
     */
    public function collect(): bool;

    /**
     * Retrieves the Collection of models produced by the
     * collect() operation.
     *
     * @return Collection A Collection object containing all
     * the models collected by this Repository.
     */
    public function getCollection(): Collection;
}