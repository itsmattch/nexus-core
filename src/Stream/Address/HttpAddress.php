<?php

namespace Itsmattch\Nexus\Stream\Address;

use Itsmattch\Nexus\Stream\Component\Address;

class HttpAddress extends Address
{
    protected string $template = '{ scheme }://{ domain }{ @ port }/{ path }{ @query_string }';

    public function captureSecure(): callable
    {
        return function (bool $secure): string {
            return $secure ? 'https' : 'http';
        };
    }

    public function releaseScheme(): callable
    {
        return function (string $string): bool {
            return true;
        };
    }
}