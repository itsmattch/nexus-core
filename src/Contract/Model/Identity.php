<?php

namespace Itsmattch\Nexus\Contract\Model;

interface Identity
{
    public function getBadge(): Badge;

    public function setBadge(Badge $badge): void;

    public function getValue(string $key): ?string;

    public function setValue(string $key, string $value): void;
}