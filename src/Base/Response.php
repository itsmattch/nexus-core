<?php

namespace Itsmattch\Nexus\Base;

/** todo */
class Response
{
    public function __construct(
        public readonly string $body,
        public readonly ?string $type,
    ) {}
}