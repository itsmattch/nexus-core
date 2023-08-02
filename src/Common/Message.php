<?php

namespace Itsmattch\NexusCore\Common;

/**
 * A simple encapsulation of the most important
 * information send to and received by an Engine.
 */
class Message
{
    public function __construct(
        public readonly string  $body,
        public readonly ?string $type,
    ) {}
}