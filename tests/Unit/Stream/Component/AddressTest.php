<?php

use Itsmattch\Nexus\Stream\Component\Address;
use Itsmattch\Nexus\Stream\Factory\AddressFactory;

it('sets scalar parameters as strings', function () {
    $address = new class extends Address {
        protected string $template = '{param}';
    };
    $address = AddressFactory::from("{param}");
    $address->with('param', 123);

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('123');
});

it('allows stringable objects', function () {
    $stringable = new class implements Stringable {
        public function __toString(): string { return 'foo'; }
    };
    $address = new class extends Address {
        protected string $template = '{param}';
    };
    $address->with('param', $stringable);

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('foo');
});

it('accepts parameters passed with constructor', function () {
    $address = new class(['param' => 'foo']) extends Address {
        protected string $template = '{param}';
    };

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('foo');
});

it('emulates with() method', function () {
    $address = new class extends Address {
        protected string $template = '{param}';
    };
    $address->withParam('foo');

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('foo');
});

it('is valid when there are no parameters', function () {
    $address = new class extends Address {
        protected string $template = 'foo';
    };

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('foo');
});

it('is valid when there are only optional parameters', function () {
    $address = new class extends Address {
        protected string $template = '{@param1}foo{@param2}';
    };

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('foo');
});

it('is valid when all required parameters are set', function () {
    $address = new class extends Address {
        protected string $template = '{param1}foo{param2}';
    };
    $address->with('param1', 'foo');
    $address->with('param2', 'bar');

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('foofoobar');
});

it('is invalid when not all required parameters are set', function () {
    $address = new class extends Address {
        protected string $template = '{param1}foo{param2}';
    };
    $address->with('param1', 'foo');

    expect($address->isValid())->toBeFalse();
    expect($address->getCurrentState())->toBe('foofoo{param2}');
    expect($address->getAddress())->toBe('');
});

it('returns valid address', function () {
    $address = new class extends Address {
        protected string $template = '{param1}foo{@param2}';
    };
    $address->with('param1', 'foo');

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('foofoo');
});

it('does not return invalid address', function () {
    $address = new class extends Address {
        protected string $template = '{param1}foo{@param2}';
    };

    expect($address->isValid())->toBeFalse();
    expect($address->getAddress())->toBe('');
});

it('returns address template', function () {
    $address = new class extends Address {
        protected string $template = '{param1}foo{@param2}';
    };
    $address->with('param1', 'foo');

    expect($address->getTemplate())->toBe('{param1}foo{@param2}');
});

it('emulates getAddress() method when cast to a string', function () {
    $invalidAddress = new class extends Address {
        protected string $template = '{param1}foo{@param2}';
    };
    $validAddress = new class extends Address {
        protected string $template = '{@param1}foo{@param2}';
    };

    expect($invalidAddress)->toBeInstanceOf(Stringable::class);
    expect($validAddress)->toBeInstanceOf(Stringable::class);
    expect((string)$invalidAddress)->toBe('');
    expect((string)$validAddress)->toBe('foo');
});

it('captures parameters', function () {
    $address = new class extends Address {
        protected string $template = '{param}';

        public function captureParam(): string
        {
            return 'bar';
        }
    };
    $address->with('param', 'foo');

    expect($address->isValid())->toBeTrue();
    expect($address->getAddress())->toBe('bar');
});

it('enforces data type of parameters', function () {
    $address = new class extends Address {
        protected string $template = '{param}';

        public function captureParam(array $param = []): string
        {
            return 'bar';
        }
    };
    $address->with('param', true);
})->expectException(TypeError::class);