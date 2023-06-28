<?php

namespace Itsmattch\Nexus\Blueprint;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Blueprint as BlueprintContract;

abstract class Blueprint implements BlueprintContract
{
    use ArrayHelpers;

    private array $workingArray;

    private bool $processed = false;

    public function __construct(array $input)
    {
        $this->workingArray = $input;
    }

    /** todo */
    abstract protected function steps(): void;

    /** Sets new data root */
    public function root(string $newRoot): Blueprint
    {
        $this->workingArray = $this->traverseDotArray($newRoot, $this->workingArray);
        return $this;
    }

    /** Filters the array, keeping only those with empty value under given path */
    public function empty(string $path): Blueprint
    {
        $updatedArray = [];
        foreach ($this->workingArray as $key => $value) {
            $pathValue = $this->traverseDotArray($path, $value);
            if (empty($pathValue)) {
                $updatedArray[$key] = $value;
            }
        }
        $this->workingArray = $updatedArray;
        return $this;
    }

    /** Filters the array, keeping only those with not empty value under given path */
    public function notEmpty(string $path): Blueprint
    {
        $updatedArray = [];
        foreach ($this->workingArray as $key => $value) {
            $pathValue = $this->traverseDotArray($path, $value);
            if (!empty($pathValue)) {
                $updatedArray[$key] = $value;
            }
        }
        $this->workingArray = $updatedArray;
        return $this;
    }

    public function get(string $path): Blueprint
    {
        $this->workingArray = $this->traverseDotArray($path, $this->workingArray);
        return $this;
    }

    public function process(): void
    {
        if (!$this->processed) {
            $this->processed = true;
            $this->steps();
        }
    }

    public function getResult(): array
    {
        return $this->workingArray;
    }
}
