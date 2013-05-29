<?php
namespace Icecave\Parity;

use Icecave\Parity\Comparator\Comparator;
use Icecave\Parity\Comparator\DeepComparator;
use Icecave\Parity\TypeCheck\TypeCheck;

abstract class Parity
{
    /**
     * @param mixed   $lhs
     * @param mixed   $rhs
     * @param boolean $deep True to do a deep comparasion.
     *
     * @return integer The result of the comparison.
     */
    public static function compare($lhs, $rhs, $deep = true)
    {
        TypeCheck::get(__CLASS__)->compare(func_get_args());

        if ($deep) {
            if (null === self::$deepComparator) {
                self::$deepComparator = new DeepComparator;
            }

            return self::$deepComparator->compare($lhs, $rhs);
        }

        if (null === self::$comparator) {
            self::$comparator = new Comparator;
        }

        return self::$comparator->compare($lhs, $rhs);
    }

    /**
     * @param mixed   $lhs  The first value to compare.
     * @param mixed   $rhs  The second value to compare.
     * @param boolean $deep True to do a deep comparasion.
     *
     * @return boolean True if $lhs == $rhs.
     */
    public static function isEqualTo($lhs, $rhs, $deep = true)
    {
        TypeCheck::get(__CLASS__)->isEqualTo(func_get_args());

        return static::compare($lhs, $rhs, $deep) === 0;
    }

    /**
     * @param mixed   $lhs  The first value to compare.
     * @param mixed   $rhs  The second value to compare.
     * @param boolean $deep True to do a deep comparasion.
     *
     * @return boolean True if $lhs != $rhs.
     */
    public static function isNotEqualTo($lhs, $rhs, $deep = true)
    {
        TypeCheck::get(__CLASS__)->isNotEqualTo(func_get_args());

        return static::compare($lhs, $rhs, $deep) !== 0;
    }

    /**
     * @param mixed   $lhs  The first value to compare.
     * @param mixed   $rhs  The second value to compare.
     * @param boolean $deep True to do a deep comparasion.
     *
     * @return boolean True if $lhs < $rhs.
     */
    public static function isLessThan($lhs, $rhs, $deep = true)
    {
        TypeCheck::get(__CLASS__)->isLessThan(func_get_args());

        return static::compare($lhs, $rhs, $deep) < 0;
    }

    /**
     * @param mixed   $lhs  The first value to compare.
     * @param mixed   $rhs  The second value to compare.
     * @param boolean $deep True to do a deep comparasion.
     *
     * @return boolean True if $lhs > $rhs.
     */
    public static function isGreaterThan($lhs, $rhs, $deep = true)
    {
        TypeCheck::get(__CLASS__)->isGreaterThan(func_get_args());

        return static::compare($lhs, $rhs, $deep) > 0;
    }

    /**
     * @param mixed   $lhs  The first value to compare.
     * @param mixed   $rhs  The second value to compare.
     * @param boolean $deep True to do a deep comparasion.
     *
     * @return boolean True if $lhs <= $rhs.
     */
    public static function isLessThanOrEqualTo($lhs, $rhs, $deep = true)
    {
        TypeCheck::get(__CLASS__)->isLessThanOrEqualTo(func_get_args());

        return static::compare($lhs, $rhs, $deep) <= 0;
    }

    /**
     * @param mixed   $lhs  The first value to compare.
     * @param mixed   $rhs  The second value to compare.
     * @param boolean $deep True to do a deep comparasion.
     *
     * @return boolean True if $lhs >= $rhs.
     */
    public static function isGreaterThanOrEqualTo($lhs, $rhs, $deep = true)
    {
        TypeCheck::get(__CLASS__)->isGreaterThanOrEqualTo(func_get_args());

        return static::compare($lhs, $rhs, $deep) >= 0;
    }

    private static $comparator;
    private static $deepComparator;
}
