<?php
namespace Icecave\Parity\TypeCheck\Validator\Icecave\Parity\Exception;

class NotComparableExceptionTypeCheck extends \Icecave\Parity\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'mixed');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'mixed');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

}
