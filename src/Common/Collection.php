<?php

namespace Itsmattch\Nexus\Common;

class Collection
{
    protected string $model = Model::class;

    protected array $identifiers = [];

    public function add(Identifier $identifier): void
    {
        $this->identifiers[] = $identifier;
    }
}