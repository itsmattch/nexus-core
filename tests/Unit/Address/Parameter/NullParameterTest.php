<?php

use Itsmattch\Nexus\Address\Parameter\NullParameter;

// __construct()
it('is a singleton', function () {
    $nullOne = NullParameter::getInstance();
    $nullTwo = NullParameter::getInstance();

    expect($nullOne)->toBe($nullTwo);
});

it('disallows changing the value', function () {
    $null = NullParameter::getInstance();
    $null->setValue('foo');

    expect($null->getValue())->toBeEmpty();
});

it('does not have a literal nor a name', function () {
    $null = NullParameter::getInstance();

    expect($null->getLiteral())->toBeEmpty();
    expect($null->getName())->toBeEmpty();
});

// isValid(): bool
it('is always invalid', function () {
    $null = NullParameter::getInstance();

    expect($null->isValid())->toBeFalse();
});
