<?php

namespace Itsmattch\Nexus\Assembler\Builder\Callable\Collection;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Assembler\Builder\Callable\Invokable;

/**
 * Merges two arrays using one as a base
 * and the other as a dictionary.
 */
class JoinInvokable implements Invokable
{
    use ArrayHelpers;

    /**
     * The root path for the elements that
     * should be turned into a dictionary.
     */
    private readonly string $dictionaryRoot;

    /**
     * The property used as a key in the base array.
     */
    private readonly string $left;

    /**
     * The property used as a key in the dictionary array.
     */
    private readonly string $right;

    /**
     * @var string $dictionaryRoot The root path for the
     * elements that should be turned into a dictionary.
     */
    public function __construct(string $dictionaryRoot)
    {
        $this->dictionaryRoot = $dictionaryRoot;
    }

    /**
     * Merge the base array with the dictionary array
     * using the defined properties as keys.
     */
    public function __invoke(array $current, array $original): array
    {
        $dictionary = [];
        foreach ($this->traverseDotArray($this->dictionaryRoot, $original) as $value) {
            $dictionary[$this->traverseDotArray($this->right, $value)] = $value;
        }

        $newCurrent = [];
        foreach ($current as $key => $value) {
            $dictionaryKey = $this->traverseDotArray($this->left, $value);
            if (!empty($dictionary[$dictionaryKey])) {
                $newCurrent[$key] = array_merge($value, $dictionary[$dictionaryKey]);
            }
        }
        return $newCurrent;
    }

    /**
     * Define the properties that will be
     * used as keys in the merge operation.
     */
    public function on(string $left, string $right): void
    {
        $this->left = $left;
        $this->right = $right;
    }
}