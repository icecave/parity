<?php
namespace Icecave\Parity;

/**
 * An object that can compare itself to a subset of other values.
 */
interface RestrictedComparableInterface
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
     * @return integer                          The result of the comparison.
     * @throws Exception\NotComparableException Indicates that the implementation does not know how to compare $this to $value.
     */
    public function compare($value);

    /**
     * Check if $this is able to be compared to another value.
     *
     * A return value of false indicates that calling $this->compare($value)
     * will throw an exception.
     *
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this can be compared to $value.
     */
    public function canCompare($value);
}
