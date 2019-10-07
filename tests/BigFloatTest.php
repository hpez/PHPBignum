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
        
        $bigFloat1 = new BigFloat('1378217817817842.121438218481312');
        $bigFloat2 = new BigFloat('8139829181.42424124');
        $this->assertEquals($bigFloat1->add($bigFloat2), new BigFloat('1378225957647023.545679458481312'));
        
        $bigFloat1 = new BigFloat('8139829181.42424124');
        $bigFloat2 = new BigFloat('1378217817817842.121438218481312');
        $this->assertEquals($bigFloat1->add($bigFloat2), new BigFloat('1378225957647023.545679458481312'));
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

    public function testDivWorks(): void
    {
        $bigFloat1 = new BigFloat('123456.111');
        $bigFloat2 = new BigFloat('654321.22');
        $this->assertEquals($bigFloat1->div($bigFloat2), new BigFloat('0.188678'));
    }
}