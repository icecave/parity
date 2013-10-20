<?php
namespace Icecave\Parity\TypeCheck\Validator\Icecave\Parity\Comparator;

class ParityComparatorTypeCheck extends \Icecave\Parity\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('fallbackComparator', 0, 'Icecave\\Parity\\Comparator\\ComparatorInterface');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

    public function fallbackComparator(array $arguments)
    {
        if (\count($arguments) > 0) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(0, $arguments[0]);
        }
    }

    public function compare(array $arguments)
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

    public function canCompare(array $arguments)
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

    public function compareImplementationClass(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('value', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

}
