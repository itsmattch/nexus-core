<?php

use Itsmattch\Nexus\Stream\Stream;

class ReadUser extends Stream
{
    protected string $address = "https://jsonplaceholder.typicode.com/users/{id}";
}