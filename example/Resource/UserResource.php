<?php

namespace Resource;

use Itsmattch\Nexus\Resource\Resource;

class UserResource extends Resource
{
    protected string $address = "https://jsonplaceholder.typicode.com/users/{id}";
}