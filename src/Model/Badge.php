<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;
use Itsmattch\Nexus\Contract\Model\Identity as IdentityContract;
use Itsmattch\Nexus\Model\Exception\IncompatibleIdentityException;

class Badge implements BadgeContract
{
    protected string $name;
    protected array $keys = [];
    protected IdentityContract $identity;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (!empty($name)) {
            $this->name = $name;
        }
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

    /**
     * @throws IncompatibleIdentityException
     */
    public function setIdentity(IdentityContract $identity): void
    {
        if ($this->getKeys() !== $identity->getKeys()) {
            throw new IncompatibleIdentityException();
        }
        $this->identity = $identity;
    }

    public function getIdentity(): ?IdentityContract
    {
        return $this->identity ?? null;
    }
}