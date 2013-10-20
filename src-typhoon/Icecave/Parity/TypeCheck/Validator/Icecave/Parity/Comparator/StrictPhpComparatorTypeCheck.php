<?php
namespace Icecave\Parity\TypeCheck\Validator\Icecave\Parity\Comparator;

class StrictPhpComparatorTypeCheck extends \Icecave\Parity\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount > 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        if ($argumentCount > 0) {
            $value = $arguments[0];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'relaxNumericComparisons',
                    0,
                    $arguments[0],
                    'boolean'
                );
            }
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

    public function validateInvoke(array $arguments)
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

    public function transformTypeName(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('value', 0, 'mixed');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
    }

}
