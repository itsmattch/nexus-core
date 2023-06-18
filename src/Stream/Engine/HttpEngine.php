<?php

namespace Itsmattch\Nexus\Stream\Engine;

use CurlHandle;
use Itsmattch\Nexus\Stream\Component\Engine;

class HttpEngine extends Engine
{
    private CurlHandle $handle;

    protected function boot(): bool
    {
        $initializeCurlHandle = curl_init($this->address);

        if ($initializeCurlHandle === false) {
            return false;
        }
        $this->handle = $initializeCurlHandle;
        return true;
    }

    protected function execute(): bool
    {
        curl_setopt($this->handle, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($this->handle);

        if ($response === false) {
            return false;
        }

        $this->response = $response;
        return true;
    }

    protected function close(): void
    {
        curl_close($this->handle);
    }
}