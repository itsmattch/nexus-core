<?php

use Itsmattch\Nexus\Contract\Entity\Badge;
use Itsmattch\Nexus\Entity\Entity;

// getName()
it('returns declared name', function () {
    $entity = new class extends Entity {
        protected string $name = 'name';
    };

    expect($entity->getName())->toBe('name');
});

// setName()
it('returns set name', function () {
    $entity = new class extends Entity { };
    $entity->setName('name');

    expect($entity->getName())->toBe('name');
});

// getGenericName()
it('returns generic name if name is empty', function () {
    $entity = new class extends Entity { };

    expect($entity->getName())->toBe($entity->getGenericName());
});

// addBadge()
// getBadges()
it('accepts multiple unique badges', function () {
    $badgeOne = Mockery::mock(Badge::class);
    $badgeOne->shouldReceive('getName')->andReturn('one');

    $badgeTwo = Mockery::mock(Badge::class);
    $badgeTwo->shouldReceive('getName')->andReturn('two');

    $entity = new class extends Entity { };
    $entity->addBadge($badgeOne);
    $entity->addBadge($badgeTwo);

    expect($entity->getBadges())->toBeArray();
    expect($entity->getBadges())->toHaveCount(2);
    expect($entity->getBadges())->each()->toBeInstanceOf(Badge::class);
});

it('rejects badges with duplicate names', function () {
    $badgeOne = Mockery::mock(Badge::class);
    $badgeOne->shouldReceive('getName')->andReturn('badge');

    $badgeTwo = Mockery::mock(Badge::class);
    $badgeTwo->shouldReceive('getName')->andReturn('badge');

    $entity = new class extends Entity { };
    $entity->addBadge($badgeOne);
    $entity->addBadge($badgeTwo);

    expect($entity->getBadges())->toBeArray();
    expect($entity->getBadges())->toHaveCount(1);
    expect($entity->getBadges())->each()->toBeInstanceOf(Badge::class);
});

// getBadge()
// hasBadge()
it('retrieves badge by its name', function () {
    $badge = Mockery::mock(Badge::class);
    $badge->shouldReceive('getName')->andReturn('badge');

    $entity = new class extends Entity { };
    $entity->addBadge($badge);

    expect($entity->hasBadge('badge'))->toBeTrue();
    expect($entity->getBadge('badge'))->toBe($badge);
});

// identifiesWith()
// todo

// $badge
it('loads badges defined with $badges property', function () {
    $entity = new class extends Entity {
        protected array $badges = [
            'badge' => ['key', 'example']
        ];
    };

    expect($entity->getBadges())->toBeArray();
    expect($entity->getBadges())->toHaveCount(1);
    expect($entity->getBadges())->each()->toBeInstanceOf(Badge::class);
});