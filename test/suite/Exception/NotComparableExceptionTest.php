<?php

namespace Icecave\Parity\Exception;

use Exception;
use PHPUnit\Framework\TestCase;

class NotComparableExceptionTest extends TestCase
{
    public function testException()
    {
        $lhs = [1, 2, 3];
        $rhs = [4, 5, 6];

        $previous = new Exception();
        $exception = new NotComparableException($lhs, $rhs, $previous);

        $this->assertSame('Can not compare [1, 2, 3] to [4, 5, 6].', $exception->getMessage());
        $this->assertSame($previous, $exception->getPrevious());
    }
}
