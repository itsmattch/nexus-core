<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Assembler\Contract\Asynchronous;
use Itsmattch\Nexus\Assembler\Exception\BlueprintCountException;
use Itsmattch\Nexus\Assembler\Exception\InvalidArrayFormatException;
use Itsmattch\Nexus\Assembler\Exception\InvalidBlueprintException;
use Itsmattch\Nexus\Assembler\Exception\InvalidResourceException;
use Itsmattch\Nexus\Blueprint\Blueprint;
use Itsmattch\Nexus\Common\Exception\InvalidModelException;
use Itsmattch\Nexus\Model\Model;
use Itsmattch\Nexus\Action\Action;

/**
 * The Assembler class is responsible for assembling data
 * from multiple Resources into a single Model.
 */
abstract class Assembler
{
    /** The class name of the model. */
    protected string $model = Model::class;

    /**
     * A list of class names of all resources containing
     * pieces of the model. Each resource should be a
     * subclass of the Resource class.
     */
    protected string|array $resource = [];

    /**
     * The class name(s) of the blueprint(s) mapping
     * resources to model fields. Each blueprint should be
     * a subclass of the Blueprint class.
     */
    protected string|array $blueprint = [];

    /** The instances of the resource classes. */
    private array $resourcesInstance = [];

    /** The instances of the blueprint classes. */
    private array $blueprintsInstance = [];

    /** The parameters to pass to the resources. */
    private array $resourceParameters;

    /** @param array $parameters An array of parameters to pass to the Resources. */
    public function __construct(array $parameters = [])
    {
        $this->resourceParameters = $parameters;
    }

    /**
     * Creates an instance of the Assembler class, prepares
     * and validates it, and tries to access and read the
     * resources.
     *
     * @param array $parameters An array of parameters to pass to the Resources.
     * @return ?Assembler Returns Assembler instance if accessed successfully, null otherwise.
     */
    public static function load(array $parameters = []): ?Assembler
    {
        try {
            $instance = new static($parameters);

            $instance->prepare();
            $instance->validate();

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

    /**
     * Finds a specific instance of the Assembler class
     * based on a given unique identifier.
     *
     * @param string $identifier A unique identifier value.
     * @param string $parameterName An alternative identifier parameter name.
     * @return ?Assembler Returns Assembler instance if accessed successfully, null otherwise.
     */
    public static function find(string $identifier, string $parameterName = 'id'): ?Assembler
    {
        if (empty($identifier) || empty($parameterName)) {
            return self::load();
        }
        $parameter = [$parameterName => $identifier];

        return static::load($parameter);
    }

    /** Prepares the assembler for validation and processing. */
    public function prepare(): void
    {
        if (!is_array($this->resource)) {
            $this->resource = [$this->resource];
        }
        if (!is_array($this->blueprint)) {
            $this->blueprint = [$this->blueprint];
        }
    }

    /**
     * Validates the assembler's state. Throws an exception
     * in case of a validation error.
     *
     * @throws BlueprintCountException
     * @throws InvalidArrayFormatException
     * @throws InvalidBlueprintException
     * @throws InvalidModelException
     * @throws InvalidResourceException
     */
    public function validate(): void
    {
        // Model must represent a subclass of Model.
        if (!is_subclass_of($this->model, Model::class)) {
            throw new InvalidModelException($this->model);
        }

        // The number of blueprints must either be 1 or equal to number of resources.
        if (count($this->blueprint) !== 1 && count($this->resource) !== count($this->blueprint)) {
            throw new BlueprintCountException();
        }

        // Both arrays should be lists.
        if (!array_is_list($this->resource) || !array_is_list($this->blueprint)) {
            throw new InvalidArrayFormatException();
        }

        // Resources list must not contain any values other than
        // strings representing subclasses of Resource class.
        $filteredResources = array_filter($this->resource, function ($resourceCandidate) {
            return is_subclass_of($resourceCandidate, Action::class);
        });
        if (count($filteredResources) !== count($this->resource)) {
            throw new InvalidResourceException();
        }

        // Blueprints list must not contain any values other than
        // strings representing subclasses of Blueprint class.
        $filteredBlueprints = array_filter($this->blueprint, function ($blueprintCandidate) {
            return is_subclass_of($blueprintCandidate, Blueprint::class);
        });
        if (count($filteredBlueprints) !== count($this->blueprint)) {
            throw new InvalidBlueprintException();
        }
    }

    /**
     * Tries to access the resources by loading their
     * instances. If a resource cannot be accessed, and the
     * Assembler is not asynchronous,  the method will
     * return false immediately.
     *
     * @return bool True if at least one resource can be accessed, false otherwise.
     */
    public function access(): bool
    {
        /** @var Action $resource */
        foreach ($this->resource as $i => $resource) {
            $resourceInstance = $resource::load($this->resourceParameters);
            if ($resourceInstance === null && !($this instanceof Asynchronous)) {
                return false;
            }
            $this->resourcesInstance[$i] = $resourceInstance;
        }
        return count(array_filter($this->resourcesInstance)) > 0;
    }

    /**
     * Tries to read the data from the Resources using the Blueprints.
     *
     * @return bool True if the data can be read, false otherwise.
     */
    public function read(): bool
    {
        /** @var Action $resource */
        foreach ($this->resourcesInstance as $i => $resource) {
            if (count($this->blueprintsInstance) === 1) {
                // blueprint[0] on $resource->get();
            } else {
                // blueprint[i] on $resource->get();
            }
        }
        return true;
    }
}