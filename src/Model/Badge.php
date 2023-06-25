<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;

class Badge implements BadgeContract
{
    protected readonly string $name;
    protected array $keys = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getKeys(): array
    {
        return $this->keys;
    }

    public function addKey(string $name): void
    {
        if (!in_array($name, $this->keys)) {
            $this->keys[] = $name;
        }
    }

    public function hasKey(string $name): bool
    {
        return in_array($name, $this->keys);
    }

    public function equals(BadgeContract $badge): bool
    {
        return $this->name === $badge->getName()
            && $this->keys === $badge->getKeys();
    }
}