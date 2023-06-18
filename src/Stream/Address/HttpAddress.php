<?php

namespace Itsmattch\Nexus\Stream\Address;

use Itsmattch\Nexus\Stream\Component\Address;

class HttpAddress extends Address
{
    protected string $template = '{ secure }://{ domain }{ @ port }/{ path }{ @query_string }';
    protected array $defaults = [
        'secure' => 'https',
    ];

    public function captureSecure(bool $secure): string
    {
        return $secure ? 'https' : 'http';
    }

    public function releaseSecure(string $secure): bool
    {
        return $secure === 'https';
    }
}