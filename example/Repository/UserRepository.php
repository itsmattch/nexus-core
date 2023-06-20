<?php

namespace Repository;

use Blueprints\UserBlueprint;
use Itsmattch\Nexus\Repository\Repository;
use Model\UserModel;
use Resource\UserCollectionResource;

class UserRepository extends Repository
{
    protected string $model = UserModel::class;

    protected array $resources = [UserCollectionResource::class];

    protected string $blueprint = UserBlueprint::class;
}