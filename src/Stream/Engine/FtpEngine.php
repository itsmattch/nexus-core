<?php

namespace Itsmattch\Nexus\Stream\Engine;

use Itsmattch\Nexus\Stream\Component\Engine;

class FtpEngine extends Engine
{
    public function example(): void
    {
        // Initialize engine
        // todo $address here => domain & port
        // ftp_connect()

        // Authenticate
        // ftp_login()

        // Execute engine & get response
        // todo $address here =>
        // ftp_get()

        // Close the stream
        // ftp_close()
    }
}