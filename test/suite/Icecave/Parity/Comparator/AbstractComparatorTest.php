<?php
namespace Icecave\Parity\Comparator;

use Phake;
use PHPUnit_Framework_TestCase;

class AbstractComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = Phake::partialMock(__NAMESPACE__ . '\AbstractComparator');

        $this->value = 'same';
        $this->less  = 'less';
        $this->same  = 'same';
        $this->more  = 'more';

        // Phake::when($this->comparator)
        //     ->compare($this->value, $this->less)
        //     ->thenReturn(100);

        // Phake::when($this->comparator)
        //     ->compare($this->value, $this->same)
        //     ->thenReturn(0);

        // Phake::when($this->comparator)
        //     ->compare($this->value, $this->more)
        //     ->thenReturn(-100);
    }

}
