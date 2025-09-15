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
 * Represents a tag for categorizing and organizing OpenRPC methods.
 *
 * This value object provides a way to group and categorize API methods with
 * descriptive labels and additional metadata. Tags help organize large APIs
 * by creating logical groupings of related functionality, making the API
 * documentation more navigable and understandable for consumers.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#tag-object
 */
final class TagValue extends Data
{
    /**
     * Create a new tag definition object.
     *
     * @param string                          $name         Required unique identifier for the tag that serves
     *                                                      as the primary label for grouping methods. Should be
     *                                                      descriptive and follow consistent naming conventions
     *                                                      across the API for effective organization.
     * @param null|string                     $summary      Optional brief description of the tag's purpose or
     *                                                      the category of methods it represents. Provides quick
     *                                                      understanding of the tag's scope and meaning.
     * @param null|string                     $description  optional detailed explanation of the tag's usage,
     *                                                      the types of methods it encompasses, and any specific
     *                                                      conventions or patterns associated with tagged methods
     * @param null|ExternalDocumentationValue $externalDocs optional reference to external documentation that
     *                                                      provides comprehensive information about the methods
     *                                                      or functionality represented by this tag category
     */
    public function __construct(
        #[Required()]
        public readonly string $name,
        public readonly ?string $summary,
        public readonly ?string $description,
        public readonly ?ExternalDocumentationValue $externalDocs,
    ) {}
}
