<?php

namespace TDD\Test;

require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase
{

    public $Receipt;

    public function setUp()
    {
        $this->Receipt = new Receipt();
    }

    public function tearDown()
    {
        unset($this->Receipt);
    }

    /**
     * @dataProvider provideSubTotal
     */
    public function testSubTotal($items, $expected)
    {
        $output = $this->Receipt->subTotal($items, null);
        $this->assertEquals(
            $expected,
            $output,
            "When summing the subTotal should equal {$expected}"
        );
    }

    public function provideSubTotal()
    {
        return [
            [[2, 3, 4], 9],
            [[2, 3, 5], 10],
            [[-2, 3, 4], 5],
        ];
    }

    public function testSubTotalAndCoupun()
    {
        $input = [0, 2, 5, 8];
        $coupun = 0.20;
        $output = $this->Receipt->subTotal($input, $coupun);
        $this->assertEquals(
            12,
            $output,
            'When summing the subTotal should equal 15'
        );
    }
    public function testSubTotalAndCoupunException()
    {
        $input = [0, 2, 5, 8];
        $coupun = 1.20;
        $this->expectException('BadMethodCallException');
        $this->Receipt->subTotal($input, $coupun);
    }

    public function testTax()
    {
        $inputAmount = 10.00;
        $this->Receipt->tax = 0.10;
        $output = $this->Receipt->tax($inputAmount);
        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
        );
    }

    public function testPostTaxSubTotal()
    {

        $item = [1, 2, 5, 8];
        $this->Receipt->tax = 0.20;

        $coupun = null;
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax', 'subTotal'])
            ->getMock();
        $Receipt->expects($this->once())->method('tax')->with(10)->willReturn(1.0);
        $Receipt->expects($this->once())->method('subTotal')->with($item, $coupun)->willReturn(10.00);
        $return = $Receipt->postTaxSubTotal([1, 2, 5, 8], null);
        $this->assertEquals(
            11.00,
            $return
        );
    }


    /**
     * @dataProvider provideCurrencyAmt
     */
    public function testCurrencyAmt($expected, $input, $msg)
    {
        $this->assertSame(
            $expected,
            $this->Receipt->currencyAmt($input),
            $msg
        );
    }

    public function provideCurrencyAmt()
    {
        return [
            [1.00, 1, "should be 1.00"],
            [1.11, 1.111, "should be 1.11"],
            [1.22, 1.22222, "should be 1.22"]
        ];
    }
}
