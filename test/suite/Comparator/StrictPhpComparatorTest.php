<?php

namespace Icecave\Parity\Comparator;

use DateTime;
use PHPUnit\Framework\TestCase;
use stdClass;

class StrictPhpComparatorTest extends TestCase
{
    public function setUp(): void
    {
        $this->comparator = new StrictPhpComparator();
    }

    public function testCompare()
    {
        $this->assertLessThan(0, $this->comparator->compare(10, 20));
        $this->assertGreaterThan(0, $this->comparator->compare(20, 10));
        $this->assertSame(0, $this->comparator->compare(10, 10));
    }

    public function testCompareWithoutRelaxedNumericComparisons()
    {
        $this->comparator = new StrictPhpComparator(false);

        $this->assertGreaterThan(0, $this->comparator->compare(1, 2.5));
        $this->assertLessThan(0, $this->comparator->compare(2.5, 3));
        $this->assertGreaterThan(0, $this->comparator->compare(1, 1.0));
    }

    public function testCompareRelaxedNumericComparisons()
    {
        $this->assertLessThan(0, $this->comparator->compare(1, 2.5));
        $this->assertLessThan(0, $this->comparator->compare(2.5, 3));
        $this->assertSame(0, $this->comparator->compare(1, 1.0));
    }

    public function testCompareWithObjects()
    {
        $this->assertSame(0, $this->comparator->compare(new stdClass(), new stdClass()));
        $this->assertGreaterThan(0, $this->comparator->compare(new stdClass(), new DateTime()));
    }

    public function testInvoke()
    {
        $this->assertLessThan(0, call_user_func($this->comparator, 10, 20));
        $this->assertGreaterThan(0, call_user_func($this->comparator, 20, 10));
        $this->assertSame(0, call_user_func($this->comparator, 10, 10));
    }
}
