<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\SubClassComparableInterface;

class SubClassComparable implements SubClassComparableInterface
{
    public function compare($value)
    {
        return -10;
    }
}
