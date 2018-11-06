<?php
namespace Icecave\Parity;

class ExtendedComparable implements ExtendedComparableInterface
{
    use ExtendedComparableTrait;

    public function compare($rhs)
    {
        return 0 - $rhs;
    }
}
