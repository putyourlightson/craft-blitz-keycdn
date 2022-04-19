[![Stable Version](https://img.shields.io/packagist/v/putyourlightson/craft-blitz-keycdn?label=stable)]((https://packagist.org/packages/putyourlightson/craft-blitz-keycdn))
[![Total Downloads](https://img.shields.io/packagist/dt/putyourlightson/craft-blitz-keycdn)](https://packagist.org/packages/putyourlightson/craft-blitz-keycdn)

<p align="center"><img width="130" src="https://putyourlightson.com/assets/logos/blitz.svg"></p>

# Blitz KeyCDN Purger for Craft CMS

The KeyCDN Purger allows the [Blitz](https://putyourlightson.com/plugins/blitz) plugin for [Craft CMS](https://craftcms.com/) to intelligently purge cached pages.

## Usage

Install the purger using composer.

```shell
composer require putyourlightson/craft-blitz-keycdn
```

Then add the class to the `cachePurgerTypes` config setting in `config/blitz.php`.

```php
// The purger type classes to add to the plugin’s default purger types.
'cachePurgerTypes' => [
    'putyourlightson\blitzkeycdn\KeyCdnPurger',
],
```

You can then select the purger and settings either in the control panel or in `config/blitz.php`.

```php
// The purger type to use.
'cachePurgerType' => 'putyourlightson\blitzkeycdn\KeyCdnPurger',

// The purger settings.
'cachePurgerSettings' => [
   'apiKey' => 'sk_prod_abcdefgh1234567890',
   'zoneId' => '123456789',
],
```

## Documentation

Read the documentation at [putyourlightson.com/plugins/blitz](https://putyourlightson.com/plugins/blitz#reverse-proxy-purgers).

Created by [PutYourLightsOn](https://putyourlightson.com/).
