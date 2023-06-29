<?php

use Itsmattch\Nexus\Address\Address;

// __construct()
it('treats all parameters of the same name as required if at least one is required', function () {
    $address = new class extends Address {
        protected string $template = 'https://{domain}/{@domain}/';
    };

    expect($address->isValid())->toBeFalse();
});

it('allows setting parameter values upon construction', function () {
    $address = new class(['domain' => 'example.com']) extends Address {
        protected string $template = 'https://{domain}/';
    };

    expect($address->getAddress())->toBe('https://example.com/');
});

// getAddress()
it('returns valid address', function () {
    $address = new class extends Address {
        protected string $template = 'https://{domain}/{@path}';
        protected array $defaults = ['domain' => 'example.com'];
    };

    expect($address->getAddress())->toBe('https://example.com/');
});

it('does not return address without all required parameters set', function () {
    $address = new class extends Address {
        protected string $template = 'https://{domain}/';
    };

    expect($address->getAddress())->toBe('');
});

// getScheme()
it('returns scheme', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    $address->setValue('domain', 'example.com');

    expect($address->getScheme())->toBe('https');
});

it('returns scheme even when the address is invalid', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    expect($address->isValid())->toBeFalse();
    expect($address->getScheme())->toBe('https');
});

// isValid()
it('is valid if all required parameters are set', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    $address->setValue('domain', 'example.com');

    expect($address->isValid())->toBeTrue();
});

it('is invalid when not all required parameters are set', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    expect($address->isValid())->toBeFalse();
});

// get()
it('returns default and explicit value of a parameter', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    $address->setValue('domain', 'example.com');

    expect($address->getValue('scheme'))->toBe('https');
    expect($address->getValue('domain'))->toBe('example.com');
});

it('returns empty string if a parameter has no value', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    expect($address->getValue('domain'))->toBe('');
    expect($address->getValue('path'))->toBe('');
});

it('returns empty string if parameter of given name does not exist', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    expect($address->getValue('invalid'))->toBe('');
});

// set()
it('does not break anything if a parameter of given name does not exist', function () {
    $address = new class extends Address {
        protected string $template = 'https://{domain}/{@path}';
        protected array $defaults = ['domain' => 'example.com'];
    };

    $address->setValue('invalid', 'foo');

    expect($address->isValid())->toBeTrue();
});

it('prefers explicit value over default one', function () {
    $address = new class extends Address {
        protected string $template = 'https://{domain}/';
        protected array $defaults = ['domain' => 'example.com'];
    };

    $address->setValue('domain', 'google.com');

    expect($address->getAddress())->toBe('https://google.com/');
});

// has()
it('returns true if parameters exist in collection, even without values', function () {
    $address = new class extends Address {
        protected string $template = 'https://{domain}/{path}?{@query_string}';
    };

    expect($address->has('domain', 'path', 'query_string'))->toBeTrue();
    expect($address->has('domain', 'path', 'query_string', 'invalid'))->toBeFalse();
});

// hasValid()
it('returns true only if parameters exist in collection and are valid', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{@path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    $address->setValue('domain', 'example.com');

    expect($address->hasValid('domain', 'path', 'path'))->toBeTrue();
});

// getTemplate()
it('returns the template without any modifications', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    $address->setValue('domain', 'example.com');

    expect($address->getTemplate())->toBe('{scheme}://{domain}/{path}');
});

// getCurrentState()
it('returns incomplete address', function () {
    $address = new class extends Address {
        protected string $template = '{scheme}://{domain}/{path}';
        protected array $defaults = ['scheme' => 'https'];
    };

    $address->setValue('domain', 'example.com');

    expect($address->getCurrentState())->toBe('https://example.com/{path}');
});

// toString()
it('emulates getAddress method', function () {
    $address = new class extends Address {
        protected string $template = 'https://example.com/';
    };

    expect((string)$address)->toBe($address->getAddress());
});