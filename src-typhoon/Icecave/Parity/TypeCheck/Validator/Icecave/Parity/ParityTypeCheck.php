<?php
namespace Icecave\Parity\TypeCheck\Validator\Icecave\Parity;

class ParityTypeCheck extends \Icecave\Parity\TypeCheck\AbstractValidator
{
    public function compare(array $arguments)
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'deep',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function isEqualTo(array $arguments)
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'deep',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function isNotEqualTo(array $arguments)
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'deep',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function isLessThan(array $arguments)
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'deep',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function isGreaterThan(array $arguments)
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'deep',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function isLessThanOrEqualTo(array $arguments)
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'deep',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

    public function isGreaterThanOrEqualTo(array $arguments)
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
        if ($argumentCount > 2) {
            $value = $arguments[2];
            if (!\is_bool($value)) {
                throw new \Icecave\Parity\TypeCheck\Exception\UnexpectedArgumentValueException(
                    'deep',
                    2,
                    $arguments[2],
                    'boolean'
                );
            }
        }
    }

}
