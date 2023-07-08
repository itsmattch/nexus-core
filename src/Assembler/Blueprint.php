<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Contract\Resource;
use Itsmattch\Nexus\Contract\Model;

abstract class Blueprint extends Assembler
{
    /**
     * Internal storage of instantiated action objects.
     */
    private array $internalActions = [];

    /**
     * The internal model instance.
     */
    private readonly Model $internalModel;


    public function __construct()
    {
        $this->loadModel(new $this->model);
        $this->prepareActions();
        $this->loadActions();
    }

    private function loadModel(Model&Autonomous $model): void
    {
        $this->setModel($model);
    }

    /**
     * Ensures that the actions are represented
     * as arrays for easy iteration.
     */
    private function prepareActions(): void
    {
        if (!is_array($this->actions)) {
            $this->actions = [$this->actions];
        }
    }

    /**
     * Instantiates and loads actions
     * defined in the $actions property.
     */
    private function loadActions(): void
    {
        foreach ($this->actions as $name => $action) {
            $this->loadAction($name, new $action());
        }
    }

    /**
     * This function restricts the accepted actions to
     * models that implement the Autonomous interface,
     * ensuring they are usable immediately upon
     * instantiation.
     */
    private function loadAction(string $name, Resource&Autonomous $action): void
    {
        $action->perform();
        $this->addResource($name, $action->getContent());
    }

    public function addResource(string $name, array $resource): void
    {
        $this->internalActions[$name] = $resource;
    }

    public function setModel(Model $model): void
    {
        $this->internalModel = $model;
    }

    public function assemble(): bool
    {
        return true; // todo
    }
}