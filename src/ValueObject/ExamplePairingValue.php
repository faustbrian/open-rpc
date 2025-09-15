<?php declare(strict_types=1);

/**
 * Copyright (C) Brian Faust
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cline\OpenRpc\ValueObject;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;

/**
 * OpenRPC Example Pairing Object value object.
 *
 * Represents an Example Pairing Object that groups related parameter examples
 * with their corresponding result examples for OpenRPC methods. Example Pairings
 * demonstrate complete request-response scenarios, showing how specific input
 * parameters produce specific output results.
 *
 * Example Pairings are essential for API documentation, testing, and client
 * code generation as they provide concrete examples of how methods work in
 * practice. They help developers understand expected input formats and
 * corresponding response structures.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#example-pairing-object
 */
final class ExamplePairingValue extends Data
{
    /**
     * Create a new Example Pairing Object instance.
     *
     * @param string                                 $name        A unique identifier for this example pairing within
     *                                                            the context where it is used. The name should be
     *                                                            descriptive and help identify the specific scenario
     *                                                            or use case that this pairing demonstrates.
     * @param null|string                            $description A detailed description of what this
     *                                                            example pairing demonstrates, including
     *                                                            the scenario, expected behavior, and any
     *                                                            important context about the example.
     *                                                            Used for comprehensive documentation.
     * @param null|string                            $summary     A brief summary of the example pairing that
     *                                                            provides a quick overview of the scenario
     *                                                            being demonstrated. This is used in generated
     *                                                            documentation and IDE tooltips.
     * @param DataCollection<int, ExampleValue>      $params      Collection of Example Objects
     *                                                            that define the input parameters
     *                                                            for this example scenario. These
     *                                                            examples show the specific values
     *                                                            and structure of parameters needed
     *                                                            to produce the paired result.
     * @param null|DataCollection<int, ExampleValue> $result      Optional collection of
     *                                                            Example Objects that define
     *                                                            the expected result or output
     *                                                            for the given parameters.
     *                                                            When provided, demonstrates
     *                                                            the complete request-response
     *                                                            cycle for this scenario.
     */
    public function __construct(
        #[Required()]
        public readonly string $name,
        public readonly ?string $description,
        public readonly ?string $summary,
        #[Required()]
        #[DataCollectionOf(ExampleValue::class)]
        public readonly DataCollection $params,
        #[DataCollectionOf(ExampleValue::class)]
        public readonly ?DataCollection $result,
    ) {}
}
