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
        $this->assertNotTrue((new BigInt('1234567891123131'))->isLesserThan(new BigInt('1234567890122')));
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
        
        $bigInt1 = new BigInt('2183912839129019129031231104291489123');
        $bigInt2 = new BigInt('291898938518278437284372874271783789422432839251938498123');
        $this->assertEquals($bigInt1->add($bigInt2), new BigInt('291898938518278437286556787110912808551464070356229987246'));

        $bigInt1 = new BigInt('291898938518278437284372874271783789422432839251938498123');
        $bigInt2 = new BigInt('2183912839129019129031231104291489123');
        $this->assertEquals($bigInt1->add($bigInt2), new BigInt('291898938518278437286556787110912808551464070356229987246'));
    }

    public function testSubWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->sub($bigInt2), new BigInt('123456'));
        
        $bigInt1 = new BigInt('291898938518278437284372874271783789422432839251938498123');
        $bigInt2 = new BigInt('2183912839129019129031231104291489123');
        $this->assertEquals($bigInt1->sub($bigInt2), new BigInt('291898938518278437282188961432654770293401608147647009000'));
    }

    public function testDivWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->div($bigInt2), new BigInt('1'));
        
        $bigInt1 = new BigInt('123');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->div($bigInt2), new BigInt('0'));
        
        $bigInt1 = new BigInt('291898938518278437284372874271783789422432839251938498123');
        $bigInt2 = new BigInt('2183912839129019129031231104291489123');
        $this->assertEquals($bigInt1->div($bigInt2), new BigInt('133658694288684434516'));
    }

    public function testModWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->mod($bigInt2), new BigInt('123456'));

        $bigInt1 = new BigInt('291898938518278437284372874271783789422432839251938498123');
        $bigInt2 = new BigInt('2183912839129019129031231104291489123');
        $this->assertEquals($bigInt1->mod($bigInt2), new BigInt('848074429877767681348718947118728655'));

        $bigInt1 = new BigInt('2183912839129019129031231104291489123');
        $bigInt2 = new BigInt('291898938518278437284372874271783789422432839251938498123');
        $this->assertEquals($bigInt1->mod($bigInt2), new BigInt('2183912839129019129031231104291489123'));
    }

    public function testMultiplyWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('654321');
        $this->assertEquals($bigInt1->multiply($bigInt2), new BigInt('508915824417'));
        
        $bigInt1 = new BigInt('1293489314951253929432143');
        $bigInt2 = new BigInt('1293489314951253929432143');
        $this->assertEquals($bigInt1->multiply($bigInt2), new BigInt('1673114607893064182146858155499896494466441572449'));
        
        $bigInt1 = new BigInt('848074429877767681348718947118728655');
        $bigInt2 = new BigInt('2183912839129019129031231104291489123');
        $this->assertEquals($bigInt1->multiply($bigInt2), new BigInt('1852120635947079864253215608493572572382593175993758553041206712520919565'));
    }

    public function testPowWorks(): void
    {
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('0');
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt(1));

        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('1');
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('777777'));
        
        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt('2');
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('604937061729'));

        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt(3);
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('470506133060396433'));

        $bigInt1 = new BigInt('777777');
        $bigInt2 = new BigInt(4);
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('365948848653315956469441'));
        
        $bigInt1 = new BigInt(17);
        $bigInt2 = new BigInt('25');
        $this->assertEquals($bigInt1->pow($bigInt2), new BigInt('5770627412348402378939569991057'));
    }
    

    public function testSqrtWorks(): void
    {
        $bigInt1 = new BigInt(0);
        $this->assertEquals($bigInt1->sqrt(), new BigInt('0'));
        
        $bigInt1 = new BigInt('1');
        $this->assertEquals($bigInt1->sqrt(), new BigInt(1));

        $bigInt1 = new BigInt('64');
        $this->assertEquals($bigInt1->sqrt(), new BigInt('8'));
        
        $bigInt1 = new BigInt('10000');
        $this->assertEquals($bigInt1->sqrt(), new BigInt('100'));
        
        $bigInt1 = new BigInt('45436982671906576');
        $this->assertEquals($bigInt1->sqrt(), new BigInt('213159524'));
        
        $bigInt1 = new BigInt('45436982671909999');
        $this->assertEquals($bigInt1->sqrt(), new BigInt('213159524'));
        
        $bigInt1 = new BigInt('1673114607893064182146858155499896494466441572449');
        $this->assertEquals($bigInt1->sqrt(), new BigInt('1293489314951253929432143'));
        
        $bigInt1 = new BigInt('1673114607893064182146858155499896494999999999999');
        $this->assertEquals($bigInt1->sqrt(), new BigInt('1293489314951253929432143'));
        
        $bigInt1 = new BigInt('125565743411314940280117058839559235348721155386037390522297885292681173306025');
        $this->assertEquals($bigInt1->sqrt(), new BigInt('354352569358985938593895384925823985395'));
    }
}