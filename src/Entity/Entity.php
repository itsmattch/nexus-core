<?php

namespace Itsmattch\Nexus\Entity;

use Itsmattch\Nexus\Contract\Entity as EntityContract;
use Itsmattch\Nexus\Entity\Concerns\HasAttributes;
use Itsmattch\Nexus\Entity\Concerns\HasBadges;
use Itsmattch\Nexus\Entity\Concerns\HasDependencies;
use Itsmattch\Nexus\Entity\Concerns\HasRelationships;
use ReflectionClass;

/** todo */
abstract class Entity implements EntityContract
{
    use HasAttributes;
    use HasBadges;
    use HasDependencies;
    use HasRelationships;

    /**
     * The explicit name of the entity.
     */
    protected string $name;

    /**
     * The internal state of the entity name.
     */
    private string $internalName;

    /**
     * The generic name of the entity.
     */
    private string $genericName;

    public function __construct()
    {
        $this->loadGenericName();
        $this->loadInternalName();

        $this->bootAttributes();
        $this->bootBadges();
        $this->bootDependencies();
        $this->bootRelationships();
    }

    /**
     * @return string The generic name of the entity.
     */
    public function getGenericName(): string
    {
        return $this->genericName;
    }

    public function getName(): string
    {
        return $this->internalName ?? $this->getGenericName();
    }

    public function identifiesWith(string $badge, array $keys): bool
    {
        return true;
    }

    /**
     * Checks if the name property is set and assigns it to
     * the internalName property if not empty.
     */
    private function loadInternalName(): void
    {
        if (!empty($this->name)) {
            $this->internalName = $this->name;
        }
    }

    /**
     * Generates and assigns a generic name to the entity
     * based on its fully qualified class name. For
     * anonymous classes, it uses the first 8 characters
     * of an MD5 hash of the class name, prefixed with
     * 'anonymous_'.
     *
     * Important: The generic names of anonymous classes are
     * not reliable as the MD5 hash can vary across servers.
     */
    private function loadGenericName(): void
    {
        $reflectionClass = new ReflectionClass($this);
        $this->genericName = $reflectionClass->isAnonymous()
            ? 'anonymous_' . substr(strtolower(md5(get_class($this))), 0, 8)
            : strtolower(str_replace('\\', '_', get_class($this)));
    }
}