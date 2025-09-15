<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Cline\OpenRpc\ValueObject\ContactValue;
use Cline\OpenRpc\ValueObject\InfoValue;
use Cline\OpenRpc\ValueObject\LicenseValue;

it('creates an info value with metadata', function (): void {
    $contact = new ContactValue(name: 'API Team', url: 'https://example.com/support', email: 'support@example.com');
    $license = new LicenseValue(name: 'MIT', url: 'https://opensource.org/licenses/MIT');

    $info = new InfoValue(
        title: 'Demo API',
        description: 'A demo API',
        termsOfService: 'https://example.com/tos',
        contact: $contact,
        license: $license,
        version: '1.2.3',
    );

    expect($info->title)->toBe('Demo API')
        ->and($info->version)->toBe('1.2.3')
        ->and($info->contact?->email)->toBe('support@example.com')
        ->and($info->license?->name)->toBe('MIT');
});
