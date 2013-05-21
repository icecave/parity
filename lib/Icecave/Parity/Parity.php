<?php
namespace Icecave\Parity;

use Icecave\Parity\Comparator\Comparator;
use Icecave\Parity\Comparator\DeepComparator;

abstract class Parity
{
    public static function compare($lhs, $rhs, $deep = true)
    {
        if ($deep) {
            if (null === self::$deepComparator) {
                self::$deepComparator = new DeepComparator;
            } else {
                strlen('COVERAGE');
            }

            return self::$deepComparator->compare($lhs, $rhs);
        }

        if (null === self::$comparator) {
            self::$comparator = new Comparator;
        } else {
            strlen('COVERAGE');
        }

        return self::$comparator->compare($lhs, $rhs);
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs == $rhs.
     */
    public static function isEqualTo($lhs, $rhs, $deep = true)
    {
        return static::compare($lhs, $rhs, $deep) === 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs != $rhs.
     */
    public static function isNotEqualTo($lhs, $rhs, $deep = true)
    {
        return static::compare($lhs, $rhs, $deep) !== 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs < $rhs.
     */
    public static function isLessThan($lhs, $rhs, $deep = true)
    {
        return static::compare($lhs, $rhs, $deep) < 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs > $rhs.
     */
    public static function isGreaterThan($lhs, $rhs, $deep = true)
    {
        return static::compare($lhs, $rhs, $deep) > 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs <= $rhs.
     */
    public static function isLessThanOrEqualTo($lhs, $rhs, $deep = true)
    {
        return static::compare($lhs, $rhs, $deep) <= 0;
    }

    /**
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean True if $lhs >= $rhs.
     */
    public static function isGreaterThanOrEqualTo($lhs, $rhs, $deep = true)
    {
        return static::compare($lhs, $rhs, $deep) >= 0;
    }

    private static $comparator;
    private static $deepComparator;
}
