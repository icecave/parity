<?php
namespace Icecave\Parity\Comparator;

use Phake;
use PHPUnit_Framework_TestCase;

class AbstractComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = Phake::partialMock(__NAMESPACE__ . '\AbstractComparator');

        $this->value = 'same';
        $this->less  = 'less';
        $this->same  = 'same';
        $this->more  = 'more';

        Phake::when($this->comparator)
            ->compare($this->value, $this->less)
            ->thenReturn(100);

        Phake::when($this->comparator)
            ->compare($this->value, $this->same)
            ->thenReturn(0);

        Phake::when($this->comparator)
            ->compare($this->value, $this->more)
            ->thenReturn(-100);
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->comparator->isEqualTo($this->value, $this->less));
        $this->assertTrue($this->comparator->isEqualTo($this->value, $this->same));
        $this->assertFalse($this->comparator->isEqualTo($this->value, $this->more));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->comparator->isNotEqualTo($this->value, $this->less));
        $this->assertFalse($this->comparator->isNotEqualTo($this->value, $this->same));
        $this->assertTrue($this->comparator->isNotEqualTo($this->value, $this->more));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->comparator->isLessThan($this->value, $this->less));
        $this->assertFalse($this->comparator->isLessThan($this->value, $this->same));
        $this->assertTrue($this->comparator->isLessThan($this->value, $this->more));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->comparator->isGreaterThan($this->value, $this->less));
        $this->assertFalse($this->comparator->isGreaterThan($this->value, $this->same));
        $this->assertFalse($this->comparator->isGreaterThan($this->value, $this->more));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->comparator->isLessThanOrEqualTo($this->value, $this->less));
        $this->assertTrue($this->comparator->isLessThanOrEqualTo($this->value, $this->same));
        $this->assertTrue($this->comparator->isLessThanOrEqualTo($this->value, $this->more));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->comparator->isGreaterThanOrEqualTo($this->value, $this->less));
        $this->assertTrue($this->comparator->isGreaterThanOrEqualTo($this->value, $this->same));
        $this->assertFalse($this->comparator->isGreaterThanOrEqualTo($this->value, $this->more));
    }
}
