<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;
use Itsmattch\Nexus\Contract\Model\Identity as IdentityContract;

class Badge implements BadgeContract
{
    /**
     * @var string Badge name.
     */
    protected readonly string $name;

    /**
     * @var array A list of keys required by the badge.
     */
    protected array $keys = [];

    /**
     * @var IdentityContract Assigned valid identity.
     */
    protected readonly IdentityContract $identity;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function equals(BadgeContract $badge): bool
    {
        return $this->name === $badge->getName();
    }

    public function setIdentity(IdentityContract $identity): void
    {
        $this->identity = $identity;
    }

    public function getIdentity(): ?IdentityContract
    {
        return $this->identity ?? null;
    }
}