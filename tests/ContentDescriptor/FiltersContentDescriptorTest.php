<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ContentDescriptor\FiltersContentDescriptor;

it('returns null when no filters are provided', function (): void {
    expect(FiltersContentDescriptor::create([]))->toBeNull();
});

it('builds filters content descriptor with enum constraints', function (): void {
    $filters = [
        'users' => ['name', 'email', 'active'],
    ];

    $descriptor = FiltersContentDescriptor::create($filters);

    expect($descriptor)
        ->toBeArray()
        ->and($descriptor['name'])->toBe('filters')
        ->and($descriptor['schema']['type'])->toBe('object')
        ->and($descriptor['schema']['properties']['users']['items']['enum'])
        ->toEqual(['name', 'email', 'active']);
});
