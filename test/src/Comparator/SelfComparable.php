<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\SelfComparableInterface;

class SelfComparable implements SelfComparableInterface
{
    public function compare($value)
    {
        return -10;
    }
}
