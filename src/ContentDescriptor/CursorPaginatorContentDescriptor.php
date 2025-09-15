<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ContentDescriptor;

/**
 * OpenRPC content descriptor for cursor-based pagination parameters.
 *
 * This class generates the OpenRPC content descriptor definition for cursor-based
 * pagination parameters in RPC method schemas. Cursor pagination is particularly
 * useful for real-time data feeds and large datasets where traditional offset-based
 * pagination may become inconsistent due to data changes during navigation.
 *
 * The descriptor defines pagination parameters that include cursor tokens for
 * navigating forward and backward through result sets, providing stable pagination
 * that maintains consistency even when the underlying data changes.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.2
 *
 * @psalm-immutable
 */
final readonly class CursorPaginatorContentDescriptor
{
    /**
     * Create the OpenRPC content descriptor for cursor pagination parameters.
     *
     * This method generates a standardized content descriptor that defines the
     * structure and validation rules for cursor-based pagination parameters in
     * RPC methods. The descriptor references a reusable CursorPaginator schema
     * component that contains the detailed field definitions for cursor tokens,
     * page sizes, and navigation parameters.
     *
     * The returned descriptor follows OpenRPC specification requirements and
     * includes human-readable descriptions for API documentation generation.
     *
     * @return array The OpenRPC content descriptor array with name, description, and schema reference
     */
    public static function create(): array
    {
        return [
            'name' => 'page',
            'description' => 'The page to return. If not specified, the first page is returned.',
            'schema' => [
                '$ref' => '#/components/schemas/CursorPaginator',
            ],
        ];
    }
}
