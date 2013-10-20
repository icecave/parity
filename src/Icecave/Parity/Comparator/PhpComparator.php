<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\TypeCheck\TypeCheck;

/**
 * A comparator that compares using the built-in PHP less than operator.
 */
class PhpComparator implements ComparatorInterface
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
        TypeCheck::get(__CLASS__)->compare(func_get_args());

        if ($lhs < $rhs) {
            return -1;
        } elseif ($rhs < $lhs) {
            return +1;
        }

        return 0;
    }
}
