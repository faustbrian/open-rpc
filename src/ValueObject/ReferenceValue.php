<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

/**
 * OpenRPC Reference Object value object.
 *
 * Represents a Reference Object containing a JSON reference pointer within the
 * OpenRPC specification. This allows referencing and reusing schema definitions,
 * components, or other parts of the OpenRPC document through JSON Pointer syntax.
 *
 * References enable modular design and reduce duplication by allowing multiple
 * parts of the specification to point to shared definitions. This promotes
 * maintainability and consistency across the API specification.
 *
 * @see https://spec.open-rpc.org/#reference-object
 * @see https://datatracker.ietf.org/doc/html/rfc6901
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class ReferenceValue extends Data
{
    /**
     * Create a new Reference Object instance.
     *
     * @param string $ref JSON reference string pointing to a reusable component within
     *                    the OpenRPC document or external resource. Must follow JSON
     *                    Pointer syntax (RFC 6901) or URI format for referencing schemas,
     *                    parameters, or other definitions (e.g., "#/components/schemas/User").
     */
    public function __construct(
        #[Required()]
        #[MapOutputName('$ref')]
        public readonly string $ref,
    ) {}
}
