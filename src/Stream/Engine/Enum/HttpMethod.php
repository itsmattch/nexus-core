<?php

namespace Itsmattch\Nexus\Stream\Engine\Enum;

enum HttpMethod
{
    case GET;
    case POST;
    case PUT;
    case PATCH;
    case DELETE;
}