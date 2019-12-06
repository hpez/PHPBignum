# PHPBignum [![Build Status](https://travis-ci.org/hpez/PHPBignum.svg?branch=master)](https://travis-ci.org/hpez/PHPBignum) [![codecov](https://codecov.io/gh/hpez/PHPBignum/branch/master/graph/badge.svg)](https://codecov.io/gh/hpez/PHPBignum) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/fb8fecb2617a41e9a05ee90e24d42e04)](https://app.codacy.com/app/hpez/PHPBignum?utm_source=github.com&utm_medium=referral&utm_content=hpez/PHPBignum&utm_campaign=Badge_Grade_Dashboard)

A bignum library for PHP.

| Type          | Addition      | Subtraction   | Division      | Multiplication | Square root    | Power          |
| ------------- |---------------|---------------|---------------|----------------|----------------|----------------|
| BigInt        | done          | done          | done          | done           | done           | done           |
| BigFloat      | done          | done          | done          | done           | done           | pending        |

## Setting up for developers
Just clone the project, go to the project directory and run `composer install` and should be good to go! Oh and also for running tests you should do `vendor/phpunit/phpunit/phpunit tests/`.

## Installation
The package is installable via `composer require hpez/php-bignum` or [packagist repo](https://packagist.org/packages/hpez/php-bignum)

## Usage
```php
<?php

// BigInteger Addition
$bigInt1 = new BigInt('123456')
$bigInt2 = new BigInt('654321');
$bigInt1->add($bigInt2);
echo $bigInt1; // "777777"

// BigFloat Addition
$bigFloat1 = new BigFloat('123456.111');
$bigFloat2 = new BigFloat('654321.22');
$bigFloat1->add($bigFloat2)
echo $bigFloat1; // "777777.331"

// BigInteger Subtraction
$bigInt3 = new BigInt('777777');
$bigInt4 = new BigInt('654321');
$bigInt3->sub($bigInt4);
echo $bigInt3; // "123456"

// BigFloat Subtraction
$bigFloat3 = new BigFloat('123456.111');
$bigFloat4 = new BigFloat('654321.22');
$bigFloat3->sub($bigFloat4);
echo $bigFloat3; // results "530865.109"

// BigInteger Division
$bigInt5 = new BigInt('777777');
$bigInt6 = new BigInt('654321');
$bigInt5->div($bigInt6);
echo $bigInt5; // "1"

// BigFloat Division
$bigFloat5 = new BigFloat('123456.111');
$bigFloat6 = new BigFloat('654321.22');
$bigFloat5->div($bigFloat6);
echo $bigFloat5; // "0.188678"

// BigInteger Multiplication
$bigInt7 = new BigInt('777777');
$bigInt8 = new BigInt('654321');
$bigInt7->multiply($bigInt8);
echo $bigInt7; // "508915824417"

// BigFloat Multiplication
$bigFloat7 = new BigFloat('123456.111');
$bigFloat8 = new BigFloat('654321.22');
$bigFloat7->multiply($bigFloat8);
echo $bigFloat7; // "80779953165.97542"

// BigInteger Modulo
$bigInt9 = new BigInt('777777');
$bigInt10 = new BigInt('654321');
$bigInt9->mod($bigInt10);
echo $bigInt9; // "123456"

// BigInteger Power
$bigInt11 = new BigInt('777777');
$bigInt12 = new BigInt('1');
$bigInt11->pow($bigInt12);
echo $bigInt11; // "777777"

// BigInteger Square Root
$bigInt13 = new BigInt('10000');
$bigInt13->sqrt();
echo $bigInt13; // "100"

// BigFloat Square Root
$bigFloat9 = new BigFloat('2');
$bigFloat9->sqrt(7);
echo $bigFloat9; // "1.4142136"

// BigInteger Lesser-Than
$bigInt14 = new BigInt('1234567890');
$bigInt15 = new BigInt('1234567891');
echo $bigInt14->isLesserThan($bigInt15); // True

$bigInt16 = new BigInt('1234567891');
$bigInt17 = new BigInt('1234567891');
echo $bigInt16->isLesserThan($bigInt17); // False

// BigInteger Bigger-Than
$bigInt18 = new BigInt('1234567891');
$bigInt19 = new BigInt('1234567890');
echo $bigInt18->isBiggerThan($bigInt19); // True

$bigInt21 = new BigInt('1234567891');
$bigInt22 = new BigInt('1234567891');
echo $bigInt21->isBiggerThan($bigInt22); // False

```

## Roadmap
The goal of this project is making a complete Bignum library for PHP language, so operations other than the ones mentioned in the table should be added too (trigonometric functions, ...).

## Contribution
Any contribution in the form of an issue or a pull request is more than welcome! Also if you have any questions, feel free to create a new issue or comment on existing ones.

