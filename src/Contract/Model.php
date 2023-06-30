<?php

namespace Itsmattch\Nexus\Contract;

use Itsmattch\Nexus\Contract\Model\Badge;
use Itsmattch\Nexus\Contract\Model\Badge as BadgeContract;

interface Model
{
    /**
     * @return string the explicit name of the model if set,
     * or its generic name otherwise.
     */
    public function getName(): string;

    /**
     * Sets the custom name of the model. This method does
     * not allow for an existing name to be overridden.
     *
     * @param string $name The name to set for the model.
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
     * Adds a new badge to the model.
     *
     * @param BadgeContract $badge The badge to add to the
     * model.
     *
     * @return bool Returns true if the badge was added
     * successfully, false if a badge with the same name
     * already exists.
     */
    public function addBadge(Badge $badge): bool;

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
     * Checks whether the model identifies with a badge of
     * given name and if it has certain values assigned.
     *
     * @param string $badge The name of the badge.
     * @param array $keys An associative array where each
     * key is a part of the primary key and each value is
     * the corresponding value for that key.
     *
     * @return bool Returns true if the model identifies
     * with passed badge and keys, false otherwise.
     */
    public function identifiesWith(string $badge, array $keys): bool;
}