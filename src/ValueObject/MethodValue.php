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
use Spatie\LaravelData\Optional;

/**
 * OpenRPC Method Object value object.
 *
 * Represents a complete Method Object definition within the OpenRPC specification.
 * This encapsulates all aspects of an RPC method including identification, parameters,
 * return values, error conditions, examples, and associated metadata.
 *
 * The Method Object serves as the core building block of the OpenRPC specification,
 * defining the contract between clients and servers for individual API operations.
 * Each method represents a callable function with well-defined inputs, outputs, and
 * error scenarios.
 *
 * @author Brian Faust <brian@cline.sh>
 * @see https://spec.open-rpc.org/#method-object
 */
final class MethodValue extends Data
{
    /**
     * Create a new Method Object instance.
     *
     * @param string                                           $name           Unique identifier for the method within the API. Should
     *                                                                         follow naming conventions (e.g., "user.getProfile") and
     *                                                                         be descriptive of the method's primary function to ensure
     *                                                                         clear identification and prevent naming conflicts.
     * @param null|DataCollection<int, TagValue>               $tags           Collection of tags for categorizing and organizing methods.
     *                                                                         Tags help group related methods (e.g., "user", "admin")
     *                                                                         and facilitate documentation organization, navigation,
     *                                                                         and discoverability in generated API documentation.
     * @param null|string                                      $summary        Brief summary describing the method's primary purpose.
     *                                                                         Should be concise (one sentence) and provide immediate
     *                                                                         understanding of what the method does. Used in quick
     *                                                                         reference documentation and IDE tooltips.
     * @param null|string                                      $description    Detailed explanation of the method's functionality,
     *                                                                         behavior, usage patterns, and important notes. Supports
     *                                                                         CommonMark syntax for rich formatting including code
     *                                                                         blocks, lists, and emphasis in documentation.
     * @param null|ExternalDocumentationValue                  $externalDocs   reference to additional external documentation providing
     *                                                                         comprehensive details about the method's implementation,
     *                                                                         usage examples, best practices, or related concepts that
     *                                                                         supplement the core specification
     * @param null|DataCollection<int, ContentDescriptorValue> $params         Collection of parameter definitions specifying the input
     *                                                                         requirements for the method. Each parameter defines its
     *                                                                         type, validation rules, description, and whether it's
     *                                                                         required for successful method invocation.
     * @param null|ContentDescriptorValue                      $result         Definition of the method's return value structure including
     *                                                                         type information, schema, and description of what the method
     *                                                                         returns upon successful execution. Null for methods with
     *                                                                         no return value or void methods.
     * @param bool|Optional                                    $deprecated     Flag indicating whether the method is deprecated and should
     *                                                                         be avoided in new implementations. When true, clients should
     *                                                                         plan migration strategies and use alternative methods where
     *                                                                         available to ensure forward compatibility.
     * @param null|DataCollection<int, ServerValue>            $servers        Collection of server definitions specifying which servers
     *                                                                         can handle this particular method. Allows method-specific
     *                                                                         server routing, load balancing configuration, and endpoint
     *                                                                         customization beyond global server settings.
     * @param null|DataCollection<int, ErrorValue>             $errors         Collection of error definitions describing possible error
     *                                                                         conditions and responses that may occur during method
     *                                                                         execution. Helps developers implement proper error handling
     *                                                                         and understand failure scenarios.
     * @param null|DataCollection<int, LinkValue>              $links          Collection of links to related resources, documentation,
     *                                                                         or examples providing additional context and information
     *                                                                         about the method. Enhances discoverability and helps
     *                                                                         developers find related functionality.
     * @param null|string                                      $paramStructure Specification of how parameters should be structured in
     *                                                                         the request. Typically "by-position" for positional arrays
     *                                                                         or "by-name" for named objects, defining parameter passing
     *                                                                         conventions per JSON-RPC specification.
     * @param null|DataCollection<int, ExamplePairingValue>    $examples       Collection of example request/response pairs demonstrating
     *                                                                         proper method usage and expected behavior in various scenarios.
     *                                                                         Essential for documentation, testing, and helping developers
     *                                                                         understand the method's practical application.
     */
    public function __construct(
        #[Required()]
        public readonly string $name,
        #[DataCollectionOf(TagValue::class)]
        public readonly ?DataCollection $tags,
        public readonly ?string $summary,
        public readonly ?string $description,
        public readonly ?ExternalDocumentationValue $externalDocs,
        #[Required()]
        #[DataCollectionOf(ContentDescriptorValue::class)]
        public readonly ?DataCollection $params,
        public readonly ?ContentDescriptorValue $result,
        public readonly bool|Optional $deprecated,
        #[DataCollectionOf(ServerValue::class)]
        public readonly ?DataCollection $servers,
        #[DataCollectionOf(ErrorValue::class)]
        public readonly ?DataCollection $errors,
        #[DataCollectionOf(LinkValue::class)]
        public readonly ?DataCollection $links,
        public readonly ?string $paramStructure,
        #[DataCollectionOf(ExamplePairingValue::class)]
        public readonly ?DataCollection $examples,
    ) {}
}
