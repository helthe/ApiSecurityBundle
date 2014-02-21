# Helthe Api Security Bundle [![Build Status](https://travis-ci.org/helthe/ApiSecurityBundle.png?branch=master)](https://travis-ci.org/helthe/ApiSecurityBundle) [![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/helthe/ApiSecurityBundle/badges/quality-score.png?s=eb5e74ae4910186635f08c19f04b3a90f0802747)](https://scrutinizer-ci.com/g/helthe/ApiSecurityBundle/)

Helthe Api Security Bundle integrates the [Helthe API Security Component](https://github.com/helthe/ApiSecurity)
with your Symfony2 application.

## Installation

### Step 1: Add package requirement in Composer

#### Manually

Add the following in your `composer.json`:

```json
{
    "require": {
        // ...
        "helthe/api-security-bundle": "~1.0"
    }
}
```

#### Using the command line

```bash
$ composer require 'helthe/api-security-bundle=~1.0'
```

### Step 2: Register the bundle in the kernel

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Helthe\Bundle\ApiSecurityBundle\HeltheApiSecurityBundle(),
    );
}
```

## Usage

### User Provider

The Helthe API security component provides its own `UserProviderInterface` that
must implemented by the user provider supplied to the Symfony firewall using
api key authentication.

### Firewall

To add api key authentication, simply add the `api_key` in your firewall
configuration as shown below:

```yaml
# security.yml
security:
    firewalls:
        api:
            api_key:
                name:   helthe-api-key
                method: http_header
```

## Bugs

For bugs or feature requests, please [create an issue](https://github.com/helthe/ApiSecurityBundle/issues/new).
