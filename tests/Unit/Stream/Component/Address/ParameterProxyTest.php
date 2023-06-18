<?php

use Itsmattch\Nexus\Stream\Component\Address\Parameter;
use Itsmattch\Nexus\Stream\Component\Address\ParameterProxy;

it('wraps the parameter', function () {
    $parameter = new Parameter('{param}', 'param');
    $parameter->setValue('value');

    $proxy = new ParameterProxy($parameter, [], []);

    expect($proxy->getValue())->toBe($parameter->getValue());
    expect($proxy->getLiteral())->toBe($parameter->getLiteral());
});

it('captures the value', function () {
    $capture = new class {
        public function capture(): string
        {
            return 'foo';
        }
    };

    $parameter = new Parameter('{param}', 'param');

    $proxy = new ParameterProxy($parameter, [$capture, 'capture'], []);
    $proxy->setValue('bar');

    expect($proxy->getValue())->toBe('foo');
});

it('releases the value', function () {
    $release = new class {
        public function release(): string
        {
            return 'foo';
        }
    };

    $parameter = new Parameter('{param}', 'param');

    $proxy = new ParameterProxy($parameter, [], [$release, 'release']);

    expect($proxy->getValue())->toBe('foo');
});