<?php

namespace Itsmattch\Nexus\Writer\Concrete;

use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Writer\Writer;

/** The Writer class responsible for writing JSON data. */
class JsonWriter extends Writer
{
    protected Message $jsonRequest;

    public function write(): bool
    {
        $jsonString = json_encode($this->body, true);

        if (is_string($jsonString)) {
            $this->jsonRequest = new Message(
                body: $jsonString,
                type: 'application/json'
            );

            return true;
        }

        return false;
    }

    public function get(): Message
    {
        return $this->jsonRequest;
    }
}