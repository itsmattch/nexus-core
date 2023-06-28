<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;
use Itsmattch\Nexus\Contract\Model\Identity as IdentityContract;

class Badge implements BadgeContract
{
    protected readonly string $name;
    protected array $keys = [];
    protected readonly IdentityContract $identity;

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

    public function addKeys(string ...$names): void
    {
        foreach ($names as $name) {
            if (!empty($name) && !in_array($name, $this->keys)) {
                $this->keys[] = $name;
            }
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

    public function setIdentity(IdentityContract $identity): bool
    {
        if (empty(array_diff($identity->getKeys(), $this->getKeys()))) {
            $this->identity = $identity;
            return true;
        }
        return false;
    }

    public function getIdentity(): ?IdentityContract
    {
        return $this->identity ?? null;
    }
}