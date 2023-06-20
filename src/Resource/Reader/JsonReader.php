<?php

namespace Itsmattch\Nexus\Resource\Reader;

use Itsmattch\Nexus\Resource\Component\Reader;

/** todo */
class JsonReader extends Reader
{
    protected array $interpreted = [];

    public function read(): bool
    {
        $array = json_decode($this->response->getBody(), true);

        if (is_array($array)) {
            $this->interpreted = $array;
            return true;
        }

        return false;
    }

    public function get(): array
    {
        return $this->interpreted;
    }
}