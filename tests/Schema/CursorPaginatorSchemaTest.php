<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\Schema\CursorPaginatorSchema;

it('builds cursor paginator schema structure', function (): void {
    $schema = CursorPaginatorSchema::create();

    expect($schema)
        ->toBeArray()
        ->and($schema['name'])->toBe('CursorPaginator')
        ->and($schema['data']['type'])->toBe('object')
        ->and($schema['data']['required'])->toContain('cursor')
        ->and($schema['data']['properties'])
        ->toHaveKeys(['cursor', 'size'])
        ->and($schema['data']['properties']['cursor']['type'])->toBe('string')
        ->and($schema['data']['properties']['size']['type'])->toBe('integer');
});
