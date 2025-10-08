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
 * OpenRPC Example Object value object.
 *
 * Represents an Example Object that provides sample values and documentation
 * for parameters, results, and errors in OpenRPC specifications. Examples
 * are crucial for API documentation, testing, client code generation, and
 * helping developers understand expected data formats and usage patterns.
 *
 * Example Objects can contain either inline values or references to external
 * example files, providing flexibility in how examples are structured and
 * maintained within the API specification.
 *
 * @see https://spec.open-rpc.org/#example-object
 */
final class ExampleValue extends Data
{
    /**
     * Create a new Example Object instance.
     *
     * @param null|string $name          Unique identifier for the example within its containing
     *                                   context. Helps reference the example in documentation and
     *                                   provides semantic meaning about the scenario or use case
     *                                   being demonstrated for clarity and organization.
     * @param null|string $summary       Brief summary of what the example demonstrates. Provides
     *                                   quick overview of the example's purpose, commonly used in
     *                                   generated documentation, IDE tooltips, and API reference
     *                                   materials for rapid developer comprehension.
     * @param null|string $description   Detailed description of the example including context about
     *                                   when to use it, what it demonstrates, and important notes
     *                                   about the example values. Used for comprehensive API
     *                                   documentation and developer guidance.
     * @param null|string $value         Inline example value demonstrating the expected data format.
     *                                   Should be a valid JSON string representation of the example
     *                                   data matching the associated schema constraints and type
     *                                   definitions for accurate documentation and validation.
     * @param null|string $externalValue URL or file path reference to an external file containing
     *                                   the example value. Useful for large examples or when examples
     *                                   are maintained separately from the specification document to
     *                                   improve maintainability and reduce document size.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $summary,
        public readonly ?string $description,
        public readonly ?string $value,
        public readonly ?string $externalValue,
    ) {}
}
