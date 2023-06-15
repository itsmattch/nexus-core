<?php

namespace Itsmattch\Nexus\Stream\Factory;

use Itsmattch\Nexus\Stream\Component\Address\Parameter;
use Itsmattch\Nexus\Stream\Component\Address\ParametersCollection;

/** Static factory of ParametersCollection class. */
class ParametersCollectionFactory
{
    /** Regular expression for finding parameters in a string. */
    protected static string $parametersTemplate = '/{(@)?([a-z0-9_]+)}/';

    /**
     * Creates ParametersCollection from a string. Accepts
     * $defaults array, which is used to fill default values
     * of created parameters.
     *
     * @param string $string String containing parameters.
     * @param array $defaults Default values of the parameters.
     * @return ParametersCollection Created collection.
     */
    public static function from(string $string, array $defaults = []): ParametersCollection
    {
        $collection = new ParametersCollection();
        preg_match_all(self::$parametersTemplate, $string, $parameters, PREG_SET_ORDER);

        foreach ($parameters as $parameter) {
            $name = $parameter[2];
            $default = $defaults[$name] ?? '';
            $optional = $parameter[1] == '@';

            $collection->set(new Parameter($name, $default, $optional));
        }
        return $collection;
    }
}