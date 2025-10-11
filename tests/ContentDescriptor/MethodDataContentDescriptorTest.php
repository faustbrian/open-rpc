<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ContentDescriptor\MethodDataContentDescriptor;
use Tests\Fixtures\DummyValidationData;

it('builds data content descriptor from schema', function (): void {
    $schema = [
        'type' => 'object',
        'properties' => [
            'id' => ['type' => 'integer'],
            'name' => ['type' => 'string'],
        ],
    ];

    $descriptor = MethodDataContentDescriptor::create($schema);

    expect($descriptor)
        ->toBeArray()
        ->and($descriptor['name'])->toBe('data')
        ->and($descriptor['schema'])->toEqual($schema);
});

it('creates descriptor from data class via getValidationRules', function (): void {
    $descriptor = MethodDataContentDescriptor::createFromData(DummyValidationData::class);

    expect($descriptor['name'])->toBe('data')
        ->and($descriptor['schema']['properties'])
        ->toHaveKey('email');
});
