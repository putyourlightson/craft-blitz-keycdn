[![Stable Version](https://img.shields.io/packagist/v/putyourlightson/craft-blitz-keycdn?label=stable)]((https://packagist.org/packages/putyourlightson/craft-blitz-keycdn))
[![Total Downloads](https://img.shields.io/packagist/dt/putyourlightson/craft-blitz-keycdn)](https://packagist.org/packages/putyourlightson/craft-blitz-keycdn)

<p align="center"><img width="130" src="https://raw.githubusercontent.com/putyourlightson/craft-blitz-keycdn/v4/src/icon.svg"></p>

# Blitz KeyCDN Purger for Craft CMS

The KeyCDN Purger plugin allows the [Blitz](https://putyourlightson.com/plugins/blitz) plugin for [Craft CMS](https://craftcms.com/) to intelligently purge pages cached on KeyCDN.

## Documentation

Read the documentation at [putyourlightson.com/plugins/blitz »](https://putyourlightson.com/plugins/blitz#reverse-proxy-purgers)

## License

This plugin is licensed for free under the MIT License.

## Requirements

This plugin requires [Craft CMS](https://craftcms.com/) 3.0.0 or later, or 4.0.0 or later.

## Installation

To install the plugin, search for “Blitz KeyCDN Purger” in the Craft Plugin Store, or install manually using composer.

```shell
composer require putyourlightson/craft-blitz-keycdn
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

---

Created by [PutYourLightsOn](https://putyourlightson.com/).
