<?php
namespace Icecave\Parity\Comparator;

use PHPUnit_Framework_TestCase;

class ComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = new Comparator;
    }

    public function testDefaultCompare()
    {
        $this->assertSame(0, $this->comparator->compare(0, 0));
        $this->assertLessThan(0, $this->comparator->compare(-1, 0));
        $this->assertGreaterThan(0, $this->comparator->compare(1, 0));
    }
}
