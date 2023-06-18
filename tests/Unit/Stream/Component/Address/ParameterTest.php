<?php
use Itsmattch\Nexus\Stream\Component\Address\Parameter;

it('returns default value when no explicit value is set', function () {
    $parameter = new Parameter('{param}', 'param', 'default');

    expect($parameter->getValue())->toBe('default');
});

it('returns explicit value when both are present', function () {
    $parameter = new Parameter('{param}', 'param', 'default');
    $parameter->setValue('value');

    expect($parameter->getValue())->toBe('value');
});

it('is valid when explicit value is set', function () {
    $parameter = new Parameter('{param}', 'param');
    $parameter->setValue('value');

    expect($parameter->isValid())->toBeTrue();
});

it('is invalid when is not optional and explicit value is not set ', function () {
    $parameter = new Parameter('{param}', 'param');

    expect($parameter->isValid())->toBeFalse();
});

it('emulates getValue() method when cast to a string', function () {
    $parameter = new Parameter('{param}', 'param');
    $parameter->setValue('value');

    expect((string)$parameter)->toBe('value');
});