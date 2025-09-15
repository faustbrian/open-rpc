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
 * Represents a JSON reference pointer within the OpenRPC specification.
 *
 * This value object encapsulates JSON Schema references that allow referencing
 * and reusing schema definitions, components, or other parts of the OpenRPC
 * document. References enable modular design and reduce duplication by allowing
 * multiple parts of the specification to point to shared definitions.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#reference-object
 */
final class ReferenceValue extends Data
{
    /**
     * Create a new reference pointer object.
     *
     * @param string $ref Required JSON reference string that points to a reusable
     *                    component within the OpenRPC document or external resource.
     *                    Must follow JSON Pointer syntax (RFC 6901) or URI format
     *                    for referencing schemas, parameters, or other definitions.
     */
    public function __construct(
        #[Required()]
        #[MapOutputName('$ref')]
        public readonly string $ref,
    ) {}
}
