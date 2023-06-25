<?php

namespace Itsmattch\Nexus\Model;

use Itsmattch\Nexus\Contract\Model as ModelContract;
use Itsmattch\Nexus\Contract\Model\Identity as IdentityContract;
use ReflectionClass;

class Model implements ModelContract
{
    protected readonly string $name;

    /**
     * A list of accepted identities
     *
     * @var IdentityContract[]
     */
    private array $identitiesList = [];

    public function getGenericName(): string
    {
        $reflectionClass = new ReflectionClass($this);
        if ($reflectionClass->isAnonymous()) {
            return 'anonymous_' . substr(strtolower(md5(get_class($this))), 0, 8);
        } else {
            return strtolower(str_replace('\\', '_', get_class($this)));
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getIdentities(): array
    {
        return $this->identitiesList;
    }

    public function addIdentity(IdentityContract $identity): void
    {
        foreach ($this->identitiesList as $existingIdentity) {
            if ($existingIdentity->getBadge()->equals($identity->getBadge())) {
                throw new \Exception();
            }
        }
        $this->identitiesList[] = $identity;
    }

    public function hasIdentity(IdentityContract $identity): bool
    {
        return in_array($identity, $this->identitiesList);
    }
}