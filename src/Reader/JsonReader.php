<?php

namespace Itsmattch\NexusCore\Reader;

use Itsmattch\NexusCore\Common\Message;
use Itsmattch\NexusCore\Contract\Reader;

class JsonReader implements Reader
{
    public function read(Message $message): array
    {
        $jsonArray = json_decode($message->body, true);

        if (is_array($jsonArray)) {
            return $jsonArray;
        }

        return [];
    }
}