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

    public function testIsLesserThanWorks(): void
    {
        $this->assertTrue((new BigInt('1234567890'))->isLesserThan(new BigInt('1234567891')));
        $this->assertTrue((new BigInt('1234567891'))->isLesserThan(new BigInt('12345678900')));
        $this->assertNotTrue((new BigInt('1234567891'))->isLesserThan(new BigInt('1234567891')));
        $this->assertNotTrue((new BigInt('1234567891'))->isLesserThan(new BigInt('1234567890')));
    }

    public function testIsBiggerThanWorks(): void
    {
        $this->assertTrue((new BigInt('1234567891'))->isBiggerThan(new BigInt('1234567890')));
        $this->assertTrue((new BigInt('12345678900'))->isBiggerThan(new BigInt('1234567891')));
        $this->assertNotTrue((new BigInt('1234567891'))->isBiggerThan(new BigInt('1234567891')));
        $this->assertNotTrue((new BigInt('1234567890'))->isBiggerThan(new BigInt('1234567891')));
    }

    public function testAddWorks(): void
    {
        $bigInt1 = new BigInt('123456');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->add($bigInt2), new BigInt('777777'));
    }
}