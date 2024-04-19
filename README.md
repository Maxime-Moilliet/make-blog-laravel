# make-blog-laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/maxime-moilliet/make-blog-laravel.svg?style=flat-square)](https://packagist.org/packages/maxime-moilliet/make-blog-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/maxime-moilliet/make-blog-laravel/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/maxime-moilliet/make-blog-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/maxime-moilliet/make-blog-laravel/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/maxime-moilliet/make-blog-laravel/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/maxime-moilliet/make-blog-laravel.svg?style=flat-square)](https://packagist.org/packages/maxime-moilliet/make-blog-laravel)

## Installation

You can install the package via composer:

```bash
composer require maxime-moilliet/make-blog-laravel
```

You can install the package via artisan command:

```bash
php artisan install:blog
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="make-blog-laravel-migrations"
php artisan migrate
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
