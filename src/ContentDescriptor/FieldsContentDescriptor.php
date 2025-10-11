<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ContentDescriptor;

/**
 * OpenRPC content descriptor for field selection parameters.
 *
 * This class generates the OpenRPC content descriptor definition for field selection
 * parameters in RPC method schemas. Field selection allows clients to specify exactly
 * which fields they want to receive in the response, reducing payload size and improving
 * performance by avoiding the transmission of unwanted data.
 *
 * The descriptor generates a dynamic schema based on available resource fields,
 * creating an object where each resource type has an array of selectable field names.
 * This follows JSON:API sparse fieldsets patterns adapted for JSON-RPC.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @psalm-immutable
 */
final readonly class FieldsContentDescriptor
{
    /**
     * Create the OpenRPC content descriptor for field selection parameters.
     *
     * Generates a dynamic content descriptor based on the available fields for each
     * resource type. The resulting schema allows clients to specify which fields they
     * want to receive for each resource type in the response, following JSON:API
     * sparse fieldsets patterns.
     *
     * ```php
     * $descriptor = FieldsContentDescriptor::create([
     *     'users' => ['id', 'name', 'email'],
     *     'posts' => ['id', 'title', 'content'],
     * ]);
     * // Client can request: ?fields[users]=id,name&fields[posts]=title
     * ```
     *
     * Each resource type becomes a property in the schema, with an array of valid
     * field names as enum values for validation, ensuring clients can only request
     * explicitly defined fields.
     *
     * @param  array<string, array<int, string>>                                                                                                                                                              $fields Associative array where keys are resource type names and values are arrays of selectable field names for that resource. Used to generate enum constraints for field validation.
     * @return null|array{name: string, description: string, schema: array{type: string, properties: array<string, array{name: string, type: string, items: array{type: string, enum: array<int, string>}}>}} OpenRPC content descriptor array with dynamic properties based on resource fields, or null if no fields are provided
     */
    public static function create(array $fields): ?array
    {
        $properties = [];

        foreach ($fields as $resource => $resourceFields) {
            $properties[$resource] = [
                'name' => $resource,
                'type' => 'array',
                'items' => [
                    'type' => 'string',
                    'enum' => $resourceFields,
                ],
            ];
        }

        if ($properties === []) {
            return null;
        }

        return [
            'name' => 'fields',
            'description' => 'The fields to return for each resource. If not specified, all fields are returned.',
            'schema' => [
                'type' => 'object',
                'properties' => $properties,
            ],
        ];
    }
}
