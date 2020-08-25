<?php

namespace Icecave\Parity;

/**
 * Convenience trait that implements ExtendedComparable
 */
trait ExtendedComparableTrait
{
    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this == $value.
     */
    public function isEqualTo($value): bool
    {
        return $this->compare($value) === 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this != $value.
     */
    public function isNotEqualTo($value): bool
    {
        return $this->compare($value) !== 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this < $value.
     */
    public function isLessThan($value): bool
    {
        return $this->compare($value) < 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this > $value.
     */
    public function isGreaterThan($value): bool
    {
        return $this->compare($value) > 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this <= $value.
     */
    public function isLessThanOrEqualTo($value): bool
    {
        return $this->compare($value) <= 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return bool True if $this >= $value.
     */
    public function isGreaterThanOrEqualTo($value): bool
    {
        return $this->compare($value) >= 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return int
     */
    abstract protected function compare($value): int;
}
