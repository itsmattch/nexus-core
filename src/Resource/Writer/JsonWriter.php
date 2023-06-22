<?php

namespace Itsmattch\Nexus\Resource\Writer;

use Itsmattch\Nexus\Resource\Component\Engine\Request;
use Itsmattch\Nexus\Resource\Component\Writer;

/** The Writer class responsible for writing JSON data. */
class JsonWriter extends Writer
{
    protected Request $jsonRequest;

    public function write(): bool
    {
        $jsonString = json_encode($this->body, true);

        if (is_string($jsonString)) {
            $this->jsonRequest = new Request();
            $this->jsonRequest->setBody($jsonString);
            $this->jsonRequest->setType('application/json');

            return true;
        }

        return false;
    }

    public function get(): Request
    {
        return $this->jsonRequest;
    }
}