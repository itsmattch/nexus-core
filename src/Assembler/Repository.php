<?php

namespace Itsmattch\NexusCore\Assembler;

use Itsmattch\NexusCore\Assembler\Builder\CollectionBuilder;
use Itsmattch\NexusCore\Assembler\Builder\EntityBuilder;
use Itsmattch\NexusCore\Contract\Assembler\Repository as RepositoryContract;
use Itsmattch\NexusCore\Contract\Entity;
use Itsmattch\NexusCore\Contract\Entity\Collection as CollectionContract;
use Itsmattch\NexusCore\Contract\Resource;
use Itsmattch\NexusCore\Contract\Resource\Action;
use Itsmattch\NexusCore\Entity\Collection;

abstract class Repository extends Assembler implements RepositoryContract
{
    /**
     * Fully qualified class name of a collection
     * that stores discovered entities.
     */
    protected string $collection = Collection::class;

    /**
     * Internal storage of resources.
     */
    private array $internalResources = [];

    /**
     * The fully qualified class name of
     * the internally used entity.
     */
    private readonly string $internalEntity;

    /**
     * Internal storage of instantiated collection object.
     */
    private CollectionContract $internalCollection;

    public function __construct()
    {
        $this->loadCollection(new $this->collection());
        $this->loadEntity(new $this->entity());
        $this->loadResources();
    }

    public function addResource(string $name, array $resource): void
    {
        $this->internalResources[$name] = $resource;
    }

    public function setEntity(Entity $entity): void
    {
        $this->internalEntity = $entity::class;
    }

    public function assemble(): bool
    {
        $collectionBuilder = new CollectionBuilder();
        $this->collection($collectionBuilder);

        $entityBuilder = new EntityBuilder();
        $this->entity($entityBuilder);

        $processedCollection = $collectionBuilder->call($this->internalResources);

        foreach ($processedCollection as $entityData) {
            $entity = $entityBuilder->call($entityData);

            $entityInstance = new $this->entity();
            // feed with data

            $this->internalCollection->addEntity($entityInstance);
        }

        return true;
    }

    public function getCollection(): CollectionContract
    {
        return $this->internalCollection;
    }

    /**
     * Provides a mechanism for the transformation of raw
     * array data into a structured collection of entities.
     *
     * @param CollectionBuilder $builder
     */
    protected function collection(CollectionBuilder $builder): void {}

    /**
     * Serves as a blueprint for the extraction and
     * organization of specific data about each entity.
     *
     * @param EntityBuilder $builder
     */
    abstract protected function entity(EntityBuilder $builder): void;

    private function loadCollection(CollectionContract $collection): void
    {
        $this->internalCollection = $collection;
    }

    /**
     * This function restricts the accepted entity to one
     * that implement the Autonomous interface, ensuring
     * they are usable immediately upon instantiation.
     */
    private function loadEntity(Entity $entity): void
    {
        $this->setEntity($entity);
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