# Object

[![Latest Version](https://img.shields.io/github/release/josecelano/php-object-literal.svg?style=flat-square)](https://github.com/josecelano/php-object-literal/releases)
[![Build Status](https://img.shields.io/travis/josecelano/php-object-literal.svg?style=flat-square)](https://travis-ci.org/josecelano/php-object-literal)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/josecelano/php-object-literal.svg?style=flat-square)](https://scrutinizer-ci.com/g/josecelano/php-object-literal)
[![Quality Score](https://img.shields.io/scrutinizer/g/josecelano/php-object-literal.svg?style=flat-square)](https://scrutinizer-ci.com/g/josecelano/php-object-literal)
[![Total Downloads](https://img.shields.io/packagist/dt/josecelano/php-object-literal.svg?style=flat-square)](https://packagist.org/packages/josecelano/php-object-literal)

[![Email](https://img.shields.io/badge/email-josecelano@gmail.com-blue.svg?style=flat-square)](mailto:josecelano@gmail.com)

PHP 5.5+ library to create object literals like JavaScript or Ruby.

Creating object literals in PHP is not as easy (or elegant) as in JavaScript or Ruby.

You can create object literals this way:

``` php
$object = new Object([
    "name" => "Fido",
    "barks" => true,
    "age" => 10
]);
```

instead of:

``` php
$object = new Object();
$object->name = 'Fido';
$object->barks = true;
$object->age = 10;
```

This class was inspired by these two blog posts:

* https://www.sitepoint.com/php-vs-ruby-lets-all-just-get-along/
* https://www.phpied.com/javascript-style-object-literals-in-php/

In fact, there is am old PHP RFC (2011-06-04) which have not been completely implemented:

* https://wiki.php.net/rfc/objectarrayliterals

This class could be used while the RFC is not implemented.


## Install

Via Composer

``` bash
$ composer require josecelano/php-object-literal
```

## Features

- Build from array.
- Build from json.
- Build from json with dynamic keys and values.

## Testing

I try to follow TDD, as such I use [phpunit](https://phpunit.de) to test this library.

``` bash
$ composer test
```

## TODO

- Add magic getters and setters.
- Allow to replace variable values in Json like JavaScript:
From:
```php
$object = new Object("{
    \"name\" : \"" . $valueForName . "\",
    \"barks\" : true,
    \"age\" : 10
}");
```
To:
```php
$object = new Object('{
    "name" : $valueForName,
    "barks" : true,
    "age" : 10
}', get_defined_vars());
```
Replacing `$valueForName` by its value.
- Allow current invalid PHP json formats.
```php
$invalidJson1 = "{ 'bar': 'baz' }";
$invalidJson2 = '{ bar: "baz" }';
$invalidJson3 = '{ bar: "baz", }';
```
- Add callable in json format.
- Allow property value shorthand like ES6:
```php
$object = new Object('{
    $name,
    $barks,
    $age
}', get_defined_vars());
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.