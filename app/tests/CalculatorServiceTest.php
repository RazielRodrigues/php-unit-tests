<?php

declare(strict_types=1);

namespace TDD\tests;

use TDD\CalculatorService;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class CalculatorServiceTest extends TestCase
{

    static function sumProvider() {
        yield [10, 10, 20];
        yield [1, 1, 2];
        yield [2, 2, 4];
    }

    #[Test]
    #[DataProvider('sumProvider')]
    function testSum($x, $y, $expected) {
        $service = new CalculatorService();
        $this->assertSame(
            $service->sum($x,$y),
            $expected
        );
    }

    #[Test]
    function testDivision() {
        $service = new CalculatorService();
        $this->assertEquals(
            $service->division(10,10),
            1
        );
    }

    #[Test]
    function testDivisionException() {
        $this->expectException(\Exception::class);

        $service = new CalculatorService();
        $this->assertSame(
            $service->division(0,10),
            1
        );
    }

    #[Test]
    function testDivisionExceptionInvalid() {
        $this->markTestIncomplete('...');
    }

}
