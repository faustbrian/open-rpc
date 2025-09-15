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
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#example-object
 */
final class ExampleValue extends Data
{
    /**
     * Create a new Example Object instance.
     *
     * @param null|string $name          Optional unique identifier for the example within
     *                                   its containing context. The name helps reference
     *                                   the example in documentation and provides semantic
     *                                   meaning about what scenario or use case the
     *                                   example represents.
     * @param null|string $summary       Optional brief summary of what the example
     *                                   demonstrates or represents. This provides a
     *                                   quick overview of the example's purpose and
     *                                   is often used in generated documentation
     *                                   and IDE tooltips.
     * @param null|string $description   Optional detailed description of the example,
     *                                   including context about when to use it, what
     *                                   it demonstrates, and any important notes
     *                                   about the example values. Used for comprehensive
     *                                   API documentation.
     * @param null|string $value         Optional inline example value that demonstrates
     *                                   the expected data format. This should be a valid
     *                                   JSON string representation of the example data
     *                                   that matches the associated schema constraints.
     * @param null|string $externalValue Optional URL or file path reference to
     *                                   an external file containing the example
     *                                   value. This is useful for large examples
     *                                   or when examples are maintained separately
     *                                   from the specification document.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $summary,
        public readonly ?string $description,
        public readonly ?string $value,
        public readonly ?string $externalValue,
    ) {}
}
