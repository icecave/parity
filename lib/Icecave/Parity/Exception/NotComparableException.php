<?php
namespace Icecave\Parity\Exception;

use Icecave\Repr\Repr;
use LogicException;

class NotComparableException extends LogicException
{
    public function __construct($lhs, $rhs, Exception $previous = null)
    {
        parent::__construct(
            sprintf(
                'Can compare %s to %s.',
                Repr::repr($rhs),
                Repr::repr($lhs)
            ),
            0,
            $previous
        );
    }
}
