<?php

namespace Itsmattch\Nexus\Stream\Reader;

use Itsmattch\Nexus\Stream\Component\Reader;

/** todo */
class JsonReader extends Reader
{
    /** todo */
    public function read(): bool
    {
        $array = json_decode($this->response->getBody(), true);

        if (is_array($array)) {
            $this->resource->load($array);
            return true;
        }

        return false;
    }
}