<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * Represents an external documentation reference within the OpenRPC specification.
 *
 * This value object encapsulates references to external documentation that provides
 * additional information about the API, such as user guides, tutorials, or detailed
 * specifications. External documentation helps enrich the API documentation by
 * linking to comprehensive resources beyond the basic method signatures.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#external-documentation-object
 */
final class ExternalDocumentationValue extends Data
{
    /**
     * Create a new external documentation reference.
     *
     * @param null|string $description Optional description of the external documentation
     *                                 resource. Provides context about what type of
     *                                 information or guidance the external link contains,
     *                                 helping users understand its relevance.
     * @param string      $url         Required URL pointing to the external documentation
     *                                 resource. Must be a valid, accessible URL that leads
     *                                 to the referenced documentation or resource.
     */
    public function __construct(
        public readonly ?string $description,
        #[Required()]
        public readonly string $url,
    ) {}
}
