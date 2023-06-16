<?php

namespace Itsmattch\Nexus\Stream\Component\Address;

use Itsmattch\Nexus\Stream\Component\Address\Contract\ParameterInterface;

/**
 * This class represents a singleton Null Object extending
 * Parameter. It doesn't hold any meaningful value and is
 * considered invalid.
 */
class NullParameter implements ParameterInterface
{
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
    public function setValue($value): void {}

    public function getLiteral(): string
    {
        return '';
    }

    public function getName(): string
    {
        return '';
    }

    public function getValue(): string
    {
        return '';
    }

    public function isValid(): bool
    {
        return false;
    }
}