<?php

namespace Itsmattch\Nexus\Common;

/** The identity of a model */
class Identifier
{
    public function __construct(
        public readonly string $model,
        public readonly string $stream,
        public readonly string $identifier
    ) {}
}