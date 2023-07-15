<?php

namespace Itsmattch\Nexus\Assembler\Builder;

use Itsmattch\Nexus\Common\Traits\ArrayHelpers;
use Itsmattch\Nexus\Contract\Assembler\Builder\EntityBuilder as EntityBuilderContract;
use Itsmattch\Nexus\Contract\Entity;

class EntityBuilder extends AssemblerBuilder implements EntityBuilderContract
{
    use ArrayHelpers;

    public function call(array $array, ?Entity $entity = null): array
    {
        $workingArray = $array;
        foreach ($this->callableStack as $callable) {
            $workingArray = $callable($entity, $workingArray, $array);
        }
        $this->load($entity, $workingArray);
        return $workingArray;
    }

    /** todo creates badge; removes data */
    public function badge(string $name, string $key, string $value): void
    {
        $this->callable(function (Entity $entity, array $current, array $original) use ($name, $key, $value) {
            $entity->getBadge($name)?->getIdentity()?->setValue($key, $this->traverseDotArray($value, $current));
        });
    }

    /** todo final call; load remaining data */
    protected function load(Entity $entity, array $current): void
    {
        //
    }
}