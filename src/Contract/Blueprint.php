<?php

namespace Itsmattch\Nexus\Contract;

interface Blueprint
{
    public function setInput(array $input): void;

    public function process(): void;

    public function getOutput(): array;
}