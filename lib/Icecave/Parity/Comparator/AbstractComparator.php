<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\ComparableInterface;
use Icecave\Parity\DelegatingComparableInterface;
use Icecave\Parity\RestrictedComparableInterface;
use Icecave\Parity\TypeCheck\TypeCheck;

abstract class AbstractComparator implements ComparatorInterface
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());
    }

    /**
     * Compare two values, yielding a result according to the following table:
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
    public function compare($lhs, $rhs)
    {
        TypeCheck::get(__CLASS__)->compare(func_get_args());

        if ($lhs instanceof DelegatingComparableInterface && $this->canCompare($lhs, $rhs)) {
            return $lhs->delegatingCompare($rhs, $this);
        } elseif ($lhs instanceof ComparableInterface && $this->canCompare($lhs, $rhs)) {
            return $lhs->compare($rhs);
        } elseif ($rhs instanceof DelegatingComparableInterface && $this->canCompare($rhs, $lhs)) {
            return -$rhs->delegatingCompare($lhs, $this);
        } elseif ($rhs instanceof ComparableInterface && $this->canCompare($rhs, $lhs)) {
            return -$rhs->compare($lhs);
        }

        return $this->defaultCompare($lhs, $rhs);
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     *
     * @return integer The result of the comparison.
     */
    abstract public function defaultCompare($lhs, $rhs);

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     *
     * @return boolean
     */
    protected function canCompare($lhs, $rhs)
    {
        TypeCheck::get(__CLASS__)->canCompare(func_get_args());

        if ($lhs instanceof RestrictedComparableInterface) {
            return $lhs->canCompare($rhs);
        }

        return true;
    }

    private $typeCheck;
}
