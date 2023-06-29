<?php

namespace Itsmattch\Nexus\Contract;

/**
 * Assemblers are responsible for gathering data from
 * multiple resources, and then transforming and shaping
 * that data into a specific model.
 *
 * @link https://nexus.itsmattch.com/the-basics/assembler Assemblers Documentation
 */
interface Assembler
{
    /**
     * todo
     *
     * @param string $name The name of the action.
     * @param Action $action The Action object to be set.
     */
    public function setAction(string $name, Action $action): void;

    /**
     * todo
     *
     * @param Blueprint $blueprint The Blueprint object to
     * be set.
     */
    public function setBlueprint(Blueprint $blueprint): void;

    /**
     * todo
     *
     * @param string $class The fully qualified class name
     * of the Model to be set.
     */
    public function setModel(string $class): void;

    /**
     * Assembles model.
     *
     * @return bool Returns true if the assembling process
     * was successful, false otherwise.
     */
    public function assemble(): bool;

    /**
     * Retrieves the Model produced by the collect() operation.
     */
    public function getModel(): Model;
}