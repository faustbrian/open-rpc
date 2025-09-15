<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ContentDescriptor;

/**
 * OpenRPC content descriptor for filtering parameters.
 *
 * This class generates the OpenRPC content descriptor definition for filtering
 * parameters in RPC method schemas. Filters allow clients to specify conditions
 * that limit the returned results based on field values, relationships, or other
 * criteria, enabling efficient data retrieval with server-side filtering.
 *
 * The descriptor generates a dynamic schema based on available filterable fields
 * for each resource type, creating an object where each resource type has an array
 * of filterable field names. This supports complex filtering scenarios while
 * maintaining type safety and validation.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @psalm-immutable
 */
final readonly class FiltersContentDescriptor
{
    /**
     * Create the OpenRPC content descriptor for filtering parameters.
     *
     * This method generates a dynamic content descriptor based on the available
     * filterable fields for each resource type. The resulting schema allows clients
     * to specify which fields they want to filter on for each resource type in the query.
     *
     * The structure follows the pattern:
     * {
     *   "users": ["name", "email", "active"],
     *   "posts": ["title", "published", "author_id"]
     * }
     *
     * Each resource type becomes a property in the schema, with an array of valid
     * filterable field names as enum values for validation. This ensures clients
     * can only filter on explicitly allowed fields.
     *
     * @param  array      $filters Associative array where keys are resource names and values are arrays of filterable field names
     * @return null|array The OpenRPC content descriptor array or null if no filters are provided
     */
    public static function create(array $filters): ?array
    {
        $properties = [];

        foreach ($filters as $resource => $resourceFilters) {
            $properties[$resource] = [
                'name' => $resource,
                'type' => 'array',
                'items' => [
                    'type' => 'string',
                    'enum' => $resourceFilters,
                ],
            ];
        }

        if ($properties === []) {
            return null;
        }

        return [
            'name' => 'filters',
            'description' => 'The filters to apply to the resources. If not specified, no filters are applied.',
            'schema' => [
                'type' => 'object',
                'properties' => $properties,
            ],
        ];
    }
}
