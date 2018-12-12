<?php

namespace hpez\Tests;

require __DIR__.'/../src/BigInt.php';

use hpez\BigNum\BigInt;
use PHPUnit\Framework\TestCase;

class BigIntTest extends TestCase
{
    public function testCanBeCreatedFromString(): void
    {
        $this->assertInstanceOf(BigInt::class, new BigInt('12345678901234567890'));
    }
}