<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model as ModelContract;
use Itsmattch\Nexus\Contract\Model\Identity as IdentityContract;
use Itsmattch\Nexus\Model\Exception\DuplicateIdentityException;
use ReflectionClass;

class Model implements ModelContract
{
    protected string $name;

    protected string $genericName;

    /**
     * A list of accepted identities
     *
     * @var IdentityContract[]
     */
    private array $identitiesList = [];

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

    public function getIdentities(): array
    {
        return $this->identitiesList;
    }

    /**
     * @throws DuplicateIdentityException
     */
    public function addIdentity(IdentityContract $identity): void
    {
        foreach ($this->identitiesList as $existingIdentity) {
            if ($existingIdentity->getBadge()->equals($identity->getBadge())) {
                throw new DuplicateIdentityException($this->getName(), $identity->getBadge()->getName());
            }
        }
        $this->identitiesList[] = $identity;
    }

    public function hasIdentity(IdentityContract $identity): bool
    {
        return in_array($identity, $this->identitiesList);
    }
}