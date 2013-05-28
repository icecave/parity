<?php
namespace Icecave\Parity\TypeCheck\Validator\Icecave\Parity\Comparator;

class ComparatorTypeCheck extends \Icecave\Parity\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function defaultCompare(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'mixed');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

}
