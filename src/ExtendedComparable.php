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
    public function isEqualTo($value): bool;

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this != $value.
     */
    public function isNotEqualTo($value): bool;

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this < $value.
     */
    public function isLessThan($value): bool;

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this > $value.
     */
    public function isGreaterThan($value): bool;

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this <= $value.
     */
    public function isLessThanOrEqualTo($value): bool;

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this >= $value.
     */
    public function isGreaterThanOrEqualTo($value): bool;
}
