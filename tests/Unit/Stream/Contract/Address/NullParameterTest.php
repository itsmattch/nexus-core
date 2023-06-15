<?php

use Itsmattch\Nexus\Stream\Component\Address\NullParameter;

it('has only one instance', function () {
    $firstInstance = NullParameter::getInstance();
    $secondInstance = NullParameter::getInstance();

    expect($firstInstance)->toBe($secondInstance);
});

it('cannot have a value', function () {
    $instance = NullParameter::getInstance();
    $instance->setValue('value');

    expect($instance->getValue())->toBeEmpty();
});

it('is always invalid', function () {
    $instance = NullParameter::getInstance();

    expect($instance->isValid())->toBeFalse();
});