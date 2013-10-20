<?php
namespace Icecave\Parity;

use Phake;
use PHPUnit_Framework_TestCase;

class AbstractExtendedComparableTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparable = Phake::partialMock(__NAMESPACE__ . '\AbstractExtendedComparable');

        $this->less = 'less';
        $this->same = 'same';
        $this->more = 'more';

        Phake::when($this->comparable)
            ->compare($this->less)
            ->thenReturn(100);

        Phake::when($this->comparable)
            ->compare($this->same)
            ->thenReturn(0);

        Phake::when($this->comparable)
            ->compare($this->more)
            ->thenReturn(-100);
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->comparable->isEqualTo($this->less));
        $this->assertTrue($this->comparable->isEqualTo($this->same));
        $this->assertFalse($this->comparable->isEqualTo($this->more));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->comparable->isNotEqualTo($this->less));
        $this->assertFalse($this->comparable->isNotEqualTo($this->same));
        $this->assertTrue($this->comparable->isNotEqualTo($this->more));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->comparable->isLessThan($this->less));
        $this->assertFalse($this->comparable->isLessThan($this->same));
        $this->assertTrue($this->comparable->isLessThan($this->more));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->comparable->isGreaterThan($this->less));
        $this->assertFalse($this->comparable->isGreaterThan($this->same));
        $this->assertFalse($this->comparable->isGreaterThan($this->more));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->comparable->isLessThanOrEqualTo($this->less));
        $this->assertTrue($this->comparable->isLessThanOrEqualTo($this->same));
        $this->assertTrue($this->comparable->isLessThanOrEqualTo($this->more));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->comparable->isGreaterThanOrEqualTo($this->less));
        $this->assertTrue($this->comparable->isGreaterThanOrEqualTo($this->same));
        $this->assertFalse($this->comparable->isGreaterThanOrEqualTo($this->more));
    }
}
