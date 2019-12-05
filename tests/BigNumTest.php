<?php

namespace hpez\Tests;

require_once __DIR__.'/../vendor/autoload.php';

use hpez\bignum\BigInt;
use hpez\bignum\BigFloat;
use PHPUnit\Framework\TestCase;

class BigNumTest extends TestCase
{
	public function testToStringWorks()
	{
		$bigInt1 = new BigInt('123456');
		$bigFloat1 = new BigFloat('123456.111');

        $this->assertEquals('123456', $bigInt1);
        $this->assertEquals('123456.111', $bigFloat1);
	}
}