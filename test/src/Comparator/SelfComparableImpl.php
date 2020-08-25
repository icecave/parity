<?php

namespace Icecave\Parity\Comparator;

use Icecave\Parity\SelfComparable;

class SelfComparableImpl implements SelfComparable
{
    public function compare($value): int
    {
        return -10;
    }
}
