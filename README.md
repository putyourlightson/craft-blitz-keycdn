# Blitz KeyCDN Purger for Craft CMS

The KeyCDN Purger allows the [Blitz](https://putyourlightson.com/craft-plugins/blitz) plugin for [Craft CMS](https://craftcms.com/) to intelligently purge cached pages.

## Usage

Install the purger using composer.

```
composer require putyourlightson/craft-blitz-keycdn
```

Then add the class to the `cachePurgerTypes` config setting in `config/blitz.php`.

```
// The purger type classes to add to the plugin’s default purger types.
'cachePurgerTypes' => [
    'putyourlightson\blitz\drivers\purgers\CloudflarePurger',
    'putyourlightson\blitzkeycdn\KeyCdnPurger',
],
```

You can then select the purger and settings in the control panel or in `config/blitz.php`.

```
  // The purger type to use.
  'cachePurgerType' => 'putyourlightson\blitzkeycdn\KeyCdnPurger',

  // The purger settings.
  'cachePurgerSettings' => [
     'apiKey' => 'sk_prod_abcdefgh1234567890',
     'zoneId' => '123456',
  ],
```

## Documentation

Read the documentation at [putyourlightson.com/craft-plugins/blitz/docs](https://putyourlightson.com/craft-plugins/blitz/docs#/?id=custom-reverse-proxy-purgers).

Created by [PutYourLightsOn](https://putyourlightson.com/).
