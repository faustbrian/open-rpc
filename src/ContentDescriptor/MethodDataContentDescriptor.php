<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ContentDescriptor;

/**
 * OpenRPC content descriptor for method data parameters.
 *
 * This class generates the OpenRPC content descriptor definition for method data
 * parameters in RPC method schemas. It creates standardized parameter definitions
 * that describe the structure and validation rules for data passed to RPC methods,
 * enabling automatic validation and documentation generation.
 *
 * The descriptor supports both manual schema definition and automatic schema
 * generation from data classes that implement validation rules, providing
 * flexibility for different method parameter patterns.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @psalm-immutable
 */
final readonly class MethodDataContentDescriptor
{
    /**
     * Create the OpenRPC content descriptor for method data parameters.
     *
     * This method generates a standardized content descriptor that defines the
     * structure and validation rules for data parameters in RPC methods. The
     * descriptor uses a provided schema array to define the parameter structure,
     * constraints, and validation requirements.
     *
     * The resulting descriptor follows OpenRPC specification requirements and
     * includes human-readable descriptions for API documentation generation.
     *
     * @param  array $schema The JSON Schema definition for the data parameter structure
     * @return array The OpenRPC content descriptor array with name, description, and schema
     */
    public static function create(array $schema): array
    {
        return [
            'name' => 'data',
            'description' => 'The data that will be passed to the method.',
            'schema' => $schema,
        ];
    }

    /**
     * Create the OpenRPC content descriptor from a data class.
     *
     * This method generates a content descriptor by automatically extracting
     * validation rules from a data class that implements a getValidationRules
     * method. This provides a convenient way to generate OpenRPC schemas from
     * existing data validation definitions.
     *
     * The data class must have a static getValidationRules method that returns
     * an array of validation rules compatible with JSON Schema generation.
     *
     * @param  string $data The fully qualified class name of the data class
     * @return array  The OpenRPC content descriptor array generated from data class validation rules
     */
    public static function createFromData(string $data): array
    {
        return self::create($data::getValidationRules([]));
    }
}
