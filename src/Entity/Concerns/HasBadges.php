<?php

namespace Itsmattch\Nexus\Entity\Concerns;

use Itsmattch\Nexus\Contract\Entity\Badge as BadgeContract;
use Itsmattch\Nexus\Entity\Badge;
use Itsmattch\Nexus\Entity\Identity;

/** todo */
trait HasBadges
{
    /**
     * A preset definition of badges.
     */
    protected array $badges = [];

    /**
     * @var array<BadgeContract> a list of Badges
     */
    private array $internalBadges = [];

    public function bootBadges(): void
    {
        $this->normalizeBadges();
        $this->loadBadges();
    }

    public function getBadges(): array
    {
        return $this->internalBadges;
    }

    public function setBadge(BadgeContract $badge): void
    {
        $this->internalBadges[$badge->getName()] = $badge;
    }

    public function getBadge(string $name): ?BadgeContract
    {
        foreach ($this->internalBadges as $badge) {
            if ($badge->getName() === $name) {
                return $badge;
            }
        }
        return null;
    }

    public function hasBadge(string $name): bool
    {
        return $this->getBadge($name) !== null;
    }

    /**
     * Normalizes the badges by ensuring that all keys are
     * strings and all values are arrays.
     */
    private function normalizeBadges(): void
    {
        $fixedBadges = [];
        foreach ($this->badges as $name => $keysDefinition) {
            $fixedBadges[(string)$name] = is_array($keysDefinition) ? $keysDefinition : [$keysDefinition];
        }
        $this->badges = $fixedBadges;
    }

    /**
     * Loads the badges. The method expects keys to be
     * non-empty strings and values to be arrays of strings.
     */
    private function loadBadges(): void
    {
        foreach ($this->badges as $name => $keys) {
            $identity = new Identity();
            $identity->addKeys(...$keys);

            $badge = new Badge();
            $badge->setName($name);
            $badge->setIdentity($identity);

            $this->internalBadges[$name] = $badge;
        }
    }
}