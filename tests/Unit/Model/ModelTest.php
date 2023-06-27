<?php

use Itsmattch\Nexus\Contract\Model\Badge;
use Itsmattch\Nexus\Model\Model;

// getName()
it('returns declared name', function () {
    $model = new class extends Model {
        protected string $name = 'name';
    };

    expect($model->getName())->toBe('name');
});

// setName()
it('returns set name', function () {
    $model = new class extends Model { };
    $model->bootOnce();
    $model->setName('name');

    expect($model->getName())->toBe('name');
});

// getGenericName()
it('returns generic name if name is empty', function () {
    $model = new class extends Model { };
    $model->bootOnce();

    expect($model->getName())->toBe($model->getGenericName());
});

// addBadge()
// getBadges()
it('accepts multiple unique badges', function () {
    $badgeOne = Mockery::mock(Badge::class);
    $badgeOne->shouldReceive('getName')->andReturn('one');

    $badgeTwo = Mockery::mock(Badge::class);
    $badgeTwo->shouldReceive('getName')->andReturn('two');

    $model = new class extends Model { };
    $model->bootOnce();
    $model->addBadge($badgeOne);
    $model->addBadge($badgeTwo);

    expect($model->getBadges())->toBeArray();
    expect($model->getBadges())->toHaveCount(2);
    expect($model->getBadges())->each()->toBeInstanceOf(Badge::class);
});

it('rejects badges with duplicate names', function () {
    $badgeOne = Mockery::mock(Badge::class);
    $badgeOne->shouldReceive('getName')->andReturn('badge');

    $badgeTwo = Mockery::mock(Badge::class);
    $badgeTwo->shouldReceive('getName')->andReturn('badge');

    $model = new class extends Model { };
    $model->bootOnce();
    $model->addBadge($badgeOne);
    $model->addBadge($badgeTwo);

    expect($model->getBadges())->toBeArray();
    expect($model->getBadges())->toHaveCount(1);
    expect($model->getBadges())->each()->toBeInstanceOf(Badge::class);
});

// getBadge()
// hasBadge()
it('retrieves badge by its name', function () {
    $badge = Mockery::mock(Badge::class);
    $badge->shouldReceive('getName')->andReturn('badge');

    $model = new class extends Model { };
    $model->bootOnce();
    $model->addBadge($badge);

    expect($model->hasBadge('badge'))->toBeTrue();
    expect($model->getBadge('badge'))->toBe($badge);
});

// identifiesWith()
// todo

// $badge
it('loads badges defined with $badges property', function () {
    $model = new class extends Model {
        protected array $badges = [
            'badge' => ['key', 'example']
        ];
    };
    $model->bootOnce();

    expect($model->getBadges())->toBeArray();
    expect($model->getBadges())->toHaveCount(1);
    expect($model->getBadges())->each()->toBeInstanceOf(Badge::class);
});