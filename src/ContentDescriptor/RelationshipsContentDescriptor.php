<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ContentDescriptor;

/**
 * OpenRPC content descriptor for relationship query parameters.
 *
 * This class generates OpenRPC schema definitions for relationship query parameters
 * used in JSON:API compliant endpoints. It creates schema definitions that describe
 * which relationships can be included with each resource type in API responses.
 *
 * The generated schema follows the JSON:API specification for sparse fieldsets
 * and relationship inclusion patterns, allowing clients to specify exactly which
 * relationships should be loaded and returned with each resource.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://jsonapi.org/format/#fetching-includes
 *
 * @psalm-immutable
 */
final readonly class RelationshipsContentDescriptor
{
    /**
     * Create an OpenRPC content descriptor for relationship parameters.
     *
     * Generates a schema definition for relationship query parameters that describes
     * which relationships can be included with each resource type. The resulting
     * schema allows API clients to specify relationships to include in responses
     * using query parameters like `?relationships[users]=profile,posts`.
     *
     * @param  array<string, array<int, string>> $relationships Associative array where keys are
     *                                                          resource names and values are arrays
     *                                                          of available relationship names for
     *                                                          that resource type. Used to generate
     *                                                          enum constraints for validation.
     * @return null|array<string, mixed>         returns null if no relationships are provided,
     *                                           otherwise returns an OpenRPC content descriptor
     *                                           array with name, description, and schema properties
     *                                           defining the relationship parameter structure
     */
    public static function create(array $relationships): ?array
    {
        $properties = [];

        foreach ($relationships as $resource => $resourceRelationships) {
            $properties[$resource] = [
                'type' => 'array',
                'items' => [
                    'type' => 'string',
                    'enum' => $resourceRelationships,
                ],
            ];
        }

        if ($properties === []) {
            return null;
        }

        return [
            'name' => 'relationships',
            'description' => 'The relationships to return for each resource. If not specified, no relationships will be returned.',
            'schema' => [
                'type' => 'object',
                'properties' => $properties,
            ],
        ];
    }
}
