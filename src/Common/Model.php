<?php

namespace Itsmattch\Nexus\Common;

use ReflectionClass;

abstract class Model
{
    /** Custom unique name or automatically set from class name. */
    protected string $name;

    /**
     * An array of unique pieces of information identifying a model,
     * comparable to a primary key in a relational database.
     */
    protected array $keys = ['id'];

    public function __construct() {

    }

    /**
     * todo boot the instance.
     *
     * @return true
     */
    public final function boot(): bool
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