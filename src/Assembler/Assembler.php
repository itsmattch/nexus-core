<?php

namespace Itsmattch\Nexus\Assembler;

use Itsmattch\Nexus\Contract\Action;
use Itsmattch\Nexus\Contract\Assembler as AssemblerContract;
use Itsmattch\Nexus\Contract\Blueprint;
use Itsmattch\Nexus\Contract\Model;

class Assembler implements AssemblerContract
{
    //
    public function setAction(string $name, Action $action): void
    {
        // TODO: Implement setAction() method.
    }

    public function setBlueprint(Blueprint $blueprint): void
    {
        // TODO: Implement setBlueprint() method.
    }

    public function setModel(string $class): void
    {
        // TODO: Implement setModel() method.
    }

    public function assemble(): bool
    {
        // TODO: Implement assemble() method.
    }

    public function getModel(): Model
    {
        // TODO: Implement getModel() method.
    }
}