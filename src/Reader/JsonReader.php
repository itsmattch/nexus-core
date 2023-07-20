<?php

namespace Itsmattch\Nexus\Reader;

use Itsmattch\Nexus\Common\Message;
use Itsmattch\Nexus\Contract\Reader;

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