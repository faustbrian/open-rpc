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
     * Generates a standardized content descriptor that defines the structure and
     * validation rules for data parameters in RPC methods. The descriptor uses a
     * provided JSON Schema array to define parameter structure, constraints, and
     * validation requirements.
     *
     * ```php
     * $descriptor = MethodDataContentDescriptor::create([
     *     'type' => 'object',
     *     'required' => ['email', 'password'],
     *     'properties' => [
     *         'email' => ['type' => 'string', 'format' => 'email'],
     *         'password' => ['type' => 'string', 'minLength' => 8],
     *     ],
     * ]);
     * ```
     *
     * The resulting descriptor follows OpenRPC specification requirements and
     * includes human-readable descriptions for API documentation generation.
     *
     * @param  array<string, mixed>                                                   $schema JSON Schema definition for the data parameter structure, including type definitions, required fields, properties, and validation constraints
     * @return array{name: string, description: string, schema: array<string, mixed>} OpenRPC content descriptor array with name, description, and embedded JSON Schema
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
     * Create the OpenRPC content descriptor from a data class with validation rules.
     *
     * Generates a content descriptor by automatically extracting validation rules
     * from a data class that implements a static getValidationRules method. This
     * provides a convenient way to generate OpenRPC schemas from existing data
     * validation definitions without manual schema construction.
     *
     * ```php
     * // Data class with validation rules
     * class LoginData {
     *     public static function getValidationRules(array $context): array {
     *         return [
     *             'type' => 'object',
     *             'required' => ['email', 'password'],
     *             'properties' => [...],
     *         ];
     *     }
     * }
     *
     * $descriptor = MethodDataContentDescriptor::createFromData(LoginData::class);
     * ```
     *
     * @param  class-string                                                           $data Fully qualified class name of the data class that implements a static getValidationRules method returning JSON Schema-compatible validation rules
     * @return array{name: string, description: string, schema: array<string, mixed>} OpenRPC content descriptor array generated from data class validation rules
     */
    public static function createFromData(string $data): array
    {
        /** @var array<string, mixed> $validationRules */
        $validationRules = $data::getValidationRules([]);

        return self::create($validationRules);
    }
}
