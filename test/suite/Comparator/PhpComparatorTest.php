<?php

namespace Icecave\Parity\Comparator;

use PHPUnit\Framework\TestCase;

class PhpComparatorTest extends TestCase
{
    public function setUp(): void
    {
        $this->comparator = new PhpComparator();
    }

    public function testCompare()
    {
        $this->assertLessThan(0, $this->comparator->compare(10, 20));
        $this->assertGreaterThan(0, $this->comparator->compare(20, 10));
        $this->assertSame(0, $this->comparator->compare(10, 10));
    }

    public function testInvoke()
    {
        $this->assertLessThan(0, call_user_func($this->comparator, 10, 20));
        $this->assertGreaterThan(0, call_user_func($this->comparator, 20, 10));
        $this->assertSame(0, call_user_func($this->comparator, 10, 10));
    }
}
