<?php

namespace Itsmattch\Nexus\Contract\Entity;

use Itsmattch\Nexus\Entity\Entity;

interface Collection
{
    public function addEntity(Entity $entity): void;
}