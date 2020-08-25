<?php

namespace Icecave\Parity\Comparator;

use Icecave\Parity\SubClassComparable;

class SubClassComparableImpl implements SubClassComparable
{
    public function compare($value)
    {
        return -10;
    }
}
