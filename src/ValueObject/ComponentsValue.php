<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Spatie\LaravelData\Data;

/**
 * OpenRPC Components Object value object.
 *
 * Represents the Components Object in an OpenRPC document, which provides
 * a centralized location for reusable components that can be referenced
 * throughout the API specification. This object holds various types of
 * reusable elements including content descriptors, schemas, examples,
 * links, errors, example pairings, and tags.
 *
 * The Components Object enables better organization and maintainability
 * of OpenRPC specifications by allowing common elements to be defined
 * once and referenced multiple times throughout the document using $ref
 * pointers, following the JSON Schema reference conventions.
 *
 * ```php
 * $components = new ComponentsValue(
 *     contentDescriptors: [
 *         'UserId' => new ContentDescriptorValue(...),
 *         'UserData' => new ContentDescriptorValue(...),
 *     ],
 *     schemas: [
 *         'User' => new SchemaValue(...),
 *         'Error' => new SchemaValue(...),
 *     ],
 *     examples: null,
 *     links: null,
 *     errors: ['NotFound' => new ErrorValue(...)],
 *     examplePairingObjects: null,
 *     tags: ['user' => new TagValue(...)],
 * );
 * ```
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#components-object
 */
final class ComponentsValue extends Data
{
    /**
     * Create a new Components Object instance.
     *
     * @param null|array<string, ContentDescriptorValue> $contentDescriptors    Collection of reusable Content Descriptor Objects that define the structure and validation rules for method parameters and return values, indexed by unique identifiers. These can be referenced throughout the specification using $ref pointers like "#/components/contentDescriptors/UserId".
     * @param null|array<string, SchemaValue>            $schemas               Collection of reusable JSON Schema Objects that define data structures and validation constraints for API data types, indexed by unique identifiers for reference throughout the specification. Common schemas include entity models, error formats, and complex data structures.
     * @param null|array<string, ExampleValue>           $examples              Collection of reusable Example Objects that provide sample values for parameters, return values, and error responses, indexed by unique identifiers to support documentation and testing scenarios. Examples help developers understand expected data formats.
     * @param null|array<string, LinkValue>              $links                 Collection of reusable Link Objects that describe relationships between API operations and how data flows between different endpoints, indexed by unique identifiers for cross-referencing in method definitions. Links enable automatic discovery of related operations.
     * @param null|array<string, ErrorValue>             $errors                Collection of reusable Error Objects that define standardized error responses with error codes, messages, and data structures, indexed by unique identifiers for consistent error handling across methods. Promotes uniform error reporting patterns.
     * @param null|array<string, ExamplePairingValue>    $examplePairingObjects Collection of reusable Example Pairing Objects that group related examples for parameters and their corresponding results, indexed by unique identifiers. Example pairings demonstrate complete request-response cycles for better API comprehension.
     * @param null|array<string, TagValue>               $tags                  Collection of reusable Tag Objects that provide metadata for organizing and categorizing API methods, indexed by unique identifiers for consistent grouping and documentation structure. Tags enable logical grouping of related endpoints in generated documentation.
     */
    public function __construct(
        public readonly ?array $contentDescriptors,
        public readonly ?array $schemas,
        public readonly ?array $examples,
        public readonly ?array $links,
        public readonly ?array $errors,
        public readonly ?array $examplePairingObjects,
        public readonly ?array $tags,
    ) {}
}
