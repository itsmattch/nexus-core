<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

/**
 * This class represents a singleton Null Object extending
 * Parameter. It doesn't hold any meaningful value and is
 * considered invalid.
 */
class NullParameter extends Parameter
{
    protected string $name = '';

    protected string $default = '';

    protected bool $optional = false;

    protected string $value = '';

    protected static NullParameter $instance;

    /**
     * Returns the singleton instance of the NullParameter class.
     *
     * @return NullParameter The singleton instance.
     */
    public static function getInstance(): NullParameter
    {
        if (empty(self::$instance)) {
            self::$instance = new NullParameter();
        }
        return self::$instance;
    }

    /**
     * The private constructor for the NullParameter class.
     * Prevents external instantiation.
     */
    private function __construct() {}

    /**
     * Overrides the setValue method from Parameter.
     * It does nothing since the NullParameter is
     * forbidden to hold any meaningful value.
     */
    public function setValue(string $value): void {}
}