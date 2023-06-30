<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Assembler\Builder\CollectionBuilder;
use Itsmattch\Nexus\Assembler\Builder\ModelBuilder;
use Itsmattch\Nexus\Contract\Action;
use Itsmattch\Nexus\Contract\Assembler\Builder\CollectionBuilder as CollectionBuilderContract;
use Itsmattch\Nexus\Contract\Assembler\Builder\ModelBuilder as ModelBuilderContract;
use Itsmattch\Nexus\Contract\Assembler\Repository as RepositoryContract;
use Itsmattch\Nexus\Contract\Common\Autonomous;
use Itsmattch\Nexus\Contract\Model;
use Itsmattch\Nexus\Contract\Model\Collection as CollectionContract;
use Itsmattch\Nexus\Model\Collection;

abstract class Repository extends Assembler implements RepositoryContract
{
    /**
     * Fully qualified class name of a collection
     * that stores discovered models.
     */
    protected string $collection = Collection::class;

    /**
     * Internal storage of resources.
     */
    private array $internalResources = [];

    /**
     * The fully qualified class name of
     * the internally used model.
     */
    private readonly string $internalModel;

    /**
     * Internal storage of instantiated collection object.
     */
    private CollectionContract $internalCollection;

    public function __construct()
    {
        $this->setCollection(new $this->collection);
        $this->loadModel(new $this->model);
        $this->prepareActions();
        $this->loadActions();
    }

    /**
     * This function restricts the accepted model to one
     * that implement the Autonomous interface, ensuring
     * they are usable immediately upon instantiation.
     */
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
     * This function restricts the accepted actions to one
     * that implement the Autonomous interface, ensuring
     * they are usable immediately upon instantiation.
     */
    private function loadAction(string $name, Action&Autonomous $action): void
    {
        $action->perform();
        $this->addResource($name, $action->getContent());
    }

    public function addResource(string $name, array $resource): void
    {
        $this->internalResources[$name] = $resource;
    }

    public function setModel(Model $model): void
    {
        $this->internalModel = $model::class;
    }

    public function assemble(): bool
    {
        $collectionBuilder = new CollectionBuilder();
        $this->collection($collectionBuilder);

        $modelBuilder = new ModelBuilder();
        $this->model($modelBuilder);

        $processedCollection = $collectionBuilder->call($this->internalResources);

        foreach ($processedCollection as $modelData) {
            $model = $modelBuilder->call($modelData);

            $modelInstance = new $this->model;
            // feed with data

            $this->internalCollection->addModel($modelInstance);
        }

        return true;
    }

    /** todo */
    abstract protected function collection(CollectionBuilderContract $builder): void;

    /** todo */
    abstract protected function model(ModelBuilderContract $builder): void;

    public function setCollection(CollectionContract $collection): void
    {
        $this->internalCollection = $collection;
    }

    public function getCollection(): CollectionContract
    {
        return $this->internalCollection;
    }
}