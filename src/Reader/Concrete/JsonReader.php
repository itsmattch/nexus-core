<?php

namespace Itsmattch\Nexus\Reader\Concrete;

use Itsmattch\Nexus\Reader\Reader;

/**
 * The Reader class responsible for reading JSON data.
 */
class JsonReader extends Reader
{
    protected readonly array $jsonArray;

    public function read(): bool
    {
        $jsonArray = json_decode($this->message->body, true);

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