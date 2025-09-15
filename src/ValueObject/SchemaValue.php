<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Override;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * Represents a JSON Schema definition within the OpenRPC specification.
 *
 * This value object encapsulates JSON Schema definitions that describe the
 * structure, validation rules, and constraints for data types used throughout
 * the API. Schema objects enable strong typing and validation for parameters,
 * return values, and complex data structures, ensuring API contract compliance.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#schema-object
 */
final class SchemaValue extends Data
{
    /**
     * Create a new schema definition object.
     *
     * @param string               $name Required identifier name for the schema definition.
     *                                   This name is used to reference the schema from other
     *                                   parts of the OpenRPC document and should be unique
     *                                   within the schema definitions scope.
     * @param array<string, mixed> $data required schema definition data that contains the
     *                                   JSON Schema properties, validation rules, type
     *                                   definitions, and constraints that define the
     *                                   structure and validation requirements
     */
    public function __construct(
        #[Required()]
        public readonly string $name,
        #[Required()]
        public readonly array $data,
    ) {}

    /**
     * Convert the schema to its array representation for serialization.
     *
     * Transforms the schema object into a key-value array format where the
     * schema name becomes the key and the schema data becomes the value.
     * This format is required for proper OpenRPC document structure.
     *
     * @return array<string, mixed> Array representation with schema name as key
     */
    #[Override()]
    public function toArray(): array
    {
        return [
            $this->name => $this->data,
        ];
    }
}
