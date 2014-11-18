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
     * @param mixed $lhs     The first value to compare.
     * @param mixed $rhs,... The second (and more) value(s) to compare.
     *
     * @return mixed
     */
    public static function min($lhs, $rhs)
    {
        if (func_num_args() === 2) {
            if (static::isLessThan($lhs, $rhs)) {
                return $lhs;
            } else {
                return $rhs;
            }
        }

        return self::minSequence(func_get_args());
    }

    /**
     * @param mixed $lhs     The first value to compare.
     * @param mixed $rhs,... The second (and more) value(s) to compare.
     *
     * @return mixed
     */
    public static function max($lhs, $rhs)
    {
        if (func_num_args() === 2) {
            if (static::isGreaterThan($lhs, $rhs)) {
                return $lhs;
            } else {
                return $rhs;
            }
        }

        return self::maxSequence(func_get_args());
    }

    /**
     * @param array|Traversable $sequence The sequence to find the minimum value in.
     * @param mixed|null        $default  The default miniumum value, or null.
     *
     * @return mixed|null The minimum value in the sequence, which may be null if the sequence is empty and no other default is given.
     */
    public static function minSequence($sequence, $default = null)
    {
        $min = $default;

        foreach ($sequence as $value) {
            if (null === $value) {
                continue;
            }

            if (null === $min) {
                $min = $value;
            } elseif (static::isLessThan($value, $min)) {
                $min = $value;
            }
        }

        return $min;
    }

    /**
     * @param array|Traversable $sequence The sequence to find the maximum value in.
     * @param mixed|null        $default  The default maxiumum value, or null.
     *
     * @return mixed|null The maximum value in the sequence, which may be null if the sequence is empty and no other default is given.
     */
    public static function maxSequence($sequence, $default = null)
    {
        $max = $default;

        foreach ($sequence as $value) {
            if (null === $value) {
                continue;
            }

            if (null === $max) {
                $max = $value;
            } elseif (static::isGreaterThan($value, $max)) {
                $max = $value;
            }
        }

        return $max;
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
                    new StrictPhpComparator()
                )
            );
        }

        return self::$comparator;
    }

    private static $comparator;
}
