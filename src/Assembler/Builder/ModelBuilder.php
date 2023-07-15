<?php

namespace Itsmattch\Nexus\Assembler\Builder;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Assembler\Builder\ModelBuilder as ModelBuilderContract;
use Itsmattch\Nexus\Contract\Model;

class ModelBuilder extends AssemblerBuilder implements ModelBuilderContract
{
    use ArrayHelpers;

    public function call(array $array, ?Model $model = null): array
    {
        $workingArray = $array;
        foreach ($this->callableStack as $callable) {
            $workingArray = $callable($model, $workingArray, $array);
        }
        $this->load($model, $workingArray);
        return $workingArray;
    }

    /** todo creates badge; removes data */
    public function badge(string $name, string $key, string $value): void
    {
        $this->callable(function (Model $model, array $current, array $original) use ($name, $key, $value) {
            $model->getBadge($name)?->getIdentity()?->setValue($key, $this->traverseDotArray($value, $current));
        });
    }

    /** todo final call; load remaining data */
    protected function load(Model $model, array $current): void
    {
        //
    }
}