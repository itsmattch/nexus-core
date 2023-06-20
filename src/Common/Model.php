<?php

namespace Itsmattch\Nexus\Common;

use ReflectionClass;

abstract class Model
{
    /** Custom unique name or automatically set from class name. */
    protected string $name;

    protected string $key = 'id';

    public final function boot()
    {
        $this->internallyBootName();
        return true;
    }

    /** todo */
    private function internallyBootName(): void
    {
        if (empty($this->name)) {
            $this->name = strtolower((new ReflectionClass($this))->getShortName());
        }
    }
}