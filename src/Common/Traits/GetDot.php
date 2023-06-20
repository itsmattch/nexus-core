<?php

namespace Itsmattch\Nexus\Common\Traits;

trait GetDot
{
    protected function dotKey($path, $array) {
        $keys = explode('.', $path);

        $traverseArray = function ($array, $keys) use (&$traverseArray) {
            $key = array_shift($keys);

            if ($key === '*') {
                $allResults = [];
                foreach ($array as $item) {
                    if (!empty($keys)) {
                        $allResults[] = $traverseArray($item, $keys);
                    } else {
                        $allResults[] = $item;
                    }
                }
                return $allResults;
            } else if (is_array($array) && array_key_exists($key, $array)) {
                if (!empty($keys)) {
                    return $traverseArray($array[$key], $keys);
                } else {
                    return $array[$key];
                }
            }
            return null;
        };

        return $traverseArray($array, $keys);
    }
}