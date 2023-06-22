<?php

namespace Itsmattch\Nexus\Resource\Reader;

use Itsmattch\Nexus\Resource\Component\Reader;

/** The Reader class responsible for reading JSON data. */
class JsonReader extends Reader
{
    protected array $jsonArray = [];

    public function read(): bool
    {
        $jsonArray = json_decode($this->response->getBody(), true);

        if (is_array($jsonArray)) {
            $this->jsonArray = $jsonArray;
            return true;
        }

        return false;
    }

    public function get(): array
    {
        return $this->jsonArray;
    }
}