<?php

namespace Itsmattch\Nexus\Writer;

use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Contract\Writer;

class JsonWriter implements Writer
{
    public function write(array $input): ?Message
    {
        $jsonString = json_encode($input, true);

        if (is_string($jsonString)) {
            return new Message(
                body: $jsonString,
                type: 'application/json'
            );
        }

        return null;
    }
}