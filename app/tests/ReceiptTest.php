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
     * @dataProvider provideTotal
     */
    public function testTotal($items, $expected)
    {
        $output = $this->Receipt->total($items, null);
        $this->assertEquals(
            $expected,
            $output,
            "When summing the total should equal {$expected}"
        );
    }

    public function provideTotal()
    {
        return [
            [[2, 3, 4], 9],
            [[2, 3, 5], 10],
            [[-2, 3, 4], 5],
        ];
    }

    public function testTotalAndCoupun()
    {
        $input = [0, 2, 5, 8];
        $coupun = 0.20;
        $output = $this->Receipt->total($input, $coupun);
        $this->assertEquals(
            12,
            $output,
            'When summing the total should equal 15'
        );
    }
    public function testTotalAndCoupunException()
    {
        $input = [0, 2, 5, 8];
        $coupun = 1.20;
        $this->expectException('BadMethodCallException');
        $this->Receipt->total($input, $coupun);
    }

    public function testTax()
    {
        $inputAmount = 10.00;
        $taxInput = 0.10;
        $output = $this->Receipt->tax($inputAmount, $taxInput);
        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
        );
    }

    public function testPostTaxTotal()
    {

        $item = [1, 2, 5, 8];
        $tax =  0.20;
        $coupun = null;
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax', 'total'])
            ->getMock();
        $Receipt->expects($this->once())->method('tax')->with(10, $tax)->willReturn(1.0);
        $Receipt->expects($this->once())->method('total')->with($item, $coupun)->willReturn(10.00);
        $return = $Receipt->postTaxTotal([1, 2, 5, 8], 0.20, null);
        $this->assertEquals(
            11.00,
            $return
        );
    }
}
