<?php

namespace Itsmattch\Nexus\Common;

/** The identity of a model */
class Identifier
{
    public string $model;

    public string $identifier;

    public function __construct(string $model, string $identifier) {
        $this->model = $model;
        $this->identifier = $identifier;
    }
}