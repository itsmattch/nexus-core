<?php

namespace Itsmattch\Nexus\Assembler\Builder\Callable\Collection;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;

/** todo */
class JoinInvokable
{
    use ArrayHelpers;

    /** todo */
    private readonly string $joinArrayPath;

    /** todo */
    private readonly string $currentPath;

    /** todo */
    private readonly string $originalPath;

    /** todo */
    public function __construct(string $path)
    {
        $this->joinArrayPath = $path;
    }

    /** todo */
    public function __invoke(array $current, array $original): array
    {
        $dictionary = [];
        foreach ($this->traverseDotArray($this->joinArrayPath, $original) as $value) {
            $dictionary[$this->traverseDotArray($this->originalPath, $value)] = $value;
        }

        $newCurrent = [];
        foreach ($current as $key => $value) {
            $dictionaryKey = $this->traverseDotArray($this->currentPath, $value);
            if (!empty($dictionary[$dictionaryKey])) {
                $newCurrent[$key] = array_merge($value, $dictionary[$dictionaryKey]);
            }
        }
        return $newCurrent;
    }

    /** todo */
    public function on(string $current, string $original): void
    {
        $this->currentPath = $current;
        $this->originalPath = $original;
    }
}