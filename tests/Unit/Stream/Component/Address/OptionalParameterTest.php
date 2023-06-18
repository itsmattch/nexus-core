<?php

use Itsmattch\Nexus\Stream\Component\Address\OptionalParameter;

it('is valid when is optional and has no values', function () {
    $parameter = new OptionalParameter('{param}', 'param');

    expect($parameter->isValid())->toBeTrue();
});