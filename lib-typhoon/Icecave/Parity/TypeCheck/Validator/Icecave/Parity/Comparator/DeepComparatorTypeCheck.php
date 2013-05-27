<?php
namespace Icecave\Parity\TypeCheck\Validator\Icecave\Parity\Comparator;

class DeepComparatorTypeCheck extends \Icecave\Parity\TypeCheck\AbstractValidator
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

    public function compareValue(array $arguments)
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

    public function compareArray(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'array');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'array');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
    }

    public function compareObject(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'object');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'object');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_object($value)) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                'lhs',
                0,
                $arguments[0],
                'object'
            );
        }
        $value = $arguments[1];
        if (!\is_object($value)) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                'rhs',
                1,
                $arguments[1],
                'object'
            );
        }
    }

    public function objectProperties(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('object', 0, 'object');
        } elseif ($argumentCount > 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(1, $arguments[1]);
        }
        $value = $arguments[0];
        if (!\is_object($value)) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                'object',
                0,
                $arguments[0],
                'object'
            );
        }
    }

    public function objectComparisonStackKey(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'object');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'object');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        $value = $arguments[0];
        if (!\is_object($value)) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                'lhs',
                0,
                $arguments[0],
                'object'
            );
        }
        $value = $arguments[1];
        if (!\is_object($value)) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                'rhs',
                1,
                $arguments[1],
                'object'
            );
        }
    }

}
