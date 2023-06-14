<?php

use Itsmattch\Nexus\Stream\Contract\Address\ParametersCollection;
use Itsmattch\Nexus\Stream\Contract\Address\ParametersCollectionFactory;

it('creates collection', function () {
    $collection = ParametersCollectionFactory::from('{param1}{param2}');

    expect($collection)->toBeInstanceOf(ParametersCollection::class);
    expect($collection)->toHaveCount(2);
    expect($collection->isValid())->toBeFalse();
});

it('interprets @ as optional parameter', function () {
    $collection = ParametersCollectionFactory::from('{@param1}{@param2}');

    expect($collection)->toBeInstanceOf(ParametersCollection::class);
    expect($collection)->toHaveCount(2);
    expect($collection->isValid())->toBeTrue();
});