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
 * @see https://spec.open-rpc.org/#error-object
 * @see https://www.jsonrpc.org/specification#error_object
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ErrorValue extends Data
{
    /**
     * Create a new Error Object instance.
     *
     * @param int    $code    Numeric error code identifying the type of error. Should
     *                        follow JSON-RPC 2.0 conventions where -32768 to -32000
     *                        are reserved for predefined errors and positive values
     *                        can be used for application-specific error categorization.
     * @param string $message Human-readable string describing the error. Should be
     *                        concise yet informative enough for developers and end
     *                        users to understand what went wrong and potential steps
     *                        for resolution or debugging.
     * @param mixed  $data    Additional contextual data about the error including
     *                        validation errors, stack traces, request identifiers,
     *                        or any structured information aiding in debugging and
     *                        error resolution. Type and structure are application-defined.
     */
    public function __construct(
        #[Required()]
        public readonly int $code,
        #[Required()]
        public readonly string $message,
        public readonly mixed $data,
    ) {}
}
