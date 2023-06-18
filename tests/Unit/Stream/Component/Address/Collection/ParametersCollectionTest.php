<?php

use Itsmattch\Nexus\Stream\Component\Address\Collection\ParametersCollection;
use Itsmattch\Nexus\Stream\Component\Address\OptionalParameter;
use Itsmattch\Nexus\Stream\Component\Address\Parameter;

it('is valid when all parameters are valid', function () {
    $firstParameter = new Parameter('{param}', 'param', 'default');
    $secondParameter = new OptionalParameter('{param}', 'param');
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

it('allows replacing parameters with the same name', function () {
    $firstParameter = new Parameter('{param1}', 'param');
    $firstParameter->setValue('value');

    $secondParameter = new Parameter('{param1}', 'param', 'default');

    $parametersCollection = new ParametersCollection();
    $parametersCollection->set($firstParameter);
    $parametersCollection->set($secondParameter);

    expect($parametersCollection)->toHaveCount(1);
    expect($parametersCollection->get('param')->getValue())->toBe('default');
});

it('is an iterator', function () {
    $parametersCollection = new ParametersCollection();
    $parametersCollection->set(new Parameter('{param1}', 'param1', 'default'));
    $parametersCollection->set(new Parameter('{param2}', 'param2', 'default'));
    $parametersCollection->set(new Parameter('{param3}', 'param3', 'default'));

    expect($parametersCollection)->toHaveCount(3);
    expect($parametersCollection)->each->toBeInstanceOf(Parameter::class);
});

it('checks if the collection has parameters', function () {
    $parametersCollection = new ParametersCollection();
    $parametersCollection->set(new Parameter('{param1}', 'param1', 'default'));
    $parametersCollection->set(new Parameter('{param2}', 'param2', 'default'));
    $parametersCollection->set(new Parameter('{param3}', 'param3', 'default'));

    $validHas = $parametersCollection->has('param1', 'param2');
    $invalidHas = $parametersCollection->has('param3', 'param4');

    expect($validHas)->toBeTrue();
    expect($invalidHas)->toBeFalse();
});

it('checks if the collection has valid parameters', function () {
    $parametersCollection = new ParametersCollection();
    $parametersCollection->set(new Parameter('{param1}', 'param1', 'default'));
    $parametersCollection->set(new Parameter('{param2}', 'param2', 'default'));
    $parametersCollection->set(new Parameter('{param3}', 'param3'));

    $validHas = $parametersCollection->hasValid('param1', 'param2');
    $invalidHas = $parametersCollection->hasValid('param2', 'param3');

    expect($validHas)->toBeTrue();
    expect($invalidHas)->toBeFalse();
});