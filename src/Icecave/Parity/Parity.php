<?php
namespace Icecave\Parity;

use Icecave\Parity\Comparator\DeepComparator;
use Icecave\Parity\Comparator\ParityComparator;
use Icecave\Parity\Comparator\StrictPhpComparator;

abstract class Parity
{
    /**
     * Compare two values, yeilding a result according to the following table:
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
    public static function compare($lhs, $rhs)
    {
        return self::comparator()->compare($lhs, $rhs);
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs == $rhs.
     */
    public static function isEqualTo($lhs, $rhs)
    {
        return static::compare($lhs, $rhs) === 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs != $rhs.
     */
    public static function isNotEqualTo($lhs, $rhs)
    {
        return static::compare($lhs, $rhs) !== 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs < $rhs.
     */
    public static function isLessThan($lhs, $rhs)
    {
        return static::compare($lhs, $rhs) < 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs > $rhs.
     */
    public static function isGreaterThan($lhs, $rhs)
    {
        return static::compare($lhs, $rhs) > 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs <= $rhs.
     */
    public static function isLessThanOrEqualTo($lhs, $rhs)
    {
        return static::compare($lhs, $rhs) <= 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs >= $rhs.
     */
    public static function isGreaterThanOrEqualTo($lhs, $rhs)
    {
        return static::compare($lhs, $rhs) >= 0;
    }

    /**
     * Get the internal Parity comparator.
     *
     * The comparator returned by this method in such as way as to enforce the
     * documented rules of Parity's comparison engine.
     *
     * @return ComparatorInterface
     */
    public static function comparator()
    {
        if (null === self::$comparator) {
            self::$comparator = new ParityComparator(
                new DeepComparator(
                    new StrictPhpComparator
                )
            );
        }

        return self::$comparator;
    }

    private static $comparator;
}
