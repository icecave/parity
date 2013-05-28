<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\TypeCheck\TypeCheck;

class Comparator extends AbstractComparator
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        parent::__construct();
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     *
     * @return integer The result of the comparison.
     */
    public function defaultCompare($lhs, $rhs)
    {
        TypeCheck::get(__CLASS__)->defaultCompare(func_get_args());

        if ($lhs < $rhs) {
            return -1;
        } elseif ($lhs > $rhs) {
            return +1;
        }

        return 0;
    }

    private $typeCheck;
}
