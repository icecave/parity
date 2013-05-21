<?php
namespace Icecave\Parity\Comparator;

class DeepComparator extends AbstractComparator
{
    public function defaultCompare($lhs, $rhs)
    {
        if ($lhs < $rhs) {
            return -1;
        } elseif ($lhs > $rhs) {
            return +1;
        }

        return 0;
    }
}
