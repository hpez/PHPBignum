# PHPBignum [![Build Status](https://travis-ci.org/hpez/PHPBignum.svg?branch=master)](https://travis-ci.org/hpez/PHPBignum) [![codecov](https://codecov.io/gh/hpez/PHPBignum/branch/master/graph/badge.svg)](https://codecov.io/gh/hpez/PHPBignum)
A bignum library for PHP 7.1.

| Type          | Addition      | Subtraction   | Division      | Multiplication | Square root    | Power          |
| ------------- |---------------|---------------|---------------|----------------|----------------|----------------|
| BigInt        | done          | done          | done          | done           | pending        | done           |
| BigFloat      | done          | done          | pending       | pending        | pending        | pending        |

## Getting started
Just clone the project, go to the project directory and run `composer install` and should be good to go! Oh and also for running tests you should do `vendor/phpunit/phpunit/phpunit tests/`.

## Roadmap
The goal of this project is making a complete Bignum library for PHP language, so operations other than the ones mentioned in the table should be added too (trigonometric functions, ...). The packagist repo will be added as soon as BigFloat division, multiplication and power are done and it will be installable via composer.

## Contribution
Any contribution in the form of an issue or a pull request is more than welcome!
