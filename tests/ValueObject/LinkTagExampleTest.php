<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\ExamplePairingValue;
use Cline\OpenRpc\ValueObject\ExampleValue;
use Cline\OpenRpc\ValueObject\LinkValue;
use Cline\OpenRpc\ValueObject\TagValue;
use Spatie\LaravelData\DataCollection;

it('creates link and tag values', function (): void {
    $link = new LinkValue(name: 'docs', url: 'https://example.com/docs');
    $tag = new TagValue(name: 'users', summary: 'User operations', description: null, externalDocs: null);

    expect($link->url)->toContain('example.com')
        ->and($tag->name)->toBe('users');
});

it('creates example values and pairings', function (): void {
    $paramExample = new ExampleValue(name: 'payload', summary: 'Basic payload', description: null, value: '{"name":"john"}', externalValue: null);
    $resultExample = new ExampleValue(name: 'result', summary: 'Success', description: null, value: '{"ok":true}', externalValue: null);

    $params = new DataCollection(ExampleValue::class, [$paramExample]);
    $results = new DataCollection(ExampleValue::class, [$resultExample]);

    $pair = new ExamplePairingValue(
        name: 'createUser',
        description: 'Create user example',
        summary: 'Happy path',
        params: $params,
        result: $results,
    );

    expect($pair->name)->toBe('createUser')
        ->and($pair->params->items()[0]->name)->toBe('payload')
        ->and($pair->result?->items()[0]->name)->toBe('result');
});
