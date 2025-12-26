<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\DocumentValue;
use Cline\OpenRpc\ValueObject\InfoValue;
use Cline\OpenRpc\ValueObject\MethodValue;
use Spatie\LaravelData\DataCollection;

it('instantiates a minimal document value object', function (): void {
    $info = new InfoValue(
        title: 'Sample API',
        description: null,
        termsOfService: null,
        contact: null,
        license: null,
        version: '1.0.0',
    );

    $methods = new DataCollection(MethodValue::class, []);

    $document = new DocumentValue(
        openrpc: '1.2.6',
        info: $info,
        servers: null,
        methods: $methods,
        components: null,
        externalDocs: null,
    );

    expect($document)
        ->toBeInstanceOf(DocumentValue::class)
        ->and($document->openrpc)->toBe('1.2.6')
        ->and($document->info->title)->toBe('Sample API');
});
