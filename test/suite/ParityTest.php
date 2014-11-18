<?php
namespace Icecave\Parity;

use PHPUnit_Framework_TestCase;

class ParityTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->value = 0;
        $this->less  = -1;
        $this->same  = 0;
        $this->more  = 1;
    }

    public function testCompare()
    {
        $this->assertGreaterThan(0, Parity::compare($this->value, $this->less));
        $this->assertSame(0, Parity::compare($this->value, $this->same));
        $this->assertLessThan(0, Parity::compare($this->value, $this->more));
    }

    public function testIsEqualTo()
    {
        $this->assertFalse(Parity::isEqualTo($this->value, $this->less));
        $this->assertTrue(Parity::isEqualTo($this->value, $this->same));
        $this->assertFalse(Parity::isEqualTo($this->value, $this->more));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue(Parity::isNotEqualTo($this->value, $this->less));
        $this->assertFalse(Parity::isNotEqualTo($this->value, $this->same));
        $this->assertTrue(Parity::isNotEqualTo($this->value, $this->more));
    }

    public function testIsLessThan()
    {
        $this->assertFalse(Parity::isLessThan($this->value, $this->less));
        $this->assertFalse(Parity::isLessThan($this->value, $this->same));
        $this->assertTrue(Parity::isLessThan($this->value, $this->more));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue(Parity::isGreaterThan($this->value, $this->less));
        $this->assertFalse(Parity::isGreaterThan($this->value, $this->same));
        $this->assertFalse(Parity::isGreaterThan($this->value, $this->more));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse(Parity::isLessThanOrEqualTo($this->value, $this->less));
        $this->assertTrue(Parity::isLessThanOrEqualTo($this->value, $this->same));
        $this->assertTrue(Parity::isLessThanOrEqualTo($this->value, $this->more));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue(Parity::isGreaterThanOrEqualTo($this->value, $this->less));
        $this->assertTrue(Parity::isGreaterThanOrEqualTo($this->value, $this->same));
        $this->assertFalse(Parity::isGreaterThanOrEqualTo($this->value, $this->more));
    }

    public function testMin()
    {
        $this->assertSame($this->less, Parity::min($this->value, $this->less));
        $this->assertSame($this->less, Parity::min($this->less, $this->value));
        $this->assertSame($this->less, Parity::min($this->value, $this->same, $this->less, $this->more));
    }

    public function testMax()
    {
        $this->assertSame($this->more, Parity::max($this->value, $this->more));
        $this->assertSame($this->more, Parity::max($this->more, $this->value));
        $this->assertSame($this->more, Parity::max($this->value, $this->same, $this->less, $this->more));
    }

    public function testMinSequenceDefault()
    {
        $this->assertNull(
            Parity::minSequence(
                array(),
                null
            )
        );

        $this->assertSame(
            $this->value,
            Parity::minSequence(
                array(),
                $this->value
            )
        );

        $this->assertSame(
            $this->value,
            Parity::minSequence(
                array($this->value),
                $this->value
            )
        );

        $this->assertSame(
            $this->less,
            Parity::minSequence(
                array($this->value),
                $this->less
            )
        );

        $this->assertSame(
            $this->value,
            Parity::minSequence(
                array(null),
                $this->value
            )
        );
    }

    public function testMaxSequenceDefault()
    {
        $this->assertNull(
            Parity::maxSequence(
                array(),
                null
            )
        );

        $this->assertSame(
            $this->value,
            Parity::maxSequence(
                array(),
                $this->value
            )
        );

        $this->assertSame(
            $this->value,
            Parity::maxSequence(
                array($this->value),
                $this->value
            )
        );

        $this->assertSame(
            $this->more,
            Parity::maxSequence(
                array($this->value),
                $this->more
            )
        );

        $this->assertSame(
            $this->value,
            Parity::maxSequence(
                array(null),
                $this->value
            )
        );
    }

    public function testMinSequence()
    {
        $sequence = array(
            $this->value,
            null,
            $this->less,
            $this->same,
            $this->more,
        );

        $this->assertSame(
            $this->less,
            Parity::minSequence(
                $sequence
            )
        );
    }

    public function testMaxSequence()
    {
        $sequence = array(
            $this->value,
            null,
            $this->less,
            $this->same,
            $this->more,
        );

        $this->assertSame(
            $this->more,
            Parity::maxSequence(
                $sequence
            )
        );
    }

    public function testComparitor()
    {
        $comparator = Parity::comparator();
        $this->assertInstanceOf(__NAMESPACE__ . '\Comparator\ParityComparator', $comparator);

        $comparator = $comparator->fallbackComparator();
        $this->assertInstanceOf(__NAMESPACE__ . '\Comparator\DeepComparator', $comparator);

        $comparator = $comparator->fallbackComparator();
        $this->assertInstanceOf(__NAMESPACE__ . '\Comparator\StrictPhpComparator', $comparator);
    }
}
