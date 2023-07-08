<?php

namespace Itsmattch\Nexus\Contract;

// todo

interface Writer
{
    public function setInput(mixed $input): void;

    public function write(): bool;

    public function get(): string;

}