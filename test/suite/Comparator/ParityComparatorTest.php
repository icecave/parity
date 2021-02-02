<?php

namespace Icecave\Parity\Comparator;

use Eloquent\Liberator\Liberator;
use Eloquent\Phony\Phpunit\Phony;
use Icecave\Parity\AnyComparable;
use Icecave\Parity\RestrictedComparable;
use Icecave\Parity\SelfComparable;
use Icecave\Parity\SubClassComparable;
use PHPUnit\Framework\TestCase;
use stdClass;

class ParityComparatorTest extends TestCase
{
    public function setUp(): void
    {
        $this->fallbackComparator = Phony::mock(Comparator::class);
        $this->fallbackComparator->compare->returns(-1);

        $this->comparator = new ParityComparator($this->fallbackComparator->get());
    }

    public function testInvoke()
    {
        $this->assertSame(
            -1,
            call_user_func(
                $this->comparator,
                [1, 2, 3],
                [1, 2, 3]
            )
        );
    }

    public function testCompareInversion()
    {
        $lhs = Phony::mock(AnyComparable::class);
        $lhs->compare->returns(-1);

        $this->assertSame(-1, $this->comparator->compare($lhs->get(), 10));
        $this->assertSame(+1, $this->comparator->compare(10, $lhs->get()));
    }

    public function testCompareWithFallback()
    {
        $result = $this->comparator->compare(10, 20);

        $this->fallbackComparator->compare->calledWith(10, 20);

        $this->assertSame($result, -1);
    }

    public function testCompareWithAnyComparable()
    {
        $comparable = Phony::mock(AnyComparable::class);
        $comparable->compare->returns(-10);

        $result = $this->comparator->compare($comparable->get(), 10);

        $comparable->compare->calledWith(10);
        $this->fallbackComparator->noInteraction();

        $this->assertSame($result, -10);
    }

    public function testCompareWithRestrictedComparable()
    {
        $comparable = Phony::mock(RestrictedComparable::class);
        $comparable->compare->returns(-10);
        $comparable->canCompare->returns(true);

        $result = $this->comparator->compare($comparable->get(), 10);

        Phony::inOrder(
            $comparable->canCompare->calledWith(10),
            $comparable->compare->calledWith(10)
        );

        $this->fallbackComparator->noInteraction();

        $this->assertSame($result, -10);
    }

    public function testCompareWithRestrictedComparableAndUnsupportedOperand()
    {
        $comparable = Phony::mock(RestrictedComparable::class);
        $comparable->compare->returns(-10);
        $comparable->canCompare->returns(false);

        $result = $this->comparator->compare($comparable->get(), 10);

        $comparable->canCompare->calledWith(10);
        $comparable->compare->never()->called();
        $this->fallbackComparator->compare->calledWith($comparable, 10);

        $this->assertSame($result, -1);
    }

    public function testCompareWithSelfComparable()
    {
        $lhsComparable = Phony::mock(SelfComparable::class);
        $lhsComparable->compare->returns(-10);

        $rhsComparable = Phony::mock(SelfComparable::class);

        $result = $this->comparator->compare($lhsComparable->get(), $rhsComparable->get());

        $lhsComparable->compare->calledWith($rhsComparable);
        $this->fallbackComparator->noInteraction();

        $this->assertSame($result, -10);
    }

    public function testCompareWithSelfComparableAndSubClass()
    {
        $lhsComparable = new SelfComparableImpl();
        $rhsComparable = new SelfComparableSubClass();

        $result = $this->comparator->compare($lhsComparable, $rhsComparable);

        $this->fallbackComparator->compare->calledWith($lhsComparable, $rhsComparable);

        $this->assertSame($result, -1);
    }

    public function testCompareWithSelfComparableAndNonObject()
    {
        $comparable = Phony::mock(SelfComparable::class);

        $result = $this->comparator->compare($comparable->get(), 10);

        $comparable->compare->never()->called();
        $this->fallbackComparator->compare->calledWith($comparable, 10);

        $this->assertSame($result, -1);
    }

    public function testCompareWithSelfComparableAndUnrelatedType()
    {
        $comparable = Phony::mock(SelfComparable::class);

        $result = $this->comparator->compare($comparable->get(), new stdClass());

        $comparable->compare->never()->called();
        $this->fallbackComparator->compare->calledWith($comparable, new stdClass());

        $this->assertSame($result, -1);
    }

    public function testCompareWithSubClassComparable()
    {
        $lhsComparable = Phony::mock(SubClassComparable::class);
        $lhsComparable->compare->returns(-10);

        $rhsComparable = Phony::mock(SubClassComparable::class);

        $result = $this->comparator->compare($lhsComparable->get(), $rhsComparable->get());

        $lhsComparable->compare->calledWith($rhsComparable);
        $this->fallbackComparator->noInteraction();

        $this->assertSame($result, -10);
    }

    public function testCompareWithSubClassComparableAndSubClass()
    {
        $lhsComparable = new SubClassComparableImpl();
        $rhsComparable = new SubClassComparableSubClass();

        $result = $this->comparator->compare($lhsComparable, $rhsComparable);

        $this->fallbackComparator->noInteraction();

        $this->assertSame($result, -10);
    }

    public function testCompareWithSubClassComparableUsesCache()
    {
        $lhsComparable = Phony::mock(SubClassComparable::class);
        $lhsComparable->compare->returns(-10);

        $rhsComparable = Phony::mock(SubClassComparable::class);

        $this->assertSame(-10, $this->comparator->compare($lhsComparable->get(), $rhsComparable->get()));
        $this->assertSame(-10, $this->comparator->compare($lhsComparable->get(), $rhsComparable->get()));

        $this->assertSame(
            Liberator::liberate($this->comparator)->compareImplementationClasses[get_class($lhsComparable->get())],
            get_class($lhsComparable->get())
        );
    }

    public function testCompareWithSubClassComparableAndNonObject()
    {
        $comparable = Phony::mock(SubClassComparable::class);

        $result = $this->comparator->compare($comparable->get(), 10);

        $comparable->compare->never()->called();
        $this->fallbackComparator->compare->calledWith($comparable, 10);

        $this->assertSame($result, -1);
    }

    public function testCompareWithSubClassComparableAndUnrelatedType()
    {
        $comparable = Phony::mock(SubClassComparable::class);

        $result = $this->comparator->compare($comparable->get(), new stdClass());

        $comparable->compare->never()->called();
        $this->fallbackComparator->compare->calledWith($comparable, new stdClass());

        $this->assertSame($result, -1);
    }
}
