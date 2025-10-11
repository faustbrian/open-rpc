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
 * OpenRPC External Documentation Object value object.
 *
 * Represents an External Documentation Object that provides references to external
 * documentation resources for the API. External documentation helps enrich API
 * specifications by linking to comprehensive resources such as user guides, tutorials,
 * detailed specifications, or reference materials beyond basic method signatures.
 *
 * This object enables API designers to point consumers to additional learning resources,
 * best practices, and detailed implementation guides that complement the core specification.
 *
 * @see https://spec.open-rpc.org/#external-documentation-object
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ExternalDocumentationValue extends Data
{
    /**
     * Create a new External Documentation Object instance.
     *
     * @param null|string $description Description of the external documentation resource.
     *                                 Provides context about what type of information or
     *                                 guidance the link contains, helping users understand
     *                                 its relevance and whether to follow the reference.
     * @param string      $url         URL pointing to the external documentation resource.
     *                                 Must be a valid, accessible URL leading to user guides,
     *                                 tutorials, reference materials, or other documentation
     *                                 that supplements the core API specification.
     */
    public function __construct(
        public readonly ?string $description,
        #[Required()]
        public readonly string $url,
    ) {}
}
