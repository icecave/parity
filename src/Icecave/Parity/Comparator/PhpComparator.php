<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\TypeCheck\TypeCheck;

/**
 * A comparator that compares using the built-in PHP less than operator.
 */
class PhpComparator implements ComparatorInterface
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
        $this->typeCheck->compare(func_get_args());

        if ($lhs < $rhs) {
            return -1;
        } elseif ($rhs < $lhs) {
            return +1;
        }

        return 0;
    }

    /**
     * An alias for compare().
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return integer The result of the comparison.
     */
    public function __invoke($lhs, $rhs)
    {
        $this->typeCheck->validateInvoke(func_get_args());

        return $this->compare($lhs, $rhs);
    }

    private $typeCheck;
}
