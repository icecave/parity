<?php

namespace Icecave\Parity\Comparator;

use ReflectionObject;

/**
 * A comparator that performs deep comparison of PHP arrays and objects.
 *
 * Comparison of objects is recursion-safe.
 */
class DeepComparator implements Comparator
{
    /**
     * If $relaxClassComparisons is true, class names are not included in the
     * comparison of objects.
     *
     * @param Comparator $fallbackComparator    The comparator to use when the operands are not arrays or objects.
     * @param bool       $relaxClassComparisons True to relax class name comparisons; false to compare strictly.
     */
    public function __construct(
        Comparator $fallbackComparator,
        $relaxClassComparisons = false
    ) {
        $this->fallbackComparator = $fallbackComparator;
        $this->relaxClassComparisons = $relaxClassComparisons;
    }

    /**
     * Fetch the fallback comparator.
     *
     * @return Comparator The comparator to use when the operands are not arrays or objects.
     */
    public function fallbackComparator(): Comparator
    {
        return $this->fallbackComparator;
    }

    /**
     * Compare two values, yielding a result according to the following table:
     *
     * +--------------------+---------------+
     * | Condition          | Result        |
     * +--------------------+---------------+
     * | $this == $value    | $result === 0 |
     * | $this < $value     | $result < 0   |
     * | $this > $value     | $result > 0   |
     * +--------------------+---------------+
     *
     * A deep comparison is performed if both operands are arrays, or both are
     * objects; otherwise, the fallback comparator is used.
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return int The result of the comparison.
     */
    public function compare($lhs, $rhs): int
    {
        $visitationContext = [];

        return $this->compareValue($lhs, $rhs, $visitationContext);
    }

    /**
     * An alias for compare().
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return int The result of the comparison.
     */
    public function __invoke($lhs, $rhs): int
    {
        return $this->compare($lhs, $rhs);
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     * @param mixed &$visitationContext
     *
     * @return int The result of the comparison.
     */
    protected function compareValue($lhs, $rhs, &$visitationContext): int
    {
        if (is_array($lhs) && is_array($rhs)) {
            return $this->compareArray($lhs, $rhs, $visitationContext);
        } elseif (is_object($lhs) && is_object($rhs)) {
            return $this->compareObject($lhs, $rhs, $visitationContext);
        }

        return $this->fallbackComparator()->compare($lhs, $rhs);
    }

    /**
     * @param array $lhs
     * @param array $rhs
     * @param mixed &$visitationContext
     *
     * @return int The result of the comparison.
     */
    protected function compareArray(array $lhs, array $rhs, &$visitationContext): int
    {
        reset($lhs);
        reset($rhs);

        while (true) {
            $lk = key($lhs);
            $rk = key($rhs);

            if ($lk === null && $rk === null) {
                break;
            } elseif ($lk === null) {
                return -1;
            } elseif ($rk === null) {
                return +1;
            }

            $cmp = $this->compareValue($lk, $rk, $visitationContext);
            if ($cmp !== 0) {
                return $cmp;
            }

            $lv = current($lhs);
            $rv = current($rhs);

            $cmp = $this->compareValue($lv, $rv, $visitationContext);
            if ($cmp !== 0) {
                return $cmp;
            }

            next($lhs);
            next($rhs);
        }

        return 0;
    }

    /**
     * @param object $lhs
     * @param object $rhs
     * @param mixed  &$visitationContext
     *
     * @return int The result of the comparison.
     */
    protected function compareObject($lhs, $rhs, &$visitationContext): int
    {
        if ($lhs === $rhs) {
            return 0;
        } elseif ($this->isNestedComparison($lhs, $rhs, $visitationContext)) {
            return strcmp(
                spl_object_hash($lhs),
                spl_object_hash($rhs)
            );
        } elseif (!$this->relaxClassComparisons) {
            $diff = strcmp(get_class($lhs), get_class($rhs));
            if ($diff !== 0) {
                return $diff;
            }
        }

        return $this->compareArray(
            $this->objectProperties($lhs, $visitationContext),
            $this->objectProperties($rhs, $visitationContext),
            $visitationContext
        );
    }

    /**
     * @param object $object
     * @param mixed  &$visitationContext
     *
     * @return array<string,mixed>
     */
    protected function objectProperties($object, &$visitationContext): array
    {
        $properties = [];
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
     * @param mixed $lhs
     * @param mixed $rhs
     * @param mixed &$visitationContext
     *
     * @return bool
     */
    protected function isNestedComparison($lhs, $rhs, &$visitationContext): bool
    {
        $key = spl_object_hash($lhs) . ':' . spl_object_hash($rhs);

        if (array_key_exists($key, $visitationContext)) {
            return true;
        }

        $visitationContext[$key] = true;

        return false;
    }

    private $fallbackComparator;
    private $relaxClassComparisons;
}
