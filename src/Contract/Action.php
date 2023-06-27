<?php

namespace Itsmattch\Nexus\Contract;

/**
 * The Stream class represents a single access point of data
 * within the Nexus system. It acts as an encapsulation of
 * all information necessary to access, read and interpret
 * a resource.
 *
 * @link https://nexus.itsmattch.com/streams/overview Streams Documentation
 */
interface Action
{
    public function setAddress(Address $address): void;

    public function setEngine(Engine $engine): void;

    public function setReader(Reader $reader): void;

    public function perform(): bool;

    public function getContent();
}