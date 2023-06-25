<?php

namespace Itsmattch\Nexus\Contract;

interface Blueprint
{
    public function process(): void;

    public function getResult(): array;
}