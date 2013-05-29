<?php
namespace Icecave\Parity\Comparator;

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

        $this->visitedObjects = array();

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

        if (gettype($lhs) !== gettype($rhs)) {
            return strcmp(gettype($lhs), gettype($rhs));
        }

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

        $diff = count($lhs) - count($rhs);
        if ($diff !== 0) {
            return $diff;
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

        return $this->compareArray(
            $this->objectProperties($lhs),
            $this->objectProperties($rhs)
        );
    }

    /**
     * @param object $object
     *
     * @return array<string,mixed>
     */
    protected function objectProperties($object)
    {
        TypeCheck::get(__CLASS__)->objectProperties(func_get_args());

        $hashKey = spl_object_hash($object);
        if (in_array($hashKey, $this->visitedObjects)) {
            // To deal with infinite recursion just return the object hash for the properties.
            return array(get_class($object) => $hashKey);
        } else {
            $this->visitedObjects[] = $hashKey;
        }

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

    private $typeCheck;
    private $visitedObjects;
}
