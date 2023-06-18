<?php

use Itsmattch\Nexus\Stream\Component\Address\NullParameter;

it('does not allow overriding the value', function () {
    $parameter = NullParameter::getInstance();
    $parameter->setValue('value');

    expect($parameter->getValue())->toBe('');
});