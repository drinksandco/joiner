# Joiner

[![Software License][ico-license]](LICENSE.md)
[![Build Status](https://travis-ci.org/uvinum/joiner.svg?branch=master)](https://travis-ci.org/uvinum/joiner)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/uvinum/joiner/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/uvinum/joiner/?branch=master)

A powerful library to serialize and append/filter data from your php objects or native php types (arrays, strings, integer...)

## Install

Via Composer

``` bash
$ composer require uvinum/joiner
```

## Basic Usage

``` php
$joiner = new Joiner(new ArraySerializer(new DefaultStrategy()), new ArrayManipulator());

$myObject = new MyObject();
$mySecondObject = new MySecondObject();
$joiner
    ->join($myObject)
    ->append($mySecondObject)
    ->filter('secondObjectFieldName');

$serializedOutput = $joiner->execute();
```

Follow [docs](docs/index.md) section to read about full capabilities. 

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
