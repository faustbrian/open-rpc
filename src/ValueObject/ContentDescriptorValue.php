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
 * generation, and client code generation from the API specification.
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
     * @param string                    $name        The name of the content descriptor, which serves as a unique
     *                                               identifier within the context where it is used. This name
     *                                               is used for referencing the descriptor in method definitions
     *                                               and documentation generation.
     * @param null|string               $summary     A brief summary of the content descriptor's purpose
     *                                               and usage. This provides a concise overview that can
     *                                               be used in generated documentation and IDE tooltips
     *                                               to help developers understand the descriptor's role.
     * @param null|string               $description A detailed description of the content descriptor,
     *                                               including its purpose, constraints, expected values,
     *                                               and any important usage notes. This description
     *                                               is used for comprehensive API documentation.
     * @param bool|Optional             $required    Indicates whether this content descriptor represents
     *                                               a required parameter or field. When true, the
     *                                               parameter must be provided in API calls. Uses
     *                                               Optional type to support dynamic requirement
     *                                               determination based on context.
     * @param null|array<string, mixed> $schema      The JSON Schema definition that describes
     *                                               the structure, type, and validation rules
     *                                               for the data described by this content
     *                                               descriptor. Defines data types, constraints,
     *                                               patterns, and other validation criteria.
     * @param bool|Optional             $deprecated  Indicates whether this content descriptor is
     *                                               deprecated and should not be used in new
     *                                               implementations. When true, API documentation
     *                                               will mark this as deprecated and may include
     *                                               migration guidance.
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
