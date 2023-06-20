<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Common\Blueprint;
use Itsmattch\Nexus\Common\Model;

abstract class Assembler
{
    /** A class defining the model. */
    protected string $model = Model::class;

    /** A list of all resources containing pieces of the model. */
    protected array $resources = [];

    /** A blueprint mapping resource to model fields. */
    protected string $blueprint = Blueprint::class;

    /** Mappings of resources keys. */
    protected array $keys = [];

    private string $key;

    // public function getModel(): Model {}
}