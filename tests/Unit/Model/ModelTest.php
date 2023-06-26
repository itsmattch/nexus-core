<?php

use Itsmattch\Nexus\Contract\Model\Badge;
use Itsmattch\Nexus\Contract\Model\Identity;
use Itsmattch\Nexus\Model\Exception\DuplicateIdentityException;
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
    $model->setName('name');

    expect($model->getName())->toBe('name');
});

// getGenericName()
it('returns generic name if name is empty', function () {
    $model = new class extends Model { };

    expect($model->getName())->toBe($model->getGenericName());
});

// addIdentity($identity)
it('does not accept identities with duplicate badges', function () {
    $badge = Mockery::mock(Badge::class);
    $badge->shouldReceive('equals')->andReturn(true);
    $badge->shouldReceive('getName')->andReturn('name');

    $identityOne = Mockery::mock(Identity::class);
    $identityOne->shouldReceive('getBadge')->andReturn($badge);

    $identityTwo = Mockery::mock(Identity::class);
    $identityTwo->shouldReceive('getBadge')->andReturn($badge);

    $model = new class extends Model { };

    $model->addIdentity($identityOne);
    $model->addIdentity($identityTwo);
})->expectException(DuplicateIdentityException::class);

// hasIdentity($identity)
it('accepts identities', function () {
    $identity = Mockery::mock(Identity::class);

    $model = new class extends Model { };
    $model->addIdentity($identity);

    expect($model->hasIdentity($identity))->toBe(true);
});

// getIdentities()
it('returns all identities', function () {
    $badgeOne = Mockery::mock(Badge::class);
    $badgeOne->shouldReceive('equals')->andReturn(false);

    $identityOne = Mockery::mock(Identity::class);
    $identityOne->shouldReceive('getBadge')->andReturn($badgeOne);

    $badgeTwo = Mockery::mock(Badge::class);

    $identityTwo = Mockery::mock(Identity::class);
    $identityTwo->shouldReceive('getBadge')->andReturn($badgeTwo);

    $model = new class extends Model { };
    $model->addIdentity($identityOne);
    $model->addIdentity($identityTwo);

    expect($model->getIdentities())->toBeArray();
    expect($model->getIdentities())->toHaveCount(2);
    expect($model->getIdentities())->each()->toBeInstanceOf(Identity::class);
});
