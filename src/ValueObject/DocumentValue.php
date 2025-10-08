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
 * @see https://spec.open-rpc.org/#openrpc-object
 */
final class DocumentValue extends Data
{
    /**
     * Create a new OpenRPC Document Object instance.
     *
     * @param string                                $openrpc      Semantic version number of the OpenRPC specification
     *                                                            that this document conforms to. Indicates which version
     *                                                            of the OpenRPC spec features and validation rules should
     *                                                            be applied, ensuring proper parsing and compatibility.
     * @param InfoValue                             $info         Metadata and information about the API including title,
     *                                                            version, description, contact information, and license
     *                                                            details. Provides essential context for documentation
     *                                                            generation and client library creation.
     * @param null|DataCollection<int, ServerValue> $servers      Collection of Server Objects defining the available
     *                                                            API endpoints and their connection details including
     *                                                            URLs, variables, and descriptions. When not provided,
     *                                                            implementations typically default to localhost.
     * @param DataCollection<int, MethodValue>      $methods      Collection of Method Objects defining all available
     *                                                            RPC methods in the API. Each method specifies its
     *                                                            parameters, return values, error definitions, and
     *                                                            documentation. Core functional specification of the API.
     * @param null|ComponentsValue                  $components   components Object providing reusable elements such as
     *                                                            schemas, examples, and error definitions that can be
     *                                                            referenced throughout the specification using JSON
     *                                                            references to reduce duplication and improve maintainability
     * @param null|ExternalDocumentationValue       $externalDocs external Documentation Object providing links to
     *                                                            additional documentation resources, tutorials, API
     *                                                            guides, or reference materials that complement the
     *                                                            core specification with comprehensive usage information
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
