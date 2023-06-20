<?php

namespace Itsmattch\Nexus\Resource\Factory;

use Itsmattch\Nexus\Resource\Component\Address\Collection\ParametersCollection;
use Itsmattch\Nexus\Resource\Component\Address\OptionalParameter;
use Itsmattch\Nexus\Resource\Component\Address\Parameter;
use Itsmattch\Nexus\Resource\Component\Address\ParameterProxy;

/** Static factory class for creating ParametersCollection instances. */
class ParametersCollectionFactory
{
    /** Regular expression for finding parameters in a string. */
    protected static string $parametersTemplate = '/(?<literal>{(?<optional>@)?(?<name>[a-z0-9_]+)})/';

    /**
     * Creates ParametersCollection from a string. Accepts
     * $defaults array, which is used to fill default values
     * of created parameters.
     *
     * @param string $template String containing parameters.
     * @param array $defaults Default values of the parameters.
     * @return ParametersCollection Created collection.
     */
    public static function from(string $template, array $defaults = [], ?object $callbackSubject = null): ParametersCollection
    {
        $collection = new ParametersCollection();

        preg_match_all(self::$parametersTemplate, $template, $parameters, PREG_SET_ORDER);

        foreach ($parameters as $parameter) {
            $literal = $parameter['literal'];
            $name = $parameter['name'];
            $camelName = self::snakeToCamel($name);
            $default = $defaults[$name] ?? '';
            $optional = (bool)$parameter['optional'];

            $parameterObject = $optional
                ? new OptionalParameter($literal, $name, $default)
                : new Parameter($literal, $name, $default);

            if ($callbackSubject) {
                $parameterObject = new ParameterProxy(
                    $parameterObject,
                    [$callbackSubject, "capture$camelName"],
                    [$callbackSubject, "release$camelName"],
                );
            }

            $collection->set($parameterObject);
        }
        return $collection;
    }

    /**
     * Turns snake-case string into camel-case, with first
     * letter being uppercase.
     *
     * @param string $name
     * @return string
     */
    protected static function snakeToCamel(string $name): string
    {
        return str_replace('_', '', ucwords($name, '_'));
    }

    /** Disallow instantiation of the factory. */
    private function __construct() {}
}