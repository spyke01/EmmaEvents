EmmaEvents
====

EmmaEvents is a PHP class for interaction with the [Emma API](http://api.myemma.com).

    Copyright (c) 2017 Paden Clayton.
    Written by Paden Clayton
    Base on [Emma](https://github.com/markroland/emma) by Mark Roland
    Released under the MIT license.

This PHP class may be distributed and used for free. The author makes
no guarantee for this software and offers no support.

Build status: [![Build Status](https://travis-ci.org/spyke01/EmmaEvents.svg)](https://travis-ci.org/spyke01/EmmaEvents)

Installation
------------

```sh
    composer require FTS/EmmaEvents:~2
```

Usage
-----

To get started, initialize the Emma class as follows:

```php
    $emmaEvents = new EmmaEvents(<account_id>, <public_key>, <private_key>);
```

For example,

```php
    $emmaEvents = new EmmaEvents('1234','Drivorj7QueckLeuk','WoghtepheecijnibV');
```

In order to understand how to use this script, please make sure you
have a good understanding of the Emma API:

http://api.myemma.com/

## PHP Documentation

PHP Documentation is compiled using [phpDocumentor](http://www.phpdoc.org), which is assumed
to be installed globally on the server. It uses phpdoc.dist.xml for runtime configuration.

```sh
    phpdoc
```

## Code Sniff

```sh
    phpcs -n --report-width=100 ./src/EmmaEvents.php
```
