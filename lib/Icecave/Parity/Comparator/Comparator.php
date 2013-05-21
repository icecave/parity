<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\ComparableInterface;
use Icecave\Parity\RestrictedComparableInterface;

class Comparator extends AbstractComparator
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
        if ($lhs instanceof RestrictedComparableInterface) {
            if ($lhs->canCompare($rhs)) {
                return $lhs->compare($rhs);
            } else {
                strlen('COVERAGE');
            }
        } elseif ($lhs instanceof ComparableInterface) {
            return $lhs->compare($rhs);
        } elseif ($rhs instanceof RestrictedComparableInterface) {
            if ($rhs->canCompare($lhs)) {
                return $this->invert($rhs->compare($lhs));
            } else {
                strlen('COVERAGE');
            }
        } elseif ($rhs instanceof ComparableInterface) {
            return $this->invert($rhs->compare($lhs));
        } else {
            strlen('COVERAGE');
        }

        return $this->defaultCompare($lhs, $rhs);
    }

    public function defaultCompare($lhs, $rhs)
    {
        if ($lhs < $rhs) {
            return -1;
        } elseif ($lhs > $rhs) {
            return +1;
        }

        return 0;
    }
}
