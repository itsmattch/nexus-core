<?php

namespace Itsmattch\Nexus\Repository;

use Itsmattch\Nexus\Common\Blueprint;
use Itsmattch\Nexus\Common\Collection;
use Itsmattch\Nexus\Common\Model;
use Itsmattch\Nexus\Stream\Stream;

class Repository
{
    /** A class defining the model. */
    protected string $model = Model::class;

    protected string $collection = Collection::class;

    /** A list of all resources containing pieces of the model. */
    protected array $resources = [];

    /** @var array todo */
    private array $resourcesInstances = [];

    /** A blueprint mapping resource to model fields. */
    protected string $blueprint = Blueprint::class;

    /** todo load identities */
    public final static function load(): ?Repository
    {
        $instance = new static();

        if (!$instance->access()) {
            return null;
        }
        if (!$instance->read()) {
            return null;
        }

        return $instance;
    }

    /** todo read resources */
    public function access(): bool
    {
        /** @var Stream $resource */
        foreach ($this->resources as $resource) {
            if (!is_subclass_of($resource, Stream::class)) {
                throw new \Exception();
            }
            $this->resourcesInstances[] = $resource::load();
        }
        return true;
    }

    public function read(): bool
    {
        $blueprint = new $this->blueprint($this->model);
        $collection = $blueprint->getCollection(... $this->resourcesInstances);

        var_dump($collection);
        exit;
    }
}