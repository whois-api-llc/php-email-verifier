# php-email-verifier

*The simplest possible way to verify an email in PHP.*

## Prerequisites

To use this library, you'll need to create a free Email Verification account:
https://emailverification.whoisxmlapi.com/

If you haven't done this yet, please do so now.


## Installation

To install `email-verifier` using [composer](https://getcomposer.org/), simply run:

```console
$ composer require whois-api/email-verifier
```
In the root of your project directory.


To use the library, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading)

```php
require_once __DIR__ . "/vendor/autoload.php";
```

## Requirements

### Supported PHP versions:

* PHP 5.6.x
* PHP 7.0.x
* PHP 7.1.x
* PHP 7.2.x

### Dependencies:

* mbstring
* mbregex
* json
* curl

## Documentation

Full API documentation available [here](https://emailverification.whoisxmlapi.com/docs)

## Usage

Once you have `email-verifier` installed, you can use it to easily verify an 
email address. Email verification performs a number of checks to ensure a 
given email address is actually valid. 

This library gives you access to all sorts of email verification data that 
you can use in your application in any number of ways.

```php
<?php
require_once  __DIR__ . '/../vendor/autoload.php';

use WhoisApi\EmailVerifier\Builders\ClientBuilder;


$builder = new ClientBuilder();

$client = $builder->build('Your API key');

try {
    echo $client->getRawData('support@whoisxmlapi.com', 'json') . PHP_EOL;
    /* Disable refreshing */
    echo print_r($client->get('support@whoisxmlapi.com', ['_hardRefresh']), true) . PHP_EOL;
    
    $result = $client->get('support@whoisxmlapi.com', ['_hardRefresh']);
    echo 'Email: ' . $result->emailAddress . PHP_EOL;
    echo 'Format: ' . ($result->formatCheck ? 'valid' : 'invalid') . PHP_EOL;
    echo 'DNS: '. ($result->dnsCheck ? 'resolved' : 'not resolved') . PHP_EOL;
    echo 'SMTP: ' . ($result->smtpCheck ? 'working' : 'not working') . PHP_EOL;
    echo 'Free: ' . ($result->freeCheck ? 'yes' : 'no') . PHP_EOL;
    echo 'Catch all: ' . ($result->catchAllCheck ? 'yes' : 'no') . PHP_EOL;
    echo 'Disposable: ' . ($result->disposableCheck ? 'yes' : 'no') . PHP_EOL;
} catch (\Throwable $exception) {
    echo "Error: {$exception->getCode()} {$exception->getMessage()}" . PHP_EOL;
}
```
More examples you can see in the "examples" directory.

Before run these examples you need to specify your API key as an environment
variable:

```bash
export API_KEY="<Your-API-key>"

php examples/basic.php
```

Here's the sort of data you might get back when performing a email verification
request:

```json
{
  "emailAddress": "support@whoisxmlapi.com",
  "formatCheck": "true",
  "smtpCheck": "true",
  "dnsCheck": "true",
  "freeCheck": "false",
  "disposableCheck": "false",
  "catchAllCheck": "true",
  "mxRecords": [
    "ALT1.ASPMX.L.GOOGLE.com",
    "ALT2.ASPMX.L.GOOGLE.com",
    "ASPMX.L.GOOGLE.com",
    "ASPMX2.GOOGLEMAIL.com",
    "ASPMX3.GOOGLEMAIL.com",
    "mx.yandex.net"
  ],
  "audit": {
    "auditCreatedDate": "2018-04-19 18:12:45.000 UTC",
    "auditUpdatedDate": "2018-04-19 18:12:45.000 UTC"
  }
}
```

## Development

After you clone this repository you need to install all requirements:

```console
$ composer install
```

To run tests you can use the following command

```console
$ composer run-script test
```