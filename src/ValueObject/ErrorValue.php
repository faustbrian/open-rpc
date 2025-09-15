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
 * OpenRPC Error Object value object.
 *
 * Represents an Error Object that defines the structure and details of
 * error responses in OpenRPC methods. Error Objects provide standardized
 * information about what went wrong during method execution, including
 * error codes, human-readable messages, and additional context data.
 *
 * This class follows the JSON-RPC 2.0 error specification and enables
 * consistent error handling across all API methods. Proper error definition
 * is crucial for client applications to handle failure scenarios gracefully
 * and provide meaningful feedback to users.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#error-object
 * @see https://www.jsonrpc.org/specification#error_object
 */
final class ErrorValue extends Data
{
    /**
     * Create a new Error Object instance.
     *
     * @param int    $code    A numeric error code that identifies the type of error
     *                        that occurred. This should follow JSON-RPC 2.0 conventions
     *                        where negative values are reserved for predefined errors
     *                        (-32768 to -32000) and positive values can be used for
     *                        application-specific errors.
     * @param string $message A human-readable string describing the error that
     *                        occurred. This message should be concise but
     *                        informative enough for developers and potentially
     *                        end users to understand what went wrong and how
     *                        to resolve the issue.
     * @param mixed  $data    Additional data about the error that can provide more
     *                        context about the failure. This could include validation
     *                        errors, stack traces, request identifiers, or any other
     *                        structured information that helps with debugging and
     *                        error resolution.
     */
    public function __construct(
        #[Required()]
        public readonly int $code,
        #[Required()]
        public readonly string $message,
        public readonly mixed $data,
    ) {}
}
