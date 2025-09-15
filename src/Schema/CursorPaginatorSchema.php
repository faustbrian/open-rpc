<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\Schema;

/**
 * OpenRPC schema definition for cursor-based pagination parameters.
 *
 * This class generates a standardized OpenRPC schema for cursor-based pagination
 * that can be used across API endpoints. Cursor-based pagination is ideal for
 * real-time data where new items are frequently added, as it provides consistent
 * results even when the underlying dataset changes during pagination.
 *
 * The schema defines the structure for pagination parameters including the cursor
 * position and page size, ensuring consistent pagination behavior across all
 * API endpoints that implement cursor-based pagination.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://relay.dev/graphql/connections.htm#sec-Cursor
 *
 * @psalm-immutable
 */
final readonly class CursorPaginatorSchema
{
    /**
     * Create the OpenRPC schema definition for cursor-based pagination.
     *
     * Generates a standardized schema that defines the structure and validation
     * rules for cursor-based pagination parameters. The schema includes both
     * required and optional properties for controlling pagination behavior,
     * with detailed descriptions for API documentation generation.
     *
     * The cursor parameter is required for navigating through paginated results,
     * while the size parameter is optional and controls the number of items
     * returned per page.
     *
     * @return array<string, mixed> openRPC schema array containing the cursor
     *                              paginator structure with name, data type,
     *                              required fields, and property definitions
     *                              for cursor and size parameters
     */
    public static function create(): array
    {
        return [
            'name' => 'CursorPaginator',
            'data' => [
                'type' => 'object',
                'required' => ['cursor'],
                'properties' => [
                    'cursor' => [
                        'type' => 'string',
                        'description' => 'The cursor to start from. If not specified, the first page is returned.',
                    ],
                    'size' => [
                        'type' => 'integer',
                        'description' => 'The number of items to return per page. If not specified, the default page size is used.',
                    ],
                ],
            ],
        ];
    }
}
