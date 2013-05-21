<?php
namespace Icecave\Parity;

use Icecave\Parity\Comparator\ComparatorInterface;

interface DelegatingComparableInterface
{
    /**
     * Compare this object with another value, yielding a result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * @param mixed               $value      The value to compare.
     * @param ComparatorInterface $comparator The comparator being used to perform the comparison.
     *
     * @return integer                          The result of the comparison.
     * @throws Exception\NotComparableException Indicates that the implementation does not know how to compare $this to $value.
     */
    public function delegatingCompare($value, ComparatorInterface $comparitor);
}
