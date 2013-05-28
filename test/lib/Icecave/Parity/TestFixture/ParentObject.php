<?php
namespace Icecave\Parity\TestFixture;

class ParentObject
{
    public function __construct($foo, $bar)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }

    public static $staticProperty = 'staticPropertyValue';
    private $foo;
    private $bar;
}
