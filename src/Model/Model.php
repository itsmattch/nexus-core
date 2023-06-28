<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model as ModelContract;
use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;
use ReflectionClass;

/** todo */
class Model implements ModelContract
{
    /** The explicit name of the model. */
    protected string $name;

    /** The internal state of the model name. */
    protected readonly string $internalName;

    /** The generic name of the model. */
    protected readonly string $genericName;

    /** A preset definition of badges. */
    protected array $badges = [];

    /** @var BadgeContract[] a list of Badges */
    private array $badgesList = [];

    public function __construct()
    {
        $this->loadInternalName();
        $this->loadGenericName();
        $this->normalizeBadges();
        $this->loadBadges();
    }

    /** todo */
    protected function loadInternalName(): void
    {
        if (isset($this->name) && !isset($this->internalName)) {
            $this->setName($this->name);
        }
    }

    /**
     * Generates and assigns a generic name to the model
     * based on its fully qualified class name. For
     * anonymous classes, it uses the first 8 characters
     * of an MD5 hash of the class name, prefixed with
     * 'anonymous_'.
     *
     * Important: The generic names of anonymous classes are
     * not reliable as the MD5 hash can vary across servers.
     */
    protected function loadGenericName(): void
    {
        $reflectionClass = new ReflectionClass($this);
        $this->genericName = $reflectionClass->isAnonymous()
            ? 'anonymous_' . substr(strtolower(md5(get_class($this))), 0, 8)
            : strtolower(str_replace('\\', '_', get_class($this)));
    }

    /**
     * Normalizes the badges by ensuring that all keys are
     * strings and all values are arrays.
     */
    protected function normalizeBadges(): void
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
    protected function loadBadges(): void
    {
        foreach ($this->badges as $name => $keys) {
            $badge = new Badge();
            $badge->setName($name);
            $badge->addKeys(...$keys);

            $this->addBadge($badge);
        }
    }

    /**
     * @return string The generic name of the model.
     */
    public function getGenericName(): string
    {
        return $this->genericName;
    }

    public function getName(): string
    {
        return $this->internalName ?? $this->getGenericName();
    }

    public function setName(string $name): void
    {
        $this->internalName = $name;
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

    public function addBadge(BadgeContract $badge): bool
    {
        if ($this->hasBadge($badge->getName())) {
            return false;
        }
        $this->badgesList[] = $badge;
        return true;
    }

    public function hasBadge(string $name): bool
    {
        return $this->getBadge($name) !== null;
    }

    public function identifiesWith(string $badge, array $keys): bool
    {
        return true;
    }
}