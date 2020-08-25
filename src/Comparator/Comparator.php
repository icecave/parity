<?php

namespace Icecave\Parity\Comparator;

/**
 * An object that can compare two values.
 */
interface Comparator
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
     * @return int The result of the comparison.
     */
    public function compare($lhs, $rhs): int;

    /**
     * An alias for compare().
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return int The result of the comparison.
     */
    public function __invoke($lhs, $rhs): int;
}
