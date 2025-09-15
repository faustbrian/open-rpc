<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ContentDescriptor;

use Illuminate\Support\Arr;

/**
 * OpenRPC content descriptor for sorting query parameters.
 *
 * This class generates OpenRPC schema definitions for sorting query parameters
 * used in JSON:API compliant endpoints. It creates schema definitions that describe
 * which fields can be used for sorting each resource type, supporting both ascending
 * and descending sort orders through the standard JSON:API sorting convention.
 *
 * The generated schema automatically includes both positive (ascending) and negative
 * (descending) variants of each sortable field, following the JSON:API specification
 * where prefixing a field name with "-" indicates descending order.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://jsonapi.org/format/#fetching-sorting
 *
 * @psalm-immutable
 */
final readonly class SortsContentDescriptor
{
    /**
     * Create an OpenRPC content descriptor for sorting parameters.
     *
     * Generates a schema definition for sorting query parameters that describes
     * which fields can be used for sorting each resource type. The method automatically
     * creates both ascending and descending variants for each sortable field, allowing
     * clients to specify sort order using standard JSON:API syntax like
     * `?sorts[users]=name,-created_at`.
     *
     * @param  array<string, array<int, string>> $sorts Associative array where keys are
     *                                                  resource names and values are arrays
     *                                                  of sortable field names for that
     *                                                  resource type. The method automatically
     *                                                  generates descending variants by
     *                                                  prefixing field names with "-".
     * @return null|array<string, mixed>         returns null if no sorts are provided,
     *                                           otherwise returns an OpenRPC content descriptor
     *                                           array with name, description, and schema properties
     *                                           defining the sorting parameter structure
     */
    public static function create(array $sorts): ?array
    {
        $properties = [];

        foreach ($sorts as $resource => $resourceSorts) {
            $properties[$resource] = [
                'type' => 'array',
                'items' => [
                    'type' => 'string',
                    'enum' => [
                        ...$resourceSorts,
                        ...Arr::map(array: $resourceSorts, callback: static fn ($sort): string => '-'.$sort),
                    ],
                ],
            ];
        }

        if ($properties === []) {
            return null;
        }

        return [
            'name' => 'sorts',
            'description' => 'The sort order of the resources. The order of the fields matter, the first fields have the highest priority. Prefix with "-" to sort in descending order. If not specified, the default sort order is used.',
            'schema' => [
                'type' => 'object',
                'properties' => $properties,
            ],
        ];
    }
}
