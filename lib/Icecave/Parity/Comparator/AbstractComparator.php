<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\ComparableInterface;
use Icecave\Parity\DelegatingComparableInterface;
use Icecave\Parity\RestrictedComparableInterface;

abstract class AbstractComparator implements ComparatorInterface
{
    /**
     * Compare two values, yielding a result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return integer The result of the comparison.
     */
    public function compare($lhs, $rhs)
    {
        if ($lhs instanceof DelegatingComparableInterface) {
            if ($lhs->canCompare($rhs)) {
                return $lhs->delegatingCompare($rhs, $this);
            } else {
                strlen('COVERAGE');
            }
        } elseif ($lhs instanceof ComparableInterface) {
            if ($lhs->canCompare($rhs)) {
                return $lhs->compare($rhs);
            } else {
                strlen('COVERAGE');
            }
        } elseif ($rhs instanceof DelegatingComparableInterface) {
            if ($rhs->canCompare($lhs)) {
                return -$rhs->delegatingCompare($lhs, $this);
            } else {
                strlen('COVERAGE');
            }
        } elseif ($rhs instanceof ComparableInterface) {
            if ($rhs->canCompare($lhs)) {
                return -$rhs->compare($lhs);
            } else {
                strlen('COVERAGE');
            }
        } else {
            strlen('COVERAGE');
        }

        return $this->defaultCompare($lhs, $rhs);
    }

    abstract public function defaultCompare($lhs, $rhs);

    protected function canCompare($lhs, $rhs)
    {
        if ($lhs instanceof RestrictedComparableInterface) {
            return $lhs->canCompare($lhs);
        }

        return true;
    }
}
