<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ContentDescriptor\FieldsContentDescriptor;

it('returns null when no fields are provided', function (): void {
    expect(FieldsContentDescriptor::create([]))->toBeNull();
});

it('builds fields content descriptor with properties', function (): void {
    $fields = [
        'users' => ['id', 'name', 'email'],
        'posts' => ['id', 'title'],
    ];

    $descriptor = FieldsContentDescriptor::create($fields);

    expect($descriptor)
        ->toBeArray()
        ->and($descriptor['name'])->toBe('fields')
        ->and($descriptor['schema']['type'])->toBe('object')
        ->and($descriptor['schema']['properties']['users']['items']['enum'])
        ->toEqual(['id', 'name', 'email'])
        ->and($descriptor['schema']['properties']['posts']['items']['enum'])
        ->toEqual(['id', 'title']);
});
