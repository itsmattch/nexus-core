<?php

namespace Itsmattch\Nexus\Repository;

use Itsmattch\Nexus\Contract\Action;
use Itsmattch\Nexus\Contract\Blueprint;
use Itsmattch\Nexus\Contract\Model;
use Itsmattch\Nexus\Contract\Model\Collection as CollectionContract;
use Itsmattch\Nexus\Contract\Repository as RepositoryContract;
use Itsmattch\Nexus\Model\Collection;

/** todo */
class Repository implements RepositoryContract
{
    /**
     * A model that this repository discovers.
     */
    protected string $model = Model::class;

    /**
     * Actions this repository uses to discover models.
     */
    protected string|array $actions = [];

    /**
     * Blueprint that interprets the actions responses.
     */
    protected string $blueprint = Blueprint::class;

    /**
     * Internal array or action instances.
     */
    private array $internalActions = [];

    /**
     * The internal model FQCN.
     */
    private readonly string $internalModel;

    /**
     * Internal instance of Blueprint.
     */
    private readonly Blueprint $internalBlueprint;

    /**
     * Internal instance of Collection.
     */
    private readonly CollectionContract $internalCollection;

    /** todo */
    private bool $collected = false;

    public function __construct()
    {
        $this->internalCollection = new Collection();

        $this->loadModel();
        $this->loadBlueprint();
        $this->prepareActions();
        $this->loadActions();
    }

    /** todo */
    private function loadModel(): void
    {
        $this->setModel($this->model);
    }

    /** todo */
    private function loadBlueprint(): void
    {
        $this->setBlueprint(new $this->blueprint);
    }

    /** todo */
    private function prepareActions(): void
    {
        if (!is_array($this->actions)) {
            $this->actions = [$this->actions];
        }
    }

    /** todo */
    private function loadActions(): void
    {
        // todo
    }

    public function setAction(string $name, Action $action): void
    {
        $this->internalActions[$name] = $action;
    }

    public function setBlueprint(Blueprint $blueprint): void
    {
        $this->internalBlueprint = $blueprint;
    }

    public function setModel(string $class): void
    {
        if (is_subclass_of($class, Model::class)) {
            $this->internalModel = $class;
        }
    }

    public function collect(): bool
    {
        // $inputArray = $this->buildInputArray();
        //
        // $this->internalBlueprint->setInput($inputArray);
        // $this->internalBlueprint->process();
        // $outputModels = $this->internalBlueprint->getOutput();
        //
        // foreach ($outputModels as $model) {
        //     $modelInstance = new $this->internalModel();
        //     $this->internalCollection->addModel($modelInstance);
        // }
        //
        return true;
    }

    protected function buildInputArray(): array
    {
        return array_map(function ($action) {
            return $action->getContent();
        }, $this->internalActions);
    }

    public function getCollection(): CollectionContract
    {
        return $this->internalCollection;
    }
}