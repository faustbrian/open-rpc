<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * Represents a server definition within the OpenRPC specification.
 *
 * This value object describes an individual server that can handle OpenRPC
 * requests, including its location, configuration, and variable parameters.
 * Server objects enable the specification of multiple deployment targets,
 * environments, or endpoints that can process API requests with different
 * configurations or capabilities.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#server-object
 */
final class ServerValue extends Data
{
    /**
     * Create a new server definition object.
     *
     * @param string                                        $name        Required identifying name for the server that
     *                                                                   distinguishes it from other server definitions.
     *                                                                   Should be descriptive of the server's purpose
     *                                                                   or environment (e.g., "production", "staging").
     * @param string                                        $url         Required base URL where the server can be reached.
     *                                                                   May contain template variables that are substituted
     *                                                                   with values from the variables collection.
     * @param null|string                                   $summary     Optional brief description of the server's purpose
     *                                                                   or role. Should provide quick identification of
     *                                                                   the server's characteristics or use case.
     * @param null|string                                   $description Optional detailed explanation of the server's
     *                                                                   configuration, capabilities, or intended usage.
     *                                                                   Supports CommonMark syntax for rich formatting.
     * @param null|DataCollection<int, ServerVariableValue> $variables   Optional collection of variable definitions that
     *                                                                   provide templating capabilities for the server URL.
     *                                                                   Variables enable dynamic server configuration.
     */
    public function __construct(
        #[Required()]
        public readonly string $name,
        #[Required()]
        public readonly string $url,
        public readonly ?string $summary,
        public readonly ?string $description,
        #[DataCollectionOf(ServerVariableValue::class)]
        public readonly ?DataCollection $variables,
    ) {}
}
