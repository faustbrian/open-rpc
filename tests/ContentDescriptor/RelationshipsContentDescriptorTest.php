<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ContentDescriptor\RelationshipsContentDescriptor;

it('returns null when no relationships are provided', function (): void {
    expect(RelationshipsContentDescriptor::create([]))->toBeNull();
});

it('builds relationships content descriptor with enum constraints', function (): void {
    $relationships = [
        'users' => ['profile', 'posts'],
        'posts' => ['author', 'comments'],
    ];

    $descriptor = RelationshipsContentDescriptor::create($relationships);

    expect($descriptor)
        ->toBeArray()
        ->and($descriptor['name'])->toBe('relationships')
        ->and($descriptor['schema']['type'])->toBe('object')
        ->and($descriptor['schema']['properties']['users']['items']['enum'])
        ->toEqual(['profile', 'posts'])
        ->and($descriptor['schema']['properties']['posts']['items']['enum'])
        ->toEqual(['author', 'comments']);
});
