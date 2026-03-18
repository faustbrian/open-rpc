<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\ContentDescriptorValue;
use Cline\OpenRpc\ValueObject\ErrorValue;
use Cline\OpenRpc\ValueObject\ExamplePairingValue;
use Cline\OpenRpc\ValueObject\ExampleValue;
use Cline\OpenRpc\ValueObject\ExternalDocumentationValue;
use Cline\OpenRpc\ValueObject\LinkValue;
use Cline\OpenRpc\ValueObject\MethodValue;
use Cline\OpenRpc\ValueObject\ServerValue;
use Cline\OpenRpc\ValueObject\TagValue;
use Cline\Struct\Support\DataCollection;

it('creates a content descriptor value', function (): void {
    $schema = [
        'type' => 'object',
        'properties' => [
            'name' => ['type' => 'string'],
        ],
    ];

    $cd = new ContentDescriptorValue(
        name: 'data',
        summary: 'payload',
        description: 'The request payload',
        required: true,
        schema: $schema,
        deprecated: false,
    );

    expect($cd->name)->toBe('data')
        ->and($cd->required)->toBeTrue()
        ->and($cd->schema)->toBe($schema);
});

it('creates a complete method value with collections', function (): void {
    $tags = new DataCollection([
        new TagValue(name: 'users', summary: 'User ops', description: null, externalDocs: null),
    ]);

    $params = new DataCollection([
        new ContentDescriptorValue(
            name: 'data',
            summary: 'payload',
            description: null,
            required: true,
            schema: ['type' => 'object'],
            deprecated: false,
        ),
    ]);

    $result = new ContentDescriptorValue(
        name: 'result',
        summary: 'Response',
        description: null,
        required: true,
        schema: ['type' => 'object'],
        deprecated: false,
    );

    $servers = new DataCollection([
        new ServerValue(name: 'prod', url: 'https://api.example.com', summary: null, description: null, variables: null),
    ]);

    $errors = new DataCollection([
        new ErrorValue(code: 400, message: 'Bad Request', data: ['field' => 'name']),
    ]);

    $links = new DataCollection([
        new LinkValue(name: 'docs', url: 'https://example.com/docs/users.create'),
    ]);

    $examples = new DataCollection([
        new ExamplePairingValue(
            name: 'ok',
            description: null,
            summary: 'OK response',
            params: new DataCollection([new ExampleValue(name: 'payload', summary: null, description: null, value: '{"name":"john"}', externalValue: null)]),
            result: new DataCollection([new ExampleValue(name: 'result', summary: null, description: null, value: '{"ok":true}', externalValue: null)]),
        ),
    ]);

    $method = new MethodValue(
        name: 'users.create',
        tags: $tags,
        summary: 'Create a user',
        description: 'Creates a user with a name',
        externalDocs: new ExternalDocumentationValue(description: 'More info', url: 'https://docs.example.com/users#create'),
        params: $params,
        result: $result,
        deprecated: false,
        servers: $servers,
        errors: $errors,
        links: $links,
        paramStructure: 'by-name',
        examples: $examples,
    );

    expect($method->name)->toBe('users.create')
        ->and($method->summary)->toContain('Create')
        ->and($method->params)->toBeInstanceOf(DataCollection::class)
        ->and($method->result?->name)->toBe('result')
        ->and($method->servers?->all()[0]->url)->toContain('https://api.example.com')
        ->and($method->errors?->all()[0]->code)->toBe(400)
        ->and($method->links?->all()[0]->name)->toBe('docs')
        ->and($method->paramStructure)->toBe('by-name')
        ->and($method->examples?->all()[0]->name)->toBe('ok');
});
