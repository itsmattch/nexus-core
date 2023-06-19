<?php

use Itsmattch\Nexus\Stream\Reader\JsonReader;
use Itsmattch\Nexus\Stream\Stream;

class ReadUser extends Stream
{
    protected string $address = "https://jsonplaceholder.typicode.com/users/{id}";
    protected string $reader = JsonReader::class;
}