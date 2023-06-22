<?php

namespace Resource;

use Itsmattch\Nexus\Resource\Component\Engine;
use Itsmattch\Nexus\Resource\Engine\Enum\HttpMethod;
use Itsmattch\Nexus\Resource\Engine\HttpEngine;
use Itsmattch\Nexus\Resource\Resource;
use Itsmattch\Nexus\Resource\Writer\JsonWriter;

class CreateUserResource extends Resource
{
    protected string $address = "https://jsonplaceholder.typicode.com/users/";

    /** @param HttpEngine $engine */
    protected function bootEngine(Engine $engine): bool
    {
        $body = [
            'name' => $this->parameter('name', 'John')
        ];

        $writer = new JsonWriter($body);
        $writer->write();

        $engine->setMethod(HttpMethod::POST);
        $engine->setBody($writer->get());

        return true;
    }
}