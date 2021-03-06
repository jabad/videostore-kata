<?php

namespace Tests\Webflix\Domain\Model\BasicType\Money;

use PHPUnit\Framework\TestCase;
use Webflix\Domain\Model\BasicType\Money\Currency;
use Webflix\Domain\Model\BasicType\Money\InvalidArgumentException;

/**
 * @coversDefaultClass Webflix\Domain\Model\BasicType\Money\Currency
 * @uses Webflix\Domain\Model\BasicType\Money\Currency
 * @uses Webflix\Domain\Model\BasicType\Money\Money
 */
final class CurrencyTest extends TestCase
{
    /**
     * @covers ::fromCode
     */
    public function testConstructor()
    {
        $currency = Currency::fromCode('EUR');

        $this->assertEquals('EUR', $currency->code());
    }

    /**
     * @covers ::code
     * @covers ::__toString
     */
    public function testCode()
    {
        $currency = Currency::fromCode('EUR');
        $this->assertEquals('EUR', $currency->code());
        $this->assertEquals('EUR', (string) $currency);
    }

    /**
     * @covers ::equals
     */
    public function testDifferentInstancesAreEqual()
    {
        $c1 = Currency::fromCode('EUR');
        $c2 = Currency::fromCode('EUR');
        $c3 = Currency::fromCode('USD');
        $c4 = Currency::fromCode('USD');
        $this->assertTrue($c1->equals($c2));
        $this->assertTrue($c3->equals($c4));
    }

    /**
     * @covers ::equals
     */
    public function testDifferentCurrenciesAreNotEqual()
    {
        $c1 = Currency::fromCode('EUR');
        $c2 = Currency::fromCode('USD');
        $this->assertFalse($c1->equals($c2));
    }

    /**
     * @covers ::equals
     */
    public function testToUpper()
    {
        $c1 = Currency::fromCode('EUR');
        $c2 = Currency::fromCode('eur');
        $this->assertTrue($c1->equals($c2));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNonStringCode()
    {
        Currency::fromCode(1234);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testNon3LetterCode()
    {
        Currency::fromCode('FooBar');
    }
}
