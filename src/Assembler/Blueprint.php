<?php

namespace Itsmattch\NexusCore\Assembler;

use Itsmattch\NexusCore\Contract\Entity;
use Itsmattch\NexusCore\Contract\Resource;
use Itsmattch\NexusCore\Contract\Resource\Action;

abstract class Blueprint extends Assembler
{
    /**
     * Internal storage of the resources.
     */
    private array $internalResources = [];

    /**
     * The internal entity instance.
     */
    private readonly Entity $internalEntity;


    public function __construct()
    {
        $this->loadEntity(new $this->entity);
        $this->loadResources();
    }

    public function addResource(string $name, array $resource): void
    {
        $this->internalResources[$name] = $resource;
    }

    public function assemble(): bool
    {
        return true; // todo
    }

    private function loadEntity(Entity $entity): void
    {
        $this->internalEntity = $entity;
    }

    /**
     * Instantiates and loads actions
     * defined in the $actions property.
     */
    private function loadResources(): void
    {
        foreach ($this->resources as $name => $resource) {
            is_array($resource)
                ? $this->loadResource($name, new $resource[0](), new $resource[1]())
                : $this->loadResource($name, $resource);
        }
    }

    /**
     * This function restricts the accepted actions to
     * entities that implement the Autonomous interface,
     * ensuring they are usable immediately upon
     * instantiation.
     */
    private function loadResource(string $name, Resource $resource, ?Action $action = null): void
    {
        $this->addResource($name, $resource->trigger($action));
    }
}