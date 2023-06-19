<?php

use Itsmattch\Nexus\Stream\Reader\JsonReader;
use Itsmattch\Nexus\Stream\Stream;

class ReadUsersCollection extends Stream
{
    protected string $address = "https://jsonplaceholder.typicode.com/users";
    protected string $reader = JsonReader::class;
}