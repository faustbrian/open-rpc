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
 * OpenRPC Document Object value object.
 *
 * Represents the root-level OpenRPC Document Object that defines a complete
 * OpenRPC specification. This object serves as the top-level container for
 * all API specification information including metadata, server configurations,
 * method definitions, reusable components, and external documentation links.
 *
 * The Document Object is the entry point for OpenRPC specifications and contains
 * all the necessary information to generate client libraries, server stubs,
 * and comprehensive API documentation. It follows the OpenRPC specification
 * structure and validation requirements.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#openrpc-object
 */
final class DocumentValue extends Data
{
    /**
     * Create a new OpenRPC Document Object instance.
     *
     * @param string                                $openrpc      The semantic version number of the OpenRPC specification
     *                                                            that this document conforms to. This field is required
     *                                                            and indicates which version of the OpenRPC spec features
     *                                                            and validation rules should be applied to this document.
     * @param InfoValue                             $info         The metadata and information about the API, including
     *                                                            title, version, description, contact information, and
     *                                                            license details. This object provides essential
     *                                                            information about the API for documentation and
     *                                                            client generation.
     * @param null|DataCollection<int, ServerValue> $servers      Optional collection of
     *                                                            Server Objects that define
     *                                                            the available API endpoints
     *                                                            and their connection details.
     *                                                            When not provided, defaults
     *                                                            to localhost configuration.
     * @param DataCollection<int, MethodValue>      $methods      Required collection of Method Objects
     *                                                            that define all available RPC methods
     *                                                            in the API, including their parameters,
     *                                                            return values, error definitions,
     *                                                            and documentation. This is the core
     *                                                            functional specification of the API.
     * @param null|ComponentsValue                  $components   optional Components Object that provides
     *                                                            reusable elements like schemas, examples,
     *                                                            and error definitions that can be referenced
     *                                                            throughout the specification to reduce
     *                                                            duplication and improve maintainability
     * @param null|ExternalDocumentationValue       $externalDocs optional External Documentation
     *                                                            Object that provides links to
     *                                                            additional documentation
     *                                                            resources, tutorials, or
     *                                                            reference materials for
     *                                                            the API
     */
    public function __construct(
        #[Required()]
        public readonly string $openrpc,
        #[Required()]
        public readonly InfoValue $info,
        #[DataCollectionOf(ServerValue::class)]
        public readonly ?DataCollection $servers,
        #[Required()]
        #[DataCollectionOf(MethodValue::class)]
        public readonly DataCollection $methods,
        public readonly ?ComponentsValue $components,
        public readonly ?ExternalDocumentationValue $externalDocs,
    ) {}
}
