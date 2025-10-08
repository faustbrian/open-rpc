<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ContentDescriptor\CursorPaginatorContentDescriptor;

it('builds cursor paginator content descriptor with schema ref', function (): void {
    $descriptor = CursorPaginatorContentDescriptor::create();

    expect($descriptor)
        ->toBeArray()
        ->and($descriptor['name'])->toBe('page')
        ->and($descriptor['schema'])
        ->toEqual(['$ref' => '#/components/schemas/CursorPaginator']);
});
