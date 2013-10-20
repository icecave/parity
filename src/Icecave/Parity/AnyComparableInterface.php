<?php
namespace Icecave\Parity;

/**
 * An object that can be compared to any other value.
 */
interface AnyComparableInterface
{
    /**
     * Compare this object with another value, yielding a result according to
     * the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * @param mixed $value The value to compare.
     *
     * @return integer The result of the comparison.
     */
    public function compare($value);
}
