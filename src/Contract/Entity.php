<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Entity\Badge;
use Itsmattch\Nexus\Contract\Entity\Badge as BadgeContract;

interface Entity
{
    /**
     * @return string the explicit name of the entity if set,
     * or its generic name otherwise.
     */
    public function getName(): string;

    /**
     * Sets the custom name of the entity. This method does
     * not allow for an existing name to be overridden.
     *
     * @param string $name The name to set for the entity.
     */
    public function setName(string $name): void;

    /**
     * @return array<BadgeContract> The array of badges.
     */
    public function getBadges(): array;

    /**
     * @param string $name The name of the badge to find.
     *
     * @return ?BadgeContract The found badge if found, or
     * null otherwise.
     */
    public function getBadge(string $name): ?Badge;

    /**
     * Adds a new badge to the entity.
     *
     * @param BadgeContract $badge The badge to add to the
     * entity.
     */
    public function addBadge(Badge $badge): void;

    /**
     * Checks whether a badge with the given name exists.
     *
     * @param string $name The name of the badge to check.
     *
     * @return bool Returns true if a badge with the given
     * name exists, false otherwise.
     */
    public function hasBadge(string $name): bool;

    /**
     * Checks whether the entity identifies with a badge of
     * given name and if it has certain values assigned.
     *
     * @param string $badge The name of the badge.
     * @param array $keys An associative array where each
     * key is a part of the primary key and each value is
     * the corresponding value for that key.
     *
     * @return bool Returns true if the entity identifies
     * with passed badge and keys, false otherwise.
     */
    public function identifiesWith(string $badge, array $keys): bool;
}