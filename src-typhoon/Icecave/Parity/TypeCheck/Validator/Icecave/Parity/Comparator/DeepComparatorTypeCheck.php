<?php
namespace Icecave\Parity\TypeCheck\Validator\Icecave\Parity\Comparator;

class DeepComparatorTypeCheck extends \Icecave\Parity\TypeCheck\AbstractValidator
{
    public function validateConstruct(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 1) {
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('fallbackComparator', 0, 'Icecave\\Parity\\Comparator\\ComparatorInterface');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
        }
        if ($argumentCount > 1) {
            $value = $arguments[1];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'relaxClassComparisons',
                    1,
                    $arguments[1],
                    'boolean'
                );
            }
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

    public function compareValue(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'mixed');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'mixed');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('visitationContext', 2, 'mixed');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

    public function compareArray(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'array');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'array');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('visitationContext', 2, 'mixed');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

    public function compareObject(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'object');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'object');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('visitationContext', 2, 'mixed');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
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
        if ($argumentCount < 2) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('object', 0, 'object');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('visitationContext', 1, 'mixed');
        } elseif ($argumentCount > 2) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(2, $arguments[2]);
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

    public function isNestedComparison(array $arguments)
    {
        $argumentCount = \count($arguments);
        if ($argumentCount < 3) {
            if ($argumentCount < 1) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('lhs', 0, 'mixed');
            }
            if ($argumentCount < 2) {
                throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('rhs', 1, 'mixed');
            }
            throw new \Icecave\Parity\TypeCheck\Exception\MissingArgumentException('visitationContext', 2, 'mixed');
        } elseif ($argumentCount > 3) {
            throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentException(3, $arguments[3]);
        }
    }

}
