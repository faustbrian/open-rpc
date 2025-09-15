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
 * Represents a link reference within the OpenRPC specification.
 *
 * This value object encapsulates links that provide references to related
 * resources, documentation, or examples. Links help create connections between
 * different parts of the API documentation and provide additional context or
 * resources that enhance the understanding and usability of the API.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#link-object
 */
final class LinkValue extends Data
{
    /**
     * Create a new link reference object.
     *
     * @param null|string $name Optional descriptive name for the link that helps
     *                          identify its purpose or content. Should be human-readable
     *                          and provide clear indication of what the link contains.
     * @param null|string $url  Optional URL pointing to the linked resource, documentation,
     *                          or related content. Should be a valid, accessible URL that
     *                          provides relevant information related to the API context.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $url,
    ) {}
}
