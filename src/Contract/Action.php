<?php

namespace Itsmattch\Nexus\Contract;

/**
 * Action represents a singular action performable on a
 * resource, like reading or writing.
 *
 * @link https://nexus.itsmattch.com/the-basics/action Actions Documentation
 */
interface Action
{
    /**
     * @param Address $address An instance of the Address
     * class representing the resource's address.
     */
    public function setAddress(Address $address): void;

    /**
     * @param Engine $engine An instance of the Engine class
     * that defines the methods for accessing the resource.
     */
    public function setEngine(Engine $engine): void;

    /**
     * @param Reader $reader An instance of the Reader class
     * that defines methods for interpreting raw resource
     * data.
     */
    public function setReader(Reader $reader): void;

    /**
     * Attempts to access and read the resource.
     *
     * @return bool Returns true if the attempt was
     * successful, false otherwise.
     */
    public function perform(): bool;

    /**
     * todo return Resource instead?
     *
     * @return array Returns the content of the resource as
     * an array, with the content structure depending on the
     * resource type.
     */
    public function getContent(): array;
}