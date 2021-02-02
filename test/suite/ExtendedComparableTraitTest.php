<?php

namespace Icecave\Parity;

use Eloquent\Phony\Phpunit\Phony;
use PHPUnit\Framework\TestCase;

class ExtendedComparableTraitTest extends TestCase
{
    public function setUp(): void
    {
        $this->trait = Phony::partialMock(ExtendedComparableTraitUser::class)->get();

        $this->less  = -1;
        $this->same  = 0;
        $this->more  = 1;
    }

    public function testIsEqualTo()
    {
        $this->assertFalse($this->trait->isEqualTo($this->less));
        $this->assertTrue($this->trait->isEqualTo($this->same));
        $this->assertFalse($this->trait->isEqualTo($this->more));
    }

    public function testIsNotEqualTo()
    {
        $this->assertTrue($this->trait->isNotEqualTo($this->less));
        $this->assertFalse($this->trait->isNotEqualTo($this->same));
        $this->assertTrue($this->trait->isNotEqualTo($this->more));
    }

    public function testIsLessThan()
    {
        $this->assertFalse($this->trait->isLessThan($this->less));
        $this->assertFalse($this->trait->isLessThan($this->same));
        $this->assertTrue($this->trait->isLessThan($this->more));
    }

    public function testIsGreaterThan()
    {
        $this->assertTrue($this->trait->isGreaterThan($this->less));
        $this->assertFalse($this->trait->isGreaterThan($this->same));
        $this->assertFalse($this->trait->isGreaterThan($this->more));
    }

    public function testIsLessThanOrEqualTo()
    {
        $this->assertFalse($this->trait->isLessThanOrEqualTo($this->less));
        $this->assertTrue($this->trait->isLessThanOrEqualTo($this->same));
        $this->assertTrue($this->trait->isLessThanOrEqualTo($this->more));
    }

    public function testIsGreaterThanOrEqualTo()
    {
        $this->assertTrue($this->trait->isGreaterThanOrEqualTo($this->less));
        $this->assertTrue($this->trait->isGreaterThanOrEqualTo($this->same));
        $this->assertFalse($this->trait->isGreaterThanOrEqualTo($this->more));
    }
}
