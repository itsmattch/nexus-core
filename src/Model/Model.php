<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model as ModelContract;
use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;
use Itsmattch\Nexus\Model\Exception\DuplicateBadgeException;
use ReflectionClass;

class Model implements ModelContract
{
    protected string $name;

    protected string $genericName;

    // todo boot it
    protected array $badges = [];

    /**
     * A list of accepted identities
     *
     * @var BadgeContract[]
     */
    private array $badgesList = [];

    public function __construct()
    {
        $this->setGenericName();
    }

    public function getGenericName(): string
    {
        return $this->genericName;
    }

    protected function setGenericName(): void
    {
        $reflectionClass = new ReflectionClass($this);
        $this->genericName = $reflectionClass->isAnonymous()
            ? 'anonymous_' . substr(strtolower(md5(get_class($this))), 0, 8)
            : strtolower(str_replace('\\', '_', get_class($this)));
    }

    public function getName(): string
    {
        return $this->name ?? $this->getGenericName();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBadges(): array
    {
        return $this->badgesList;
    }

    public function getBadge(string $name): ?BadgeContract
    {
        foreach ($this->badgesList as $badge) {
            if ($badge->getName() === $name) {
                return $badge;
            }
        }
        return null;
    }

    /**
     * @throws DuplicateBadgeException
     */
    public function addBadge(BadgeContract $badge): void
    {
        if ($this->hasBadge($badge->getName())) {
            throw new DuplicateBadgeException($badge->getName(), $this->getName());
        }
        $this->badgesList[] = $badge;
    }

    public function hasBadge(string $name): bool
    {
        return $this->getBadge($name) !== null;
    }

    public function identifiesWith(string $badge, array $values): bool
    {
        // todo
        return true;
    }
}