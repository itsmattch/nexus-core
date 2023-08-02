<?php

namespace Itsmattch\NexusCore\Contract\Entity;

use Itsmattch\NexusCore\Entity\Entity;

interface Collection
{
    public function addEntity(Entity $entity): void;
}