<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Model\Badge;

interface Model
{
    public function getName(): string;

    public function setName(string $name): void;

    public function getBadges(): array;

    public function getBadge(string $name): ?Badge;

    public function addBadge(Badge $badge): bool;

    public function hasBadge(string $name): bool;

    public function identifiesWith(string $badge, array $values): bool;
}