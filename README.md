# Meta Tags - Module for Magento 2

IMPORTANT: IT'S JUST A TEST MODULE, THERE WILL BE NO MAINTENANCE IN THE FUTURE

## Description
The module adds a <link> tag to pages used in multiple store views.

The `<link>` tag is added inside the `<head>` tag

Example tag:
```html
<link rel="alternate" hreflang="en-us" href="https://magento.test/no-route">
```

## Installation

The extension can be installed via `composer`. To proceed, run these commands in your terminal:

```
composer require tesche/rangeproducts
php bin/magento module:enable Tesche_MetaTags
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## How to use
The module after enabled will work and show the tag on pages that have use in multiple views automatically