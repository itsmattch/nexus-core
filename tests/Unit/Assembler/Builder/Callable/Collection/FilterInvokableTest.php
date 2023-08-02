<?php

use Itsmattch\NexusCore\Assembler\Builder\Callable\Collection\FilterInvokable;

// empty()
it('invokes empty filter', function () {
    $items = [
        ['foo' => 'string', 'bar' => 'string'],
        ['foo' => 'string', 'bar' => null],
        ['foo' => null, 'bar' => 'string'],
        ['foo' => null, 'bar' => null],
    ];
    $invokable = new FilterInvokable('foo');
    $invokable->empty();

    $result = $invokable($items, $items);

    expect($result)->toBeArray();
    expect($result)->toHaveCount(2);
    expect(array_values($result))->toBe([
        ['foo' => null, 'bar' => 'string'],
        ['foo' => null, 'bar' => null],
    ]);
});

// notEmpty()
it('invokes not empty filter', function () {
    $items = [
        ['foo' => 'string', 'bar' => 'string'],
        ['foo' => 'string', 'bar' => null],
        ['foo' => null, 'bar' => 'string'],
        ['foo' => null, 'bar' => null],
    ];
    $invokable = new FilterInvokable('foo');
    $invokable->notEmpty();

    $result = $invokable($items, $items);

    expect($result)->toBeArray();
    expect($result)->toHaveCount(2);
    expect(array_values($result))->toBe([
        ['foo' => 'string', 'bar' => 'string'],
        ['foo' => 'string', 'bar' => null],
    ]);
});

// can stack many filters
it('stacks many filters', function () {
    $items = [
        ['foo' => 'string', 'bar' => 'string'],
        ['foo' => 'string', 'bar' => null],
        ['foo' => null, 'bar' => 'string'],
        ['foo' => null, 'bar' => null],
    ];
    $invokable = new FilterInvokable('foo');
    $invokable->notEmpty();
    $invokable->empty();

    $result = $invokable($items, $items);

    expect($result)->toBeArray();
    expect($result)->toHaveCount(0);
});