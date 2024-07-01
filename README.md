# Programic - Laravel tools

[![Latest Version on Packagist](https://img.shields.io/packagist/v/programic/laravel-tools.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-tools)
[![Tests](https://github.com/programic/laravel-tools/actions/workflows/tests.yml/badge.svg?branch=master)](https://github.com/programic/laravel-tools/actions/workflows/tests.yml)
![](https://github.com/programic/laravel-tools/workflows/Run%20Tests/badge.svg?branch=master)
[![Total Downloads](https://img.shields.io/packagist/dt/programic/laravel-tools.svg?style=flat-square)](https://packagist.org/packages/programic/laravel-tools)

This package is a Laravel extension

## Installation
This package requires PHP 5.6 and Laravel 5.0 or higher.

```
composer require programic/laravel-tools
```

## Usage

### Sentry
#### Laravel 11+
Add this chain to the Application in ``bootstrap/app.php``
```php
->withExceptions(function (Exceptions $exceptions) {
    Integration::handles($exceptions);
})
```
#### Laravel 8 - 10
Replace report method in ``App\Exceptions\Handler``
```php
public function report(Exception $exception)
{
    if ($this->shouldReport($exception) && app()->bound('sentry')) {
        app('sentry')->captureException($exception);
    }

    parent::report($exception);
}
```

### Mysql support
Add ``Mysql8ServiceProvider`` in your ``config/app.php`` to add mysql 8 support for migrations

### Add debug data to api responses 
Add ``Programic\Tools\Middleware\DebugBarMeta`` as middleware in your ``App/Http/Kernel.php`` API group to add debug data in every response 

#### Vue package
Use our vue plugin to add this debug data to the Vue Devtools: https://github.com/programic/api-debugbar-vue-devtools

## Testing
```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email [info@programic.com](mailto:info@programic.com) instead of using the issue tracker.

## Credits

- [Rick Bongers](https://github.com/rbongers)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
