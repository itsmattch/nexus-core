<?php

use Itsmattch\NexusCore\Assembler\Builder\Callable\Collection\JoinInvokable;

it('properly joins two arrays', function () {
    $invokable = new JoinInvokable('people');
    $invokable->on('id', 'personId');

    $current = [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 2, 'name' => 'Bob'],
    ];

    $original = [
        'people' => [
            ['personId' => 1, 'age' => 20],
            ['personId' => 2, 'age' => 25],
        ]
    ];

    $result = $invokable($current, $original);

    expect($result)->toBeArray();
    expect($result)->toHaveCount(2);
    expect($result)->toBe([
        ['id' => 1, 'name' => 'Alice', 'personId' => 1, 'age' => 20],
        ['id' => 2, 'name' => 'Bob', 'personId' => 2, 'age' => 25],
    ]);
});

it('does not add dictionary entry if key does not match', function () {
    $invokable = new JoinInvokable('people');
    $invokable->on('id', 'personId');

    $current = [
        ['id' => 1, 'name' => 'Alice'],
        ['id' => 3, 'name' => 'Charlie'],
    ];

    $original = [
        'people' => [
            ['personId' => 1, 'age' => 20],
            ['personId' => 2, 'age' => 25],
        ]
    ];

    $result = $invokable($current, $original);

    expect($result)->toBeArray();
    expect($result)->toHaveCount(1);
    expect($result)->toBe([
        ['id' => 1, 'name' => 'Alice', 'personId' => 1, 'age' => 20],
    ]);
});

it('properly works with empty arrays', function () {
    $invokable = new JoinInvokable('people');
    $invokable->on('id', 'personId');

    $current = [];

    $original = [
        'people' => [
            ['personId' => 1, 'age' => 20],
            ['personId' => 2, 'age' => 25],
        ]
    ];

    $result = $invokable($current, $original);

    expect($result)->toBeArray();
    expect($result)->toHaveCount(0);
    expect($result)->toBeEmpty();
});