<?php

// __construct()
it('builds a collection of parameters', function () {
    //
});

it('treats all parameters of the same name as required if at least one is required', function () {
    //
});

it('allows setting parameter values upon construction', function () {
    //
});

// getAddress()
it('returns valid address', function () {
    //
});

it('does not return address without all required parameters set', function () {
    //
});

// getScheme()
it('returns scheme', function () {
    //
});

it('returns empty string if scheme is not present', function () {
    //
});

// isValid()
it('is valid if all required parameters are set', function () {
    //
});

it('is invalid otherwise', function () {
    //
});

// get()
it('returns explicit value of a parameter', function () {
    //
});

it('returns default value of a parameter', function () {
    //
});

it('returns empty string if a parameter has no value', function () {
    //
});

it('returns empty string if parameter of given name does not exist', function () {
    //
});

// set()
it('sets the explicit value of a parameter', function () {
    //
});

it('does not work if parameter of given name does not exist', function () {
    //
});

// has()
it('returns true if parameters exist in collection, even without values', function () {
    //
});

// hasValid()
it('returns true only if parameters exist in collection and have explicit or default values', function () {
    //
});

// getTemplate()
it('returns the template without any modifications', function () {
    //
});

// getCurrentState()
it('returns incomplete address', function () {
    //
});

// toString()
it('emulates getAddress method', function () {
    //
});

// validate()
it('throws exception if the scheme violates RFC 3986', function () {
    //
});