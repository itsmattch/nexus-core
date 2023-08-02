<?php

namespace Itsmattch\NexusCore\Writer;

use Itsmattch\NexusCore\Common\Message;
use Itsmattch\NexusCore\Contract\Writer;

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