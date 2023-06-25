<?php

namespace Itsmattch\Nexus\Repository;

use Exception;
use Itsmattch\Nexus\Blueprint\Blueprint;
use Itsmattch\Nexus\Common\Exception\InvalidModelException;
use Itsmattch\Nexus\Contract\Common\Validatable;
use Itsmattch\Nexus\Contract\Repository as RepositoryContract;
use Itsmattch\Nexus\Contract\Stream;
use Itsmattch\Nexus\Model\Collection;
use Itsmattch\Nexus\Model\Model;

abstract class Repository implements RepositoryContract, Validatable
{
    /** A model that this repository discovers. */
    protected string $model = Model::class;

    /** Streams this repository uses to discover models. */
    protected string|array $streams = [];

    /** Blueprint that interprets the streams responses. */
    protected string $blueprint = Blueprint::class;

    protected array $ids = [];

    /** Collected data from repositories */
    private array $input = [];

    private Collection $collection;

    public function __construct()
    {
        if (!is_array($this->streams)) {
            $this->streams = [$this->streams];
        }
    }

    final public static function load(): ?RepositoryContract
    {
        $instance = new static();
        return $instance->boot() ? $instance : null;
    }

    public function boot(): bool
    {
        try {
            $this->validate();
            return $this->access()
                && $this->read();

        } catch (Exception) {
            return false;
        }
    }

    public function access(): bool
    {
        $input = [];

        /** @var Stream $stream */
        foreach ($this->streams as $key => $stream) {
            $streamInstance = new $stream;
            if (!$streamInstance->boot()) {
                return false;
            }
            $input[$key] = $streamInstance->getResponse();
        }
        $this->input = $input;
        return true;
    }

    public function read(): bool
    {
        /** @var Blueprint $blueprintInstance */
        $blueprintInstance = new $this->blueprint($this->input);
        $blueprintInstance->process();

        foreach ($blueprintInstance->getResult() as $model) {
            // todo
        }
        return true;
    }

    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @throws InvalidModelException
     */
    public function validate(): void
    {
        if (!is_subclass_of($this->model, Model::class)) {
            throw new InvalidModelException($this->model);
        }
    }
}