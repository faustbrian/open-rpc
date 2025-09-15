<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\ServerValue;
use Cline\OpenRpc\ValueObject\ServerVariableValue;
use Spatie\LaravelData\DataCollection;

it('creates a server value with variables', function (): void {
    $variables = new DataCollection(ServerVariableValue::class, [
        new ServerVariableValue(enum: ['v1', 'v2'], default: 'v1', description: 'API version'),
    ]);

    $server = new ServerValue(
        name: 'production',
        url: 'https://api.example.com/{version}',
        summary: 'Prod server',
        description: 'Primary production API',
        variables: $variables,
    );

    expect($server->name)->toBe('production')
        ->and($server->url)->toContain('{version}')
        ->and($server->variables)->toBeInstanceOf(DataCollection::class)
        ->and($server->variables->items()[0])->toBeInstanceOf(ServerVariableValue::class)
        ->and($server->variables->items()[0]->default)->toBe('v1');
});
