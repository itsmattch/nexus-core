<?php

namespace Itsmattch\Nexus\Contract\Model;

use Itsmattch\Nexus\Model\Model;

interface Collection
{
    public function addModel(Model $model): void;
}