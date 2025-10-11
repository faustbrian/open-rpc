<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ContentDescriptor\SortsContentDescriptor;

it('returns null when no sorts are provided', function (): void {
    expect(SortsContentDescriptor::create([]))->toBeNull();
});

it('builds sorts content descriptor with asc and desc enums', function (): void {
    $sorts = [
        'users' => ['name', 'created_at'],
    ];

    $descriptor = SortsContentDescriptor::create($sorts);

    $enum = $descriptor['schema']['properties']['users']['items']['enum'];

    expect($descriptor)
        ->toBeArray()
        ->and($descriptor['name'])->toBe('sorts')
        ->and($descriptor['schema']['type'])->toBe('object')
        ->and($enum)->toContain('name', 'created_at', '-name', '-created_at');
});
