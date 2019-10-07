# PHPBignum [![Build Status](https://travis-ci.org/hpez/PHPBignum.svg?branch=master)](https://travis-ci.org/hpez/PHPBignum) [![codecov](https://codecov.io/gh/hpez/PHPBignum/branch/master/graph/badge.svg)](https://codecov.io/gh/hpez/PHPBignum) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/fb8fecb2617a41e9a05ee90e24d42e04)](https://app.codacy.com/app/hpez/PHPBignum?utm_source=github.com&utm_medium=referral&utm_content=hpez/PHPBignum&utm_campaign=Badge_Grade_Dashboard)

A bignum library for PHP.

| Type          | Addition      | Subtraction   | Division      | Multiplication | Square root    | Power          |
| ------------- |---------------|---------------|---------------|----------------|----------------|----------------|
| BigInt        | done          | done          | done          | done           | done           | done           |
| BigFloat      | done          | done          | done          | pending        | pending        | pending        |

## Setting up for developers
Just clone the project, go to the project directory and run `composer install` and should be good to go! Oh and also for running tests you should do `vendor/phpunit/phpunit/phpunit tests/`.

## Usage
The package is installable via `composer require hpez/php-bignum` or [packagist repo](https://packagist.org/packages/hpez/php-bignum)

## Roadmap
The goal of this project is making a complete Bignum library for PHP language, so operations other than the ones mentioned in the table should be added too (trigonometric functions, ...).

## Contribution
Any contribution in the form of an issue or a pull request is more than welcome! Also if you have any questions, feel free to create a new issue or comment on existing ones.
