<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * Represents a server variable definition within the OpenRPC specification.
 *
 * This value object defines template variables that can be used within server
 * URL templates to provide dynamic server configuration. Server variables enable
 * flexible server addressing by allowing URL components to be substituted with
 * runtime values, supporting multiple deployment environments and configurations.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#server-variable-object
 */
final class ServerVariableValue extends Data
{
    /**
     * Create a new server variable definition object.
     *
     * @param array<string> $enum        Array of enumerated values that restrict the allowed
     *                                   values for this server variable. When specified, the
     *                                   variable value must be one of the provided options,
     *                                   enabling controlled server configuration choices.
     * @param string        $default     Required default value for the server variable that
     *                                   will be used when no specific value is provided.
     *                                   Must be a valid option from the enum array if enum
     *                                   values are specified for constraint validation.
     * @param string        $description Required human-readable description explaining the
     *                                   purpose and usage of this server variable. Should
     *                                   provide clear guidance on what the variable controls
     *                                   and how different values affect server behavior.
     */
    public function __construct(
        public readonly array $enum,
        #[Required()]
        public readonly string $default,
        public readonly string $description,
    ) {}
}
