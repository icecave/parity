<?php

namespace Icecave\Parity;

/**
 * Provides convenience methods for comparison operations.
 */
interface ExtendedComparable
{
    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this == $value.
     */
    public function isEqualTo($value);

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this != $value.
     */
    public function isNotEqualTo($value);

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this < $value.
     */
    public function isLessThan($value);

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this > $value.
     */
    public function isGreaterThan($value);

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this <= $value.
     */
    public function isLessThanOrEqualTo($value);

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this >= $value.
     */
    public function isGreaterThanOrEqualTo($value);
}
