# Backpack\LangFileManager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status](https://img.shields.io/travis/Laravel-Backpack/langfilemanager/master.svg?style=flat-square)](https://travis-ci.org/Laravel-Backpack/langfilemanager)
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Style CI](https://styleci.io/repos/53691643/shield)](https://styleci.io/repos/53691643)
[![Total Downloads][ico-downloads]][link-downloads]

A quick interface to edit language files, for Laravel Backpack.

**Subscribe to the [Mailchimp list](http://eepurl.com/bUEGjf) to be up to date with the community.**

![Edit view for Backpack/LangFileManager](https://dl.dropboxusercontent.com/u/2431352/backpack_langfilemanager.png)

## Install

### Step 1. Install via Composer

``` bash
$ composer require backpack/langfilemanager
```

### Step 2. Add the service provider

In your config/app.php, add this to the providers array:

``` bash
Backpack\LangFileManager\LangFileManagerServiceProvider::class,
```

### Step 3. Run the migration, seed and file publishing

``` bash
$ php artisan migrate --path=vendor/backpack/langfilemanager/src/database/migrations
$ php artisan db:seed --class="Backpack\LangFileManager\database\seeds\LanguageTableSeeder"
$ php artisan vendor:publish --provider="Backpack\LangFileManager\LangFileManagerServiceProvider" --tag="config" #publish the config file
$ php artisan vendor:publish --provider="Backpack\LangFileManager\LangFileManagerServiceProvider" --tag="lang" #publish the lang files
```


## Usage

// TODO: change variable to "protected_lang_files" or smth like that

Tell LangFileManager what langfiles NOT to show, in config/backpack/langfilemanager.php:

``` php
// Language files to NOT show in the LangFileManager
//
'language_ignore' => ['admin', 'pagination', 'reminders', 'validation', 'log', 'crud'],
```

Add a menu item for it in resources/views/vendor/backpack/base/inc/sidebar.blade.php:

```html
<li class="treeview">
  <a href="#"><i class="fa fa-globe"></i> <span>Translations</span> <i class="fa fa-angle-left pull-right"></i></a>
  <ul class="treeview-menu">
    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/language') }}"><i class="fa fa-flag-checkered"></i> Languages</a></li>
    <li><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/language/texts') }}"><i class="fa fa-language"></i> Site texts</a></li>
  </ul>
</li>
```

or in menu.blade.php:
```html
<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    <i class="fa fa-globe"></i> Translations<span class="caret"></span>
  </a>
  <ul class="dropdown-menu" role="menu">
    <li class=""><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/language') }}"><i class="fa fa-flag-checkered"></i> Languages</a></li>
    <li class=""><a href="{{ url(config('backpack.base.route_prefix', 'admin').'/language/texts') }}"><i class="fa fa-language"></i> Site texts</a></li>
  </ul>
</li>
```

Or just try at **your-project-domain/admin/language/texts**

## Screenshots

See http://laravelbackpack.com

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.


## Testing

// TODO

``` bash
$ composer test
```


## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.


## Security

If you discover any security related issues, please email alin@updivision.com or hello@tabacitu.ro instead of using the issue tracker.


## Credits

- [Alin Ghitu][link-author] - author
- [Cristian Tabacitu][link-author-2] - contributor
- [All Contributors][link-contributors]


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/backpack/langfilemanager.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/laravel-backpack/langfilemanager/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/laravel-backpack/langfilemanager.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/laravel-backpack/langfilemanager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/backpack/langfilemanager.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/backpack/langfilemanager
[link-travis]: https://travis-ci.org/laravel-backpack/langfilemanager
[link-scrutinizer]: https://scrutinizer-ci.com/g/laravel-backpack/langfilemanager/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/laravel-backpack/langfilemanager
[link-downloads]: https://packagist.org/packages/backpack/langfilemanager
[link-author]: https://github.com/ghitu
[link-author-2]: http://tabacitu.ro
[link-contributors]: ../../contributors
