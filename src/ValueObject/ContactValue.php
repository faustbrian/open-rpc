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
 * OpenRPC Contact Object value object.
 *
 * Represents contact information for the API specification, providing
 * details about who to contact for support or inquiries related to the API.
 * This object is typically used in the Info Object to provide contact
 * details for API consumers and developers.
 *
 * The Contact Object allows API specification authors to provide multiple
 * ways for users to get in touch, including name, website URL, and email
 * address, enhancing the discoverability and support experience for API users.
 * All fields are optional, allowing flexibility in how contact information
 * is presented.
 *
 * ```php
 * $contact = new ContactValue(
 *     name: 'API Support Team',
 *     url: 'https://example.com/support',
 *     email: 'api-support@example.com',
 * );
 * ```
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#contact-object
 */
final class ContactValue extends Data
{
    /**
     * Create a new Contact Object instance.
     *
     * @param null|string $name  Identifying name of the contact person or organization responsible for the API. This could be a person's name, team name, or organization name that API users can reference when seeking support or information. Typically displayed in generated documentation.
     * @param null|string $url   URL pointing to the contact information or support page. This could be a website, documentation page, support portal, or any other URL that provides additional contact information or support resources for API users. Must be a valid URL format.
     * @param null|string $email Email address for contacting the API maintainers or support team. This should be a monitored email address where API users can send questions, bug reports, or feedback about the API specification or implementation. Should follow standard email format.
     */
    public function __construct(
        public readonly ?string $name,
        public readonly ?string $url,
        public readonly ?string $email,
    ) {}
}
