<?php

namespace hpez\Tests;

require_once __DIR__.'/../vendor/autoload.php';

use hpez\bignum\BigInt;
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

    public function testSubWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->sub($bigInt2), new BigInt('123456'));
    }

    public function testDivWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->div($bigInt2), new BigInt('1'));
    }

    public function testModWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->mod($bigInt2), new BigInt('123456'));
    }

    public function testMultiplyWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->multiply($bigInt2), new BigInt('508915824417'));
    }

    public function testPowWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('1');
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('777777'));
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('2');
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('604937061729'));
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt(3);
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('470506133060396433'));
    }
}