<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\SchemaValue;

it('converts schema value to associative array keyed by name', function (): void {
    $schema = new SchemaValue(
        name: 'User',
        data: [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ],
    );

    expect($schema->toArray())->toEqual([
        'User' => [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
            ],
        ],
    ]);
});
