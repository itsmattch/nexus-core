<?php

namespace Itsmattch\Nexus\Contract;

/**
 * The Reader class is responsible for reading raw content
 * of the resources and turning it into PHP arrays.
 *
 * @link https://nexus.itsmattch.com/digging-deeper/reader Readers Documentation
 */
interface Reader
{
    /** todo */
    public function read(string $input): array;
}