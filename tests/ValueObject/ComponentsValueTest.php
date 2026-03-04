<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\ComponentsValue;
use Cline\OpenRpc\ValueObject\ContentDescriptorValue;
use Cline\OpenRpc\ValueObject\ErrorValue;
use Cline\OpenRpc\ValueObject\ExamplePairingValue;
use Cline\OpenRpc\ValueObject\ExampleValue;
use Cline\OpenRpc\ValueObject\LinkValue;
use Cline\OpenRpc\ValueObject\SchemaValue;
use Cline\OpenRpc\ValueObject\TagValue;
use Spatie\LaravelData\DataCollection;

it('creates a components value with reusable elements', function (): void {
    $components = new ComponentsValue(
        contentDescriptors: [
            'data' => new ContentDescriptorValue(
                name: 'data',
                summary: null,
                description: null,
                required: true,
                schema: ['type' => 'object'],
                deprecated: false,
            ),
        ],
        schemas: [
            'User' => new SchemaValue('User', ['type' => 'object']),
        ],
        examples: [
            'payload' => new ExampleValue(name: 'payload', summary: null, description: null, value: '{"id":1}', externalValue: null),
        ],
        links: [
            'self' => new LinkValue(name: 'self', url: 'https://example.com'),
        ],
        errors: [
            'BadRequest' => new ErrorValue(code: 400, message: 'Bad Request', data: null),
        ],
        examplePairingObjects: [
            'pair' => new ExamplePairingValue(
                name: 'pair',
                description: null,
                summary: null,
                params: new DataCollection(ExampleValue::class, [new ExampleValue(name: null, summary: null, description: null, value: '{}', externalValue: null)]),
                result: null,
            ),
        ],
        tags: [
            'users' => new TagValue(name: 'users', summary: null, description: null, externalDocs: null),
        ],
    );

    expect($components->schemas['User'])->toBeInstanceOf(SchemaValue::class)
        ->and($components->errors['BadRequest']->code)->toBe(400)
        ->and($components->links['self']->name)->toBe('self')
        ->and($components->contentDescriptors['data']->name)->toBe('data')
        ->and($components->tags['users']->name)->toBe('users');
});
