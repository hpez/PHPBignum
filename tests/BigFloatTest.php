<?php

namespace hpez\tests;

use hpez\bignum\BigFloat;
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

    public function testSubWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals(
            new BigFloat('530865.109'),
            $bigFloat2->sub($bigFloat1)
        );
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

    public function testDivWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals(
            new BigFloat('0.188678'),
            $bigFloat1->div($bigFloat2)
        );
    }

    public function testDivWorks2(): void
    {
        $bigFloat1 = new BigFloat('9');
        $bigFloat2 = new BigFloat('3.00001');
        $this->assertEquals(
            new BigFloat('2.999990'),
            $bigFloat1->div($bigFloat2)
        );
    }

    public function testDivWorks3(): void
    {
        $bigFloat1 = new BigFloat('0.000552');
        $bigFloat2 = new BigFloat('6.000184');
        $this->assertEquals(
            new BigFloat('0.000092'),
            $bigFloat1->
            div($bigFloat2)
        );
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
}