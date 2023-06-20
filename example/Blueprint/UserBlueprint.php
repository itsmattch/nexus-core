<?php

namespace Blueprints;

use Itsmattch\Nexus\Common\Blueprint;

class UserBlueprint extends Blueprint
{
    public function identifier(): string
    {
        return 'id';
    }

    public function model(): array
    {
        return [
            'name' => 'name',
            'company' => 'company.name',
            // 'geo' => '$this.geo',
        ];
    }

    // public function geo(): string
    // {
    //     return $this->find('address.geo.lat') . ' ' . $this->find('address.geo.lng');
    // }
}