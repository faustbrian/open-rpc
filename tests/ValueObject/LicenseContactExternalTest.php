<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\ContactValue;
use Cline\OpenRpc\ValueObject\ExternalDocumentationValue;
use Cline\OpenRpc\ValueObject\LicenseValue;

it('creates license, contact and external docs objects', function (): void {
    $license = new LicenseValue(name: 'Apache-2.0', url: 'https://www.apache.org/licenses/LICENSE-2.0');
    $contact = new ContactValue(name: 'John', url: 'https://example.com/me', email: 'john@example.com');
    $external = new ExternalDocumentationValue(description: 'More docs', url: 'https://docs.example.com');

    expect($license->url)->toContain('apache')
        ->and($contact->name)->toBe('John')
        ->and($external->url)->toBe('https://docs.example.com');
});
