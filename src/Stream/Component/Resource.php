<?php

namespace Itsmattch\Nexus\Stream\Component;

// TODO
// Resource is a container for content of the resource
// turned to php array.
class Resource
{
    protected array $array = [];

    /** todo */
    public function load(array $array)
    {
        $this->array = $array;
    }

    public function get(string $key): mixed { /* todo */}
    public function set(string $key): mixed { /* todo */}
    public function has(string $key): mixed { /* todo */}
}