<?php
namespace Icecave\Parity\Comparator;

use PHPUnit_Framework_TestCase;

class DeepComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = new DeepComparator;
    }

    public function testDefaultCompareBasic()
    {
        $this->assertLessThan(0, $this->comparator->compare(-1, 0));
        $this->assertSame(0, $this->comparator->compare(0, 0));
        $this->assertGreaterThan(0, $this->comparator->compare(1, 0));
    }
}
