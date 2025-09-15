<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Spatie\LaravelData\Data;

/**
 * Represents license information for an OpenRPC API.
 *
 * This value object contains licensing details that specify the legal terms
 * and conditions under which the API is made available. The license information
 * helps consumers understand their rights and obligations when using the API,
 * ensuring proper legal compliance and usage guidelines.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#license-object
 */
final class LicenseValue extends Data
{
    /**
     * Create a new license information object.
     *
     * @param null|string $name Optional name of the license used for the API.
     *                          Should be a recognizable license identifier such as
     *                          "MIT", "Apache 2.0", "GPL-3.0", or a custom license name.
     * @param null|string $url  Optional URL pointing to the full license text or
     *                          license documentation. Should be a valid, accessible URL
     *                          that provides the complete licensing terms and conditions.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $url,
    ) {}
}
