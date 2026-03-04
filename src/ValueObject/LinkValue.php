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
 * OpenRPC Link Object value object.
 *
 * Represents a Link Object that provides references to related resources,
 * documentation, examples, or other contextual information within the OpenRPC
 * specification. Links help create connections between different parts of the
 * API documentation and provide additional resources.
 *
 * Link Objects enhance API documentation by providing supplementary resources
 * that improve understanding, usability, and developer experience when working
 * with the API.
 *
 * @author Brian Faust <brian@cline.sh>
 * @see https://spec.open-rpc.org/#link-object
 */
final class LinkValue extends Data
{
    /**
     * Create a new Link Object instance.
     *
     * @param null|string $name Descriptive name for the link identifying its purpose or
     *                          content. Should be human-readable and provide clear indication
     *                          of what the link contains, helping developers quickly assess
     *                          the relevance and value of following the reference.
     * @param null|string $url  URL pointing to the linked resource, documentation, or related
     *                          content. Should be a valid, accessible URL that provides relevant
     *                          information such as examples, tutorials, related specifications,
     *                          or contextual resources enhancing API understanding.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $url,
    ) {}
}
