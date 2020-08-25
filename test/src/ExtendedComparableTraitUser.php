<?php

namespace Icecave\Parity;

class ExtendedComparableTraitUser implements ExtendedComparable
{
    use ExtendedComparableTrait;

    public function compare($rhs)
    {
        return 0 - $rhs;
    }
}
