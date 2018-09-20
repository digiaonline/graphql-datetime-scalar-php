# graphql-datetime-scalar-php

[![Build Status](https://travis-ci.org/digiaonline/graphql-datetime-scalar-php.svg?branch=master)](https://travis-ci.org/digiaonline/graphql-datetime-scalar-php)
[![Coverage Status](https://coveralls.io/repos/github/digiaonline/graphql-datetime-scalar-php/badge.svg?branch=master)](https://coveralls.io/github/digiaonline/graphql-datetime-scalar-php?branch=master)

Date, Time and DateTime scalar types for our [GraphQL implementation](https://github.com/digiaonline/graphql-php/)

## Introduction

Most GraphQL APIs need a way to represent dates, times or timestamps of some sort. Since there is no native date type 
in GraphQL, people have to resort to rolling their own. To reduce the boilerplate required, this library provides a 
few basic scalar types that should cover most situations.

## Requirements

* PHP >= 7.1
* [digiaonline/graphql](https://github.com/digiaonline/graphql-php/)

## Usage

Installation the library using Composer:

```bash
composer require digiaonline/graphql-datetime-scalar
```

When wiring up your executable schema, simply pass in the types you need:

```php
$executableSchema = buildSchema($schemaDefinition, [
    'Query'    => QueryResolver::class,
    'Mutation' => MutationResolver::class,
], [
    'types' => [
        new DateScalarType(),
        new TimeScalarType(),
        new DateTimeScalarType(),
    ],
]);
```

You can specify the format by passing a format string to the constructor:

```php
$dateType     = new DateScalarType('j.n.Y'); // 31.12.2018
$timeType     = new TimeScalarType('H:i'); // 14:35
$dateTimeType = new DateTimeScalarType('U'); // 1537361927
```

Like the built-in scalar types, if a value cannot be serialized or parsed correctly into a `\DateTimeInterface`, 
a `\Digia\GraphQL\Error\InvalidTypeException` will be thrown.

## License

MIT
