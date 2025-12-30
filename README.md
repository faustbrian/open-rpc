[![GitHub Workflow Status][ico-tests]][link-tests]
[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

------

This library provides a PHP implementation of the [OpenRPC specification](https://spec.open-rpc.org/) for building JSON-RPC 2.0 APIs in Laravel applications. It includes complete value objects representing all OpenRPC specification components, content descriptors, and schema definitions using Spatie Laravel Data.

## Requirements

> **Requires [PHP 8.4+](https://php.net/releases/)**

## Installation

```bash
composer require cline/open-rpc
```

## Documentation

- **[Getting Started](https://docs.cline.sh/open-rpc/getting-started/)** - Installation and basic usage
- **[Value Objects](https://docs.cline.sh/open-rpc/value-objects/)** - API reference for specification components
- **[Content Descriptors](https://docs.cline.sh/open-rpc/content-descriptors/)** - Pre-built pagination, filtering, and sorting
- **[Schemas](https://docs.cline.sh/open-rpc/schemas/)** - Reusable JSON Schema definitions

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please use the [GitHub security reporting form][link-security] rather than the issue queue.

## Credits

- [Brian Faust][link-maintainer]
- [All Contributors][link-contributors]

## License

The MIT License. Please see [License File](LICENSE.md) for more information.

[ico-tests]: https://git.cline.sh/faustbrian/open-rpc/actions/workflows/quality-assurance.yaml/badge.svg
[ico-version]: https://img.shields.io/packagist/v/cline/open-rpc.svg
[ico-license]: https://img.shields.io/badge/License-MIT-green.svg
[ico-downloads]: https://img.shields.io/packagist/dt/cline/open-rpc.svg

[link-tests]: https://git.cline.sh/faustbrian/open-rpc/actions
[link-packagist]: https://packagist.org/packages/cline/open-rpc
[link-downloads]: https://packagist.org/packages/cline/open-rpc
[link-security]: https://git.cline.sh/faustbrian/open-rpc/security
[link-maintainer]: https://git.cline.sh/faustbrian
[link-contributors]: ../../contributors
