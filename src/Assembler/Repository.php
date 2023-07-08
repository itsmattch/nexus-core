<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Assembler\Builder\CollectionBuilder;
use Itsmattch\Nexus\Assembler\Builder\ModelBuilder;
use Itsmattch\Nexus\Contract\Assembler\Repository as RepositoryContract;
use Itsmattch\Nexus\Contract\Model;
use Itsmattch\Nexus\Contract\Model\Collection as CollectionContract;
use Itsmattch\Nexus\Contract\Resource;
use Itsmattch\Nexus\Contract\Resource\Action;
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
        $this->setCollection(new $this->collection());
        $this->loadModel(new $this->model());
        $this->prepareResources();
        $this->loadResources();
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

            $modelInstance = new $this->model();
            // feed with data

            $this->internalCollection->addModel($modelInstance);
        }

        return true;
    }

    public function getCollection(): CollectionContract
    {
        return $this->internalCollection;
    }

    public function setCollection(CollectionContract $collection): void
    {
        $this->internalCollection = $collection;
    }

    /** todo */
    abstract protected function collection(CollectionBuilder $builder): void;

    /** todo */
    abstract protected function model(ModelBuilder $builder): void;

    /**
     * This function restricts the accepted model to one
     * that implement the Autonomous interface, ensuring
     * they are usable immediately upon instantiation.
     */
    private function loadModel(Model $model): void
    {
        $this->setModel($model);
    }

    /**
     * Ensures that the actions are represented
     * as arrays for easy iteration.
     */
    private function prepareResources(): void
    {
        // todo edge case [resource, action]
        if (!is_array($this->resources)) {
            $this->resources = [$this->resources];
        }
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
                : $this->loadResource($name, new $resource);
        }
    }

    /**
     * This function restricts the accepted actions to one
     * that implement the Autonomous interface, ensuring
     * they are usable immediately upon instantiation.
     */
    private function loadResource(string $name, Resource $resource, ?Action $action = null): void
    {
        $this->addResource($name, $resource->trigger($action));
    }
}