<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model\Badge;
use Itsmattch\Nexus\Contract\Model\Identity as IdentityContract;

class Identity implements IdentityContract
{
    protected readonly Badge $badge;

    protected array $values = [];

    public function __construct(Badge $badge)
    {
        $this->setBadge($badge);
    }

    public function setBadge(Badge $badge): void
    {
        $this->badge = $badge;
    }

    public function getBadge(): Badge
    {
        return $this->badge;
    }

    public function setValue(string $key, string $value): void
    {
        $this->values[$key] = $value;
    }

    public function getValue(string $key): ?string
    {
        return $this->values[$key] ?? null;
    }
}