<?php

namespace Itsmattch\Nexus\Model;

use Exception;
use Itsmattch\Nexus\Contract\Common\Bootable;
use Itsmattch\Nexus\Contract\Model as ModelContract;
use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;
use ReflectionClass;

/** todo */
class Model implements ModelContract, Bootable
{
    /** The explicit name of the model. */
    protected string $name;

    /** The generic name of the model. */
    protected string $genericName;

    /** A preset definition of badges. */
    protected array $badges = [];

    /** The model's bootOnce status. */
    private bool $bootedOnce = false;

    /** The model's booting result. */
    private bool $bootingResult = false;

    /** @var BadgeContract[] a list of Badges */
    private array $badgesList = [];

    /**
     * Executes the booting process once. Returns false on
     * subsequent attempts.
     *
     * @return bool True if the booting was successful,
     * false if the booting was already attempted or if
     * it failed.
     */
    public function bootOnce(): bool
    {
        if ($this->bootedOnce) {
            return false;
        }

        $this->bootedOnce = true;
        return $this->boot();
    }

    /**
     * Attempts to boot the model. Any exception encountered
     * during booting causes this method to return false.
     *
     * @return bool True if the booting was successful,
     * false if an exception was encountered.
     */
    public function boot(): bool
    {
        try {
            $this->loadGenericName();
            $this->normalizeBadges();
            $this->loadBadges();

            $this->bootingResult = true;

        } catch (Exception) {
            $this->bootingResult = false;

        } finally {
            return $this->bootingResult;
        }
    }

    /**
     * Checks if the model has been successfully booted.
     *
     * @return bool True if the model has been successfully
     * booted, false otherwise.
     */
    public function isBooted(): bool
    {
        return $this->bootingResult;
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

    /**
     * @return string the explicit name of the model if set,
     * or its generic name otherwise.
     */
    public function getName(): string
    {
        return $this->name ?? $this->getGenericName();
    }

    /**
     * Sets the custom name of the model. This method does
     * not allow for an existing name to be overridden.
     *
     * @param string $name The name to set for the model.
     */
    public function setName(string $name): void
    {
        if (!isset($this->name)) {
            $this->name = $name;
        }
    }

    /**
     * @return BadgeContract[] The array of badges.
     */
    public function getBadges(): array
    {
        return $this->badgesList;
    }

    /**
     * @param string $name The name of the badge to find.
     *
     * @return ?BadgeContract The found badge if found, or
     * null otherwise.
     */
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
     * Adds a new badge to the model.
     *
     * @param BadgeContract $badge The badge to add to the
     * model.
     *
     * @return bool True if the badge was added
     * successfully, false if a badge with the same name
     * already exists.
     */
    public function addBadge(BadgeContract $badge): bool
    {
        if ($this->hasBadge($badge->getName())) {
            return false;
        }
        $this->badgesList[] = $badge;
        return true;
    }

    /**
     * Checks whether a badge with the given name exists.
     *
     * @param string $name The name of the badge to check.
     *
     * @return bool True if a badge with the given name
     * exists, false otherwise.
     */
    public function hasBadge(string $name): bool
    {
        return $this->getBadge($name) !== null;
    }

    // todo
    public function identifiesWith(string $badge, array $values): bool
    {
        return true;
    }
}