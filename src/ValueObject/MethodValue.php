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
 * Represents a complete method definition within the OpenRPC specification.
 *
 * This value object encapsulates all aspects of an RPC method including its
 * identification, parameters, return values, error conditions, and associated
 * metadata. The Method object serves as the core building block of the OpenRPC
 * specification, defining the contract between clients and servers for individual
 * API operations.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#method-object
 */
final class MethodValue extends Data
{
    /**
     * Create a new method definition object.
     *
     * @param string                                           $name           Required unique identifier for the method within
     *                                                                         the API. Should follow naming conventions and be
     *                                                                         descriptive of the method's primary function.
     * @param null|DataCollection<int, TagValue>               $tags           Optional collection of tags for categorizing and
     *                                                                         organizing methods. Tags help group related methods
     *                                                                         and facilitate documentation organization.
     * @param null|string                                      $summary        Optional brief summary describing the method's
     *                                                                         primary purpose. Should be concise and provide
     *                                                                         immediate understanding of the method's function.
     * @param null|string                                      $description    Optional detailed explanation of the method's
     *                                                                         functionality, behavior, and usage patterns.
     *                                                                         Supports CommonMark syntax for rich formatting.
     * @param null|ExternalDocumentationValue                  $externalDocs   optional reference to additional external documentation
     *                                                                         that provides comprehensive details about the method's
     *                                                                         implementation, usage examples, or related concepts
     * @param null|DataCollection<int, ContentDescriptorValue> $params         Required collection of parameter definitions that
     *                                                                         specify the input requirements for the method.
     *                                                                         Each parameter defines type, validation, and usage.
     * @param null|ContentDescriptorValue                      $result         optional definition of the method's return value
     *                                                                         structure, including type information and description
     *                                                                         of what the method returns upon successful execution
     * @param bool|Optional                                    $deprecated     Optional flag indicating whether the method is
     *                                                                         deprecated and should be avoided in new implementations.
     *                                                                         When true, clients should plan migration strategies.
     * @param null|DataCollection<int, ServerValue>            $servers        Optional collection of server definitions that specify
     *                                                                         which servers can handle this particular method.
     *                                                                         Allows method-specific server routing and configuration.
     * @param null|DataCollection<int, ErrorValue>             $errors         optional collection of error definitions that describe
     *                                                                         possible error conditions and responses that may occur
     *                                                                         during method execution, aiding in error handling
     * @param null|DataCollection<int, LinkValue>              $links          optional collection of links to related resources,
     *                                                                         documentation, or examples that provide additional
     *                                                                         context and information about the method usage
     * @param null|string                                      $paramStructure Optional specification of how parameters should be
     *                                                                         structured in the request. Typically "by-position"
     *                                                                         or "by-name" to define parameter passing conventions.
     * @param null|DataCollection<int, ExamplePairingValue>    $examples       optional collection of example request/response
     *                                                                         pairs that demonstrate proper method usage and
     *                                                                         expected behavior in various scenarios
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
