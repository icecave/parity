<?php
namespace Icecave\Parity\Exception;

use Exception;
use Icecave\Repr\Repr;
use LogicException;

class NotComparableException extends LogicException
{
    /**
     * @param mixed          $lhs
     * @param mixed          $rhs
     * @param Exception|null $previous
     */
    public function __construct($lhs, $rhs, Exception $previous = null)
    {
        parent::__construct(
            sprintf(
                'Can not compare %s to %s.',
                Repr::repr($lhs),
                Repr::repr($rhs)
            ),
            0,
            $previous
        );
    }
}
