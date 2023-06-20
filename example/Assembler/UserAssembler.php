<?php

namespace Assembler;

use Blueprints\UserBlueprint;
use Itsmattch\Nexus\Assembler\Assembler;
use Model\UserModel;
use Resource\UserResource;

class UserAssembler extends Assembler
{
    protected string $model = UserModel::class;

    protected array $resources = [UserResource::class];

    protected string $blueprint = UserBlueprint::class;
}