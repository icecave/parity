<?php
namespace Icecave\Parity;

/**
 * An object that can compare itself to other objects that are the same type, or
 * derived from the type in which compare() is implemented.
 */
interface SubClassComparableInterface
{
    /**
     * Compare this object with another object of the same type, yielding a
     * result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * @param object $value The object to compare.
     *
     * @return integer                          The result of the comparison.
     * @throws Exception\NotComparableException if $value is not the same type as $this.
     */
    public function compare($value);
}
