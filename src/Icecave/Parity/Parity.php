<?php
namespace Icecave\Parity;

use Icecave\Parity\Comparator\DeepComparator;
use Icecave\Parity\Comparator\ParityComparator;
use Icecave\Parity\Comparator\StrictPhpComparator;
use Icecave\Parity\TypeCheck\TypeCheck;

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
        TypeCheck::get(__CLASS__)->compare(func_get_args());

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
        TypeCheck::get(__CLASS__)->isEqualTo(func_get_args());

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
        TypeCheck::get(__CLASS__)->isNotEqualTo(func_get_args());

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
        TypeCheck::get(__CLASS__)->isLessThan(func_get_args());

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
        TypeCheck::get(__CLASS__)->isGreaterThan(func_get_args());

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
        TypeCheck::get(__CLASS__)->isLessThanOrEqualTo(func_get_args());

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
        TypeCheck::get(__CLASS__)->isGreaterThanOrEqualTo(func_get_args());

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
        TypeCheck::get(__CLASS__)->comparator(func_get_args());

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
