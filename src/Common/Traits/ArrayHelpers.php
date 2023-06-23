<?php

namespace Itsmattch\Nexus\Common\Traits;

trait ArrayHelpers
{
    /**
     * Splits the provided dot-separated path into keys and
     * invokes traverseArray function to fetch the value
     * from the provided array based on these keys.
     *
     * @param string $path The dot-separated path.
     * @param array $array The array to be traversed.
     * @return mixed The value from the array based on the
     * provided path, or an array of values if path includes
     * '*'. Returns null if the key does not exist.
     */
    private function traverseDotArray(string $path, array $array): mixed
    {
        return $this->traverseArray(explode('.', $path), $array);
    }

    /**
     * Recursively traverse through the array based on
     * provided keys.
     *
     * @param array $keys The keys for the array traversal.
     * @param array $array The array to be traversed.
     * @return mixed The value from the array based on the
     * provided keys, or an array of values if keys include
     * '*'. Returns null if the key does not exist.
     */
    private function traverseArray(array $keys, array $array): mixed
    {
        $key = array_shift($keys);

        if ($key === '*') {
            return array_map(function ($item) use ($keys) {
                return empty($keys) ? $item : $this->traverseArray($keys, $item);
            }, $array);

        } else if (isset($array[$key])) {
            return empty($keys) ? $array[$key] : $this->traverseArray($keys, $array[$key]);
        }
        return null;
    }
}