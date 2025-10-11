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
 * OpenRPC Info Object value object.
 *
 * Represents the Info Object containing core metadata and general information
 * about an OpenRPC API. This includes the API's title, version, description,
 * and associated legal information such as licensing and contact details.
 *
 * The Info Object serves as the primary identifier and descriptor for the API,
 * providing essential details that help consumers understand the API's purpose,
 * capabilities, licensing terms, and how to get support or contact maintainers.
 *
 * @see https://spec.open-rpc.org/#info-object
 *
 * @author Brian Faust <brian@cline.sh>
 */
final class InfoValue extends Data
{
    /**
     * Create a new Info Object instance.
     *
     * @param string            $title          Title of the OpenRPC API. Primary identifier and name
     *                                          displayed in documentation, used to clearly identify
     *                                          the API to consumers, developers, and in generated
     *                                          client libraries and server implementations.
     * @param null|string       $description    Detailed description explaining the API's purpose,
     *                                          functionality, and intended use cases. Supports
     *                                          CommonMark syntax for rich formatting including
     *                                          code blocks, links, and emphasis for documentation.
     * @param null|string       $termsOfService URL pointing to the terms of service governing API usage.
     *                                          Should be a valid, accessible URL containing the legal
     *                                          terms, usage restrictions, and compliance requirements
     *                                          for consumers of the API.
     * @param null|ContactValue $contact        Contact information for API maintainers or support team.
     *                                          Includes details such as email, name, and website URL
     *                                          for users who need assistance, want to report issues,
     *                                          or require support with API integration.
     * @param null|LicenseValue $license        License information under which the API is made available.
     *                                          Specifies legal terms, permissions, and restrictions for
     *                                          using the API and its documentation. Helps consumers
     *                                          understand their rights and obligations.
     * @param string            $version        Version identifier for this API. Should follow semantic
     *                                          versioning conventions (e.g., "1.0.0") to help consumers
     *                                          understand API evolution, compatibility, and breaking
     *                                          changes across different releases.
     */
    public function __construct(
        #[Required()]
        public readonly string $title,
        public readonly ?string $description,
        public readonly ?string $termsOfService,
        public readonly ?ContactValue $contact,
        public readonly ?LicenseValue $license,
        #[Required()]
        public readonly string $version,
    ) {}
}
