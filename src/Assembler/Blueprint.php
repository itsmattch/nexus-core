<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Action\Common\Read;
use Itsmattch\Nexus\Contract\Model;
use Itsmattch\Nexus\Contract\Resource;
use Itsmattch\Nexus\Contract\Resource\Action;

abstract class Blueprint extends Assembler
{
    /**
     * Internal storage of the resources.
     */
    private array $internalResources = [];

    /**
     * The internal model instance.
     */
    private readonly Model $internalModel;


    public function __construct()
    {
        $this->loadModel(new $this->model);
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

    private function loadModel(Model $model): void
    {
        $this->internalModel = $model;
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
     * models that implement the Autonomous interface,
     * ensuring they are usable immediately upon
     * instantiation.
     */
    private function loadResource(string $name, Resource $resource, ?Action $action = null): void
    {
        if (!isset($action)) {
            $action = new Read();
        }

        $this->addResource($name, $resource->trigger($action));
    }
}