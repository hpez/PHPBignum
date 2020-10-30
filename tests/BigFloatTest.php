<?php

namespace hpez\tests;

use hpez\bignum\BigFloat;
use hpez\bignum\BigInt;
use PHPUnit\Framework\TestCase;

require_once __DIR__.'/../vendor/autoload.php';

class BigFloatTest extends TestCase
{
    public function testAddWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals(
            new BigFloat('777777.331'),
            $bigFloat1->add($bigFloat2)
        );

        $bigFloat1 = new BigFloat('1378217817817842.121438218481312');
        $bigFloat2 = new BigFloat('8139829181.42424124');
        $this->assertEquals(
            new BigFloat('1378225957647023.545679458481312'),
            $bigFloat1->add($bigFloat2)
        );

        $bigFloat1 = new BigFloat('8139829181.42424124');
        $bigFloat2 = new BigFloat('1378217817817842.121438218481312');
        $this->assertEquals(
            new BigFloat('1378225957647023.545679458481312'),
            $bigFloat1->add($bigFloat2)
        );
    }

    public function testAddDouble(): void
    {
        $bigFloat = new BigFloat('1.1');
        $this->assertEquals(new BigFloat('1.2'), $bigFloat->add(0.1));
    }

    public function testSubWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals(
            new BigFloat('530865.109'),
            $bigFloat2->sub($bigFloat1)
        );
    }

    public function testSubDouble(): void
    {
        $bigFloat = new BigFloat('1.2');
        $this->assertEquals(new BigFloat('1.1'), $bigFloat->sub(0.1));
    }

    public function testSubWorks2(): void
    {
        $bigFloat1 = new BigFloat('9');
        $bigFloat2 = new BigFloat('3.00001');
        $this->assertEquals(
            new BigFloat('5.99999'),
            $bigFloat1->sub($bigFloat2)
        );
    }

    public function testMultiplyWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals(
            new BigFloat('80779953165.97542'),
            $bigFloat1->multiply($bigFloat2)
        );
    }

    /**
     * @dataProvider divisionDataProvider
     */
    public function testDivWorks(string $numerator, string $denominator, string $expected): void
    {
        $bigFloat1 = new BigFloat($numerator);
        $bigFloat2 = new BigFloat($denominator);
        $this->assertEquals(
            new BigFloat($expected),
            $bigFloat1->div($bigFloat2)
        );
    }

    public function testDivDouble(): void
    {
        $bigFloat = new BigFloat('10');
        $this->assertEquals(new BigFloat('100.000000'), $bigFloat->div(0.1));
    }

    public function testAddWithLongerLengthResult(): void
    {
        $bigFloat = new BigFloat('9.0');
        $this->assertEquals(new BigFloat('18.0'), $bigFloat->add(9));
    }

    public function testSqrt(): void
    {
        $bigFloat = new BigFloat('9');
        $this->assertEquals(
            new BigFloat('3.000000'),
            $bigFloat->sqrt()
        );
    }

    public function testSqrt2(): void
    {
        $bigFloat = new BigFloat('2');
        $this->assertEquals(
            new BigFloat('1.4142136'),
            $bigFloat->sqrt(7)
        );
    }

    public function testPowWorks() : void
    {
        $bigFloat1 = new BigFloat('1.2');
        $bigInt1 = new BigInt('3');
        $this->assertEquals(new BigFloat('1.728'), $bigFloat1->pow($bigInt1));

        $bigFloat2 = new BigFloat('.2');
        $bigInt2 = new BigInt('3');
        $this->assertEquals(new BigFloat('0.008'), $bigFloat2->pow($bigInt2));

        $bigFloat3 = new BigFloat('.002');
        $bigInt3 = new BigInt('3');
        $this->assertEquals(new BigFloat('0.000000008'), $bigFloat3->pow($bigInt3));

        $bigFloat4 = new BigFloat('12345.12345');
        $bigInt4 = new BigInt('3');
        $this->assertEquals(new BigFloat('1881422405168.320420453463625'), $bigFloat4->pow($bigInt4));

        $bigFloat5 = new BigFloat('123456789.123456789');
        $bigInt5 = new BigInt('3');
        $this->assertEquals(new BigFloat('1881676377434183981909562.699940347954480361860897069'), $bigFloat5->pow($bigInt5));

        $bigFloat6 = new BigFloat('1.23');
        $this->assertEquals(new BigFloat('1.860867'), $bigFloat6->pow(3));
    }

    public function divisionDataProvider(): array
    {
        // Numerator, Denominator, Expected result
        return [
            ['123456.111', '654321.22', '0.188678'],
            ['9', '3.00001', '2.999990'],
            ['0.000552', '6.000184', '0.000092'],
            ['3.1415926535898', '180', '0.0174532'],
        ];
    }
}
