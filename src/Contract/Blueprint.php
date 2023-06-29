<?php

namespace Itsmattch\Nexus\Contract;

/**
 * Blueprints are responsible for transforming raw resource
 * data into structured model data.
 *
 * @link https://nexus.itsmattch.com/the-basics/blueprint Blueprints Documentation
 */
interface Blueprint
{
    /**
     * Adds a new resource's data to the blueprint.
     *
     * @param string $name The name of the resource. This is
     * used as an identifier for the resource data.
     * @param array $data The raw data from the resource.
     */
    public function addResource(string $name, array $data): void;

    /**
     * Processes all added resource data according to the
     * blueprint and prepares it for output.
     *
     * @return bool Returns true if the processing was
     * successful, false otherwise.
     */
    public function process(): bool;

    /**
     * @return array The processed output data.
     */
    public function getOutput(): array;
}