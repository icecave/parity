<?php
namespace Icecave\Parity;

use Icecave\Parity\TypeCheck\TypeCheck;

abstract class AbstractComparable implements ExtendedComparableInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this == $value.
     */
    public function isEqualTo($value)
    {
        TypeCheck::get(__CLASS__)->isEqualTo(func_get_args());

        return $this->compare($value) === 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this != $value.
     */
    public function isNotEqualTo($value)
    {
        TypeCheck::get(__CLASS__)->isNotEqualTo(func_get_args());

        return $this->compare($value) !== 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this < $value.
     */
    public function isLessThan($value)
    {
        TypeCheck::get(__CLASS__)->isLessThan(func_get_args());

        return $this->compare($value) < 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this > $value.
     */
    public function isGreaterThan($value)
    {
        TypeCheck::get(__CLASS__)->isGreaterThan(func_get_args());

        return $this->compare($value) > 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this <= $value.
     */
    public function isLessThanOrEqualTo($value)
    {
        TypeCheck::get(__CLASS__)->isLessThanOrEqualTo(func_get_args());

        return $this->compare($value) <= 0;
    }

    /**
     * @param mixed $value The value to compare.
     *
     * @return boolean True if $this >= $value.
     */
    public function isGreaterThanOrEqualTo($value)
    {
        TypeCheck::get(__CLASS__)->isGreaterThanOrEqualTo(func_get_args());

        return $this->compare($value) >= 0;
    }

    private $typeCheck;
}
