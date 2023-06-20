<?php

namespace Model;

use Itsmattch\Nexus\Common\Model;

class UserModel extends Model
{
    public array $identifiers = ['id'];

    public array $data = ['name', 'company', 'geo'];
}