<?php

namespace Itsmattch\Nexus\Repository;

use Itsmattch\Nexus\Common\Blueprint;
use Itsmattch\Nexus\Common\Model;
use Itsmattch\Nexus\Exceptions\Assembler\InvalidArrayFormatException;
use Itsmattch\Nexus\Exceptions\Assembler\InvalidBlueprintException;
use Itsmattch\Nexus\Exceptions\Assembler\InvalidModelException;
use Itsmattch\Nexus\Exceptions\Assembler\InvalidResourceException;
use Itsmattch\Nexus\Stream\Stream;

class Repository
{
    /** todo */
    protected string $model = Model::class;

    /** todo */
    protected string|array $stream = [];

    /** todo */
    protected string $blueprint;

    /** todo */
    private array $streamsInstances = [];

    /** todo */
    private Blueprint $blueprintInstance;

    /** todo */
    public static function load(): ?Repository
    {
        try {
            $instance = new static();

            $instance->prepare();
            // $instance->validate(); // todo needs checked

            if (!$instance->access()) {
                return null;
            }
            if (!$instance->read()) {
                return null;
            }

            return $instance;

        } catch (\Exception) {
            return null;
        }
    }

    /** todo */
    public function prepare(): void
    {
        if (!is_array($this->stream)) {
            $this->stream = [$this->stream];
        }
    }

    /** todo */
    public function validate(): void
    {
        // Model must represent a subclass of Model.
        if (!is_subclass_of($this->model, Model::class)) {
            throw new InvalidModelException($this->model);
        }

        // Streams array should be a list.
        if (!array_is_list($this->stream)) {
            throw new InvalidArrayFormatException();
        }

        // Resources list must not contain any values other than
        // strings representing subclasses of Resource class.
        $filteredResources = array_filter($this->stream, function ($streamCandidate) {
            return is_subclass_of($streamCandidate, Stream::class);
        });
        if (count($filteredResources) !== count($this->stream)) {
            throw new InvalidResourceException();
        }

        // Blueprint must be a string representing subclasses of Blueprint class.
        if (is_subclass_of($this->blueprint, Blueprint::class)) {
            throw new InvalidBlueprintException();
        }
    }

    /** todo */
    public function access(): bool
    {
        $streamsInstances = [];
        /** @var Stream $stream */
        foreach ($this->stream as $i => $stream) {
            $streamInstance = $stream::load();
            if ($streamInstance === null) {
                return false;
            }
            $streamsInstances[$i] = $streamInstance;
        }
        $this->streamsInstances = $streamsInstances;
        return count(array_filter($this->streamsInstances)) > 0;
    }

    /** todo */
    public function read(): bool
    {
        $this->blueprintInstance = new $this->blueprint(...$this->streamsInstances);
        var_dump($this->blueprintInstance);
        return true;
    }
}