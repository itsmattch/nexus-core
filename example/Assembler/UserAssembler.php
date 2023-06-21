<?php

namespace Assembler;

use Blueprints\UserBlueprint;
use Itsmattch\Nexus\Assembler\Assembler;
use Model\UserModel;
use Resource\UserResource;

class UserAssembler extends Assembler
{
    protected string $model = UserModel::class;

    protected string|array $resource = UserResource::class;

    protected string|array $blueprint = UserBlueprint::class;
}