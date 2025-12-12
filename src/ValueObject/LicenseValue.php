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
 * OpenRPC License Object value object.
 *
 * Represents the License Object containing licensing details that specify the
 * legal terms and conditions under which an OpenRPC API is made available.
 * License information helps API consumers understand their rights, obligations,
 * and restrictions when using the API.
 *
 * This object is crucial for ensuring proper legal compliance, usage guidelines,
 * and intellectual property protection for both API providers and consumers.
 *
 * @author Brian Faust <brian@cline.sh>
 * @see https://spec.open-rpc.org/#license-object
 */
final class LicenseValue extends Data
{
    /**
     * Create a new License Object instance.
     *
     * @param null|string $name Name of the license used for the API. Should be a
     *                          recognizable license identifier such as "MIT", "Apache 2.0",
     *                          "GPL-3.0", or SPDX license identifier for standard licenses,
     *                          or a custom descriptive name for proprietary licenses.
     * @param null|string $url  URL pointing to the full license text or license documentation.
     *                          Should be a valid, accessible URL providing the complete
     *                          licensing terms, conditions, permissions, and restrictions
     *                          governing the use of the API and its documentation.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $url,
    ) {}
}
