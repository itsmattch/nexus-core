<?php

use Itsmattch\Nexus\Stream\Contract\Address\Parameter;
use Itsmattch\Nexus\Stream\Contract\Address\ParametersCollection;

it('is valid when all parameters are valid', function () {
    $firstParameter = new Parameter('param', 'default');
    $secondParameter = new Parameter('param', '', false);
    $secondParameter->setValue('value');

    $parametersCollection = new ParametersCollection();
    $parametersCollection->set($firstParameter);
    $parametersCollection->set($secondParameter);

    expect($parametersCollection->isValid())->toBeTrue();
});

it('is invalid when at least one parameter is invalid', function () {
    $firstParameter = new Parameter('param', 'default');
    $secondParameter = new Parameter('param', '', false);

    $parametersCollection = new ParametersCollection();
    $parametersCollection->set($firstParameter);
    $parametersCollection->set($secondParameter);

    expect($parametersCollection->isValid())->toBeFalse();
});

it('iterates', function () {
    $parametersCollection = new ParametersCollection();
    $parametersCollection->set(new Parameter('param1', 'default'));
    $parametersCollection->set(new Parameter('param2', 'default'));
    $parametersCollection->set(new Parameter('param3', 'default'));

    expect($parametersCollection)->toHaveCount(3);
    expect($parametersCollection)->each->toBeInstanceOf(Parameter::class);
});