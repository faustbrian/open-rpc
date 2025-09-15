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
 * Represents the metadata and general information about an OpenRPC API.
 *
 * This value object contains the core metadata that describes the OpenRPC API,
 * including its title, version, description, and associated legal information.
 * The Info object serves as the primary identifier and descriptor for the API,
 * providing essential details that help consumers understand the API's purpose,
 * licensing, and contact information.
 *
 * @author Brian Faust <brian@shipit.fi>
 *
 * @version 1.0.1
 *
 * @see https://spec.open-rpc.org/#info-object
 */
final class InfoValue extends Data
{
    /**
     * Create a new API information object.
     *
     * @param string            $title          Required title of the OpenRPC API. This is the
     *                                          primary identifier and name that will be displayed
     *                                          in documentation and used to identify the API.
     * @param null|string       $description    Optional detailed description explaining the API's
     *                                          purpose, functionality, and intended use cases.
     *                                          Supports CommonMark syntax for rich formatting.
     * @param null|string       $termsOfService Optional URL pointing to the terms of service for
     *                                          this API. Should be a valid, accessible URL that
     *                                          contains the legal terms governing API usage.
     * @param null|ContactValue $contact        Optional contact information for the API maintainers
     *                                          or support team. Includes details like email, name,
     *                                          and website for users who need assistance or support.
     * @param null|LicenseValue $license        Optional license information under which the API
     *                                          is made available. Specifies the legal terms and
     *                                          permissions for using the API and its documentation.
     * @param string            $version        Required version identifier for this API. Should
     *                                          follow semantic versioning conventions to help
     *                                          consumers understand API evolution and compatibility.
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
