<?php

it('builds a collection of parameters', function () {
    //
});

it('treats all parameters of the same name as required if at least one is required', function () {
    //
});

it('allows setting parameter values upon construction', function () {
    //
});

it('returns valid address', function () {
    //
});

it('does not return address without all required parameters set', function () {
    //
});

// getScheme()
// - returns scheme
// - returns empty string if scheme is not present
it('returns scheme', function () {
    //
});

// isValid()
// - returns valid if all required parameters are set
// - returns invalid otherwise

// get()
// - returns value of a parameter
// - returns default value of a parameter
// - returns empty string if a parameter has no value (no explicit nor default)
// - returns empty string if a parameter of given name does not exist

// set()
// - sets the explicit value of a parameter
// - does not work if parameter of given name does not exist

// has()
// - returns true if parameters exist in collection, even without values

// hasValid()
// - returns true only if parameters exist in collection and have values

// getTemplate()
// - returns template without any modifications

// getCurrentState()
// - returns current state of Address, which can contain parameter declarations

// call()
// - allows isParam(true) eg Address->isSecure(true)
// - allows setParam(true) eg Address->setSecure(true)
// - allows withParam(true) eg Address->withSecure(true)

// toString()
// - emulates getAddress