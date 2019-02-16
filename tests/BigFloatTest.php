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
        $this->assertEquals($bigFloat1->add($bigFloat2), new BigFloat('777777.331'));
    }

    public function testSubWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals($bigFloat2->sub($bigFloat1), new BigFloat('530865.109'));
    }

    public function testMultiplyWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals($bigFloat1->multiply($bigFloat2), new BigFloat('80779953165.97542'));
    }
}