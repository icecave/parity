<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\Exception\NotComparableException;
use Icecave\Parity\TypeCheck\TypeCheck;
use ReflectionObject;

class DeepComparator extends AbstractComparator
{
    public function __construct()
    {
        $this->typeCheck = TypeCheck::get(__CLASS__, func_get_args());

        parent::__construct();
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     *
     * @return integer The result of the comparison.
     */
    public function defaultCompare($lhs, $rhs)
    {
        TypeCheck::get(__CLASS__)->defaultCompare(func_get_args());

        $this->objectComparisonStack = array();

        return $this->compareValue($lhs, $rhs);
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     *
     * @return integer The result of the comparison.
     */
    protected function compareValue($lhs, $rhs)
    {
        TypeCheck::get(__CLASS__)->compareValue(func_get_args());

        if (is_array($lhs) && is_array($rhs)) {
            return $this->compareArray($lhs, $rhs);
        } elseif (is_object($lhs) && is_object($rhs)) {
            return $this->compareObject($lhs, $rhs);
        } elseif ($lhs < $rhs) {
            return -1;
        } elseif ($lhs > $rhs) {
            return +1;
        }

        return 0;
    }

    /**
     * @param array $lhs
     * @param array $rhs
     *
     * @return integer The result of the comparison.
     */
    protected function compareArray(array $lhs, array $rhs)
    {
        TypeCheck::get(__CLASS__)->compareArray(func_get_args());

        if (count($lhs) < count($rhs)) {
            return -1;
        } elseif (count($lhs) > count($rhs)) {
            return +1;
        }

        reset($lhs);
        reset($rhs);

        while (true) {
            $left  = each($lhs);
            $right = each($rhs);

            if ($left === false && $right === false) {
                break;
            }

            $result = $this->compareValue($left['key'], $right['key']);
            if ($result !== 0) {
                return $result;
            }

            $result = $this->compareValue($left['value'], $right['value']);
            if ($result !== 0) {
                return $result;
            }
        }

        return 0;
    }

    /**
     * @param object $lhs
     * @param object $rhs
     *
     * @return integer The result of the comparison.
     */
    protected function compareObject($lhs, $rhs)
    {
        TypeCheck::get(__CLASS__)->compareObject(func_get_args());

        if ($lhs === $rhs) {
            return 0;
        }

        $diff = strcmp(get_class($lhs), get_class($rhs));
        if ($diff !== 0) {
            return $diff;
        }

        $stackKey = $this->objectComparisonStackKey($lhs, $rhs);
        if (!array_key_exists($stackKey, $this->objectComparisonStack)) {
            // Add the key to the comparision stack in advance to catch infinitely recursive comparision.
            $this->objectComparisonStack[$stackKey] = null;

            $this->objectComparisonStack[$stackKey] = $this->compareArray(
                $this->objectProperties($lhs),
                $this->objectProperties($rhs)
            );
        }

        // Handle infinite recursive compare...
        if ($this->objectComparisonStack[$stackKey] === null) {
            throw new NotComparableException($lhs, $rhs);
        }

        return $this->objectComparisonStack[$stackKey];
    }

    /**
     * @param object $object
     *
     * @return array<string,mixed>
     */
    protected function objectProperties($object)
    {
        TypeCheck::get(__CLASS__)->objectProperties(func_get_args());

        $properties = array();
        $reflector = new ReflectionObject($object);

        while ($reflector) {
            foreach ($reflector->getProperties() as $property) {
                if ($property->isStatic()) {
                    continue;
                }

                $key = sprintf(
                    '%s::%s',
                    $property->getDeclaringClass()->getName(),
                    $property->getName()
                );

                $property->setAccessible(true);
                $properties[$key] = $property->getValue($object);
            }

            $reflector = $reflector->getParentClass();
        }

        return $properties;
    }

    /**
     * @param object $lhs
     * @param object $rhs
     *
     * @return string
     */
    protected function objectComparisonStackKey($lhs, $rhs)
    {
        TypeCheck::get(__CLASS__)->objectComparisonStackKey(func_get_args());

        $ids = array(
            spl_object_hash($lhs),
            spl_object_hash($rhs)
        );
        sort($ids);

        return implode('.', $ids);
    }

    private $typeCheck;
    private $objectComparisonStack;
}
