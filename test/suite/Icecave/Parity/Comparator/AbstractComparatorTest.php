<?php
namespace Icecave\Parity\Comparator;

use Phake;
use PHPUnit_Framework_TestCase;

class AbstractComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = Phake::partialMock(__NAMESPACE__ . '\AbstractComparator');

        Phake::when($this->comparator)
            ->defaultCompare(Phake::anyParameters())
            ->thenReturn(1010);

        $this->comparable = Phake::mock('Icecave\Parity\ComparableInterface');

        Phake::when($this->comparable)
            ->compare(Phake::anyParameters())
            ->thenReturn(2020);

        $this->restricted = Phake::mock('Icecave\Parity\RegularRestrictedComparableInterface');

        Phake::when($this->restricted)
            ->canCompare(Phake::anyParameters())
            ->thenReturn(true);

        Phake::when($this->restricted)
            ->compare(Phake::anyParameters())
            ->thenReturn(3030);

        $this->delegating = Phake::mock('Icecave\Parity\DelegatingComparableInterface');

        Phake::when($this->delegating)
            ->delegatingCompare(Phake::anyParameters())
            ->thenReturn(4040);

        $this->delegatingRestricted = Phake::mock('Icecave\Parity\DelegatingRestrictedComparableInterface');

        Phake::when($this->delegatingRestricted)
            ->canCompare(Phake::anyParameters())
            ->thenReturn(true);

        Phake::when($this->delegatingRestricted)
            ->delegatingCompare(Phake::anyParameters())
            ->thenReturn(5050);
    }

    public function testDefaultCompare()
    {
        $result = $this->comparator->compare('lhs', 'rhs');
        Phake::verify($this->comparator)->defaultCompare('lhs', 'rhs');
        $this->assertSame(1010, $result);
    }

    public function testCompareWithLHSComparable()
    {
        $result = $this->comparator->compare($this->comparable, 'rhs');
        Phake::verify($this->comparable)->compare('rhs');
        $this->assertSame(2020, $result);
    }

    public function testCompareWithLHSRestrictedComparable()
    {
        $result = $this->comparator->compare($this->restricted, 'rhs');
        Phake::inOrder(
            Phake::verify($this->restricted)->canCompare('rhs'),
            Phake::verify($this->restricted)->compare('rhs')
        );
        $this->assertSame(3030, $result);
    }

    public function testCompareWithLHSRestrictedComparableCanNotCompare()
    {
        Phake::when($this->restricted)
            ->canCompare(Phake::anyParameters())
            ->thenReturn(false);

        $result = $this->comparator->compare($this->restricted, 'rhs');
        Phake::inOrder(
            Phake::verify($this->restricted)->canCompare('rhs'),
            Phake::verify($this->comparator)->defaultCompare($this->restricted, 'rhs')
        );
        Phake::verify($this->restricted, Phake::never())->compare(Phake::anyParameters());
        $this->assertSame(1010, $result);
    }

    public function testCompareWithLHSDelegatingComparable()
    {
        $result = $this->comparator->compare($this->delegating, 'rhs');
        Phake::verify($this->delegating)->delegatingCompare('rhs', $this->comparator);
        $this->assertSame(4040, $result);
    }

    public function testCompareWithLHSDelegatingRestrictedComparable()
    {
        $result = $this->comparator->compare($this->delegatingRestricted, 'rhs');
        Phake::inOrder(
            Phake::verify($this->delegatingRestricted)->canCompare('rhs'),
            Phake::verify($this->delegatingRestricted)->delegatingCompare('rhs', $this->comparator)
        );
        $this->assertSame(5050, $result);
    }

    public function testCompareWithLHSDelegatingRestrictedComparableCanNotCompare()
    {
        Phake::when($this->delegatingRestricted)
            ->canCompare(Phake::anyParameters())
            ->thenReturn(false);

        $result = $this->comparator->compare($this->delegatingRestricted, 'rhs');
        Phake::inOrder(
            Phake::verify($this->delegatingRestricted)->canCompare('rhs'),
            Phake::verify($this->comparator)->defaultCompare($this->delegatingRestricted, 'rhs')
        );
        Phake::verify($this->delegatingRestricted, Phake::never())->delegatingCompare(Phake::anyParameters());
        $this->assertSame(1010, $result);
    }

    public function testCompareWithRHSComparable()
    {
        $result = $this->comparator->compare('lhs', $this->comparable);
        Phake::verify($this->comparable)->compare('lhs');
        $this->assertSame(-2020, $result);
    }

    public function testCompareWithRHSRestrictedComparable()
    {
        $result = $this->comparator->compare('lhs', $this->restricted);
        Phake::inOrder(
            Phake::verify($this->restricted)->canCompare('lhs'),
            Phake::verify($this->restricted)->compare('lhs')
        );
        $this->assertSame(-3030, $result);
    }

    public function testCompareWithRHSRestrictedComparableCanNotCompare()
    {
        Phake::when($this->restricted)
            ->canCompare(Phake::anyParameters())
            ->thenReturn(false);

        $result = $this->comparator->compare('lhs', $this->restricted);
        Phake::inOrder(
            Phake::verify($this->restricted)->canCompare('lhs'),
            Phake::verify($this->comparator)->defaultCompare('lhs', $this->restricted)
        );
        Phake::verify($this->restricted, Phake::never())->compare(Phake::anyParameters());
        $this->assertSame(1010, $result);
    }

    public function testCompareWithRHSDelegatingComparable()
    {
        $result = $this->comparator->compare('lhs', $this->delegating);
        Phake::verify($this->delegating)->delegatingCompare('lhs', $this->comparator);
        $this->assertSame(-4040, $result);
    }

    public function testCompareWithRHSDelegatingRestrictedComparable()
    {
        $result = $this->comparator->compare('lhs', $this->delegatingRestricted);
        Phake::inOrder(
            Phake::verify($this->delegatingRestricted)->canCompare('lhs'),
            Phake::verify($this->delegatingRestricted)->delegatingCompare('lhs', $this->comparator)
        );
        $this->assertSame(-5050, $result);
    }

    public function testCompareWithRHSDelegatingRestrictedComparableCanNotCompare()
    {
        Phake::when($this->delegatingRestricted)
            ->canCompare(Phake::anyParameters())
            ->thenReturn(false);

        $result = $this->comparator->compare('lhs', $this->delegatingRestricted);
        Phake::inOrder(
            Phake::verify($this->delegatingRestricted)->canCompare('lhs'),
            Phake::verify($this->comparator)->defaultCompare('lhs', $this->delegatingRestricted)
        );
        Phake::verify($this->delegatingRestricted, Phake::never())->delegatingCompare(Phake::anyParameters());
        $this->assertSame(1010, $result);
    }

    public function testCompareTwoRestrictedInverts()
    {
        $lhs = Phake::mock('Icecave\Parity\RegularRestrictedComparableInterface');
        $rhs = Phake::mock('Icecave\Parity\RegularRestrictedComparableInterface');;

        Phake::when($lhs)
            ->canCompare($rhs)
            ->thenReturn(false);

        Phake::when($rhs)
            ->canCompare($lhs)
            ->thenReturn(true);

        $this->comparator->compare($lhs, $rhs);

        Phake::verify($rhs)->compare($lhs);
    }

    public function testCompareTwoDelegatingRestrictedInverts()
    {
        $lhs = Phake::mock('Icecave\Parity\DelegatingRestrictedComparableInterface');
        $rhs = Phake::mock('Icecave\Parity\DelegatingRestrictedComparableInterface');;

        Phake::when($lhs)
            ->canCompare($rhs)
            ->thenReturn(false);

        Phake::when($rhs)
            ->canCompare($lhs)
            ->thenReturn(true);

        $this->comparator->compare($lhs, $rhs);

        Phake::verify($rhs)->delegatingCompare($lhs, $this->comparator);
    }
}
