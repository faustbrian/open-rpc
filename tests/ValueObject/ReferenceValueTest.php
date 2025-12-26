<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\ReferenceValue;

it('stores the ref string', function (): void {
    $ref = new ReferenceValue(ref: '#/components/schemas/User');

    expect($ref->ref)->toBe('#/components/schemas/User');
});
