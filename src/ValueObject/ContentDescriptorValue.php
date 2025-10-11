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
use Spatie\LaravelData\Optional;

/**
 * OpenRPC Content Descriptor Object value object.
 *
 * Represents a Content Descriptor Object that defines the structure and
 * metadata for parameters, results, and errors in OpenRPC method definitions.
 * Content Descriptors provide essential information about data types, validation
 * rules, and human-readable documentation for API elements.
 *
 * This class serves as the foundation for describing all data structures
 * used in OpenRPC specifications, enabling automatic validation, documentation
 * generation, and client code generation from the API specification. Content
 * Descriptors are used throughout OpenRPC documents to describe method parameters,
 * return values, and error structures.
 *
 * ```php
 * $descriptor = new ContentDescriptorValue(
 *     name: 'userId',
 *     summary: 'User identifier',
 *     description: 'The unique identifier for a user in the system',
 *     required: true,
 *     schema: ['type' => 'integer', 'minimum' => 1],
 *     deprecated: false,
 * );
 * ```
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#content-descriptor-object
 */
final class ContentDescriptorValue extends Data
{
    /**
     * Create a new Content Descriptor Object instance.
     *
     * @param string                    $name        Name of the content descriptor, which serves as a unique identifier within the context where it is used. This name is used for referencing the descriptor in method definitions and documentation generation. Should use camelCase or snake_case conventions.
     * @param null|string               $summary     Brief summary of the content descriptor's purpose and usage. This provides a concise overview that can be used in generated documentation and IDE tooltips to help developers understand the descriptor's role. Should be a single sentence.
     * @param null|string               $description Detailed description of the content descriptor, including its purpose, constraints, expected values, and any important usage notes. This description is used for comprehensive API documentation and should explain business logic, validation rules, and usage examples.
     * @param bool|Optional             $required    Indicates whether this content descriptor represents a required parameter or field. When true, the parameter must be provided in API calls. Uses Optional type to support dynamic requirement determination based on context and conditional validation scenarios.
     * @param null|array<string, mixed> $schema      JSON Schema definition that describes the structure, type, and validation rules for the data described by this content descriptor. Defines data types, constraints, patterns, formats, enums, and other validation criteria following JSON Schema Draft 7 specification.
     * @param bool|Optional             $deprecated  Indicates whether this content descriptor is deprecated and should not be used in new implementations. When true, API documentation will mark this as deprecated and may include migration guidance. Helps maintain backward compatibility while guiding developers to newer alternatives.
     */
    public function __construct(
        #[Required()]
        public readonly string $name,
        public readonly ?string $summary,
        public readonly ?string $description,
        public readonly bool|Optional $required,
        // public readonly ?SchemaValue $schema,
        public readonly ?array $schema,
        public readonly bool|Optional $deprecated,
    ) {}
}
