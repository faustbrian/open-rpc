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
 * @author Brian Faust <brian@cline.sh>
 * @see https://spec.open-rpc.org/#example-pairing-object
 */
final class ExamplePairingValue extends Data
{
    /**
     * Create a new Example Pairing Object instance.
     *
     * @param string                                 $name        Unique identifier for this example pairing within its
     *                                                            usage context. Should be descriptive and clearly identify
     *                                                            the specific scenario or use case that this pairing
     *                                                            demonstrates for documentation and testing purposes.
     * @param null|string                            $description Detailed description of what this example pairing
     *                                                            demonstrates including the scenario, expected behavior,
     *                                                            and important context. Provides comprehensive explanation
     *                                                            for documentation generation and developer understanding.
     * @param null|string                            $summary     Brief summary providing a quick overview of the scenario
     *                                                            being demonstrated. Used in generated documentation, IDE
     *                                                            tooltips, and quick reference materials to communicate
     *                                                            the example's purpose at a glance.
     * @param DataCollection<int, ExampleValue>      $params      Collection of Example Objects defining the input parameters
     *                                                            for this example scenario. Shows the specific values and
     *                                                            structure of parameters needed to produce the paired result,
     *                                                            demonstrating proper method invocation patterns.
     * @param null|DataCollection<int, ExampleValue> $result      Collection of Example Objects defining the expected result
     *                                                            or output for the given parameters. When provided, demonstrates
     *                                                            the complete request-response cycle, showing developers exactly
     *                                                            what to expect from the method with these specific inputs.
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
