<?php

namespace Itsmattch\Nexus\Stream\Engine;

use Itsmattch\Nexus\Stream\Component\Engine;

class HttpEngine extends Engine
{
    public function example(): void
    {
        // Initialize engine
        // todo $address here
        // curl_init()

        // Parametrize engine
        // todo $message here
        // - set headers...
        //   - authenticate...
        // - set http method...
        // - set body...

        // Execute engine & get response
        // curl_exec()

        // Close the stream
        // curl_close()
    }
}