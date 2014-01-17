<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\AnyComparableInterface;
use Icecave\Parity\RestrictedComparableInterface;
use Icecave\Parity\SelfComparableInterface;
use Icecave\Parity\SubClassComparableInterface;
use ReflectionMethod;

/**
 * A comparator that dispatches comparison operations to the appropriate
 * algorithm based on the comparable interfaces that the operands implement.
 */
class ParityComparator implements ComparatorInterface
{
    /**
     * @param ComparatorInterface $fallbackComparator The comparator to use when the operands do not provide their own comparison algorithm.
     */
    public function __construct(ComparatorInterface $fallbackComparator)
    {
        $this->fallbackComparator = $fallbackComparator;
        $this->compareImplementationClasses = array();
    }

    /**
     * Fetch the fallback comparator.
     *
     * @return ComparatorInterface The comparator to use when the operands do not provide their own comparison algorithm.
     */
    public function fallbackComparator()
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
     * If either of the operands implements one of the Parity comparator
     * interfaces and is able to perform the comparison to the other operand
     * its compare() method is used to perform the comparison. If neither
     * operand provides a suitable implementation, the fallback comparator is
     * used.
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return integer The result of the comparison.
     */
    public function compare($lhs, $rhs)
    {
        if ($this->canCompare($lhs, $rhs)) {
            return $lhs->compare($rhs);
        } elseif ($this->canCompare($rhs, $lhs)) {
            return -$rhs->compare($lhs);
        }

        return $this->fallbackComparator()->compare($lhs, $rhs);
    }

    /**
     * An alias for compare().
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return integer The result of the comparison.
     */
    public function __invoke($lhs, $rhs)
    {
        return $this->compare($lhs, $rhs);
    }

    /**
     * Check if one value can be compared to another.
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return boolean
     */
    protected function canCompare($lhs, $rhs)
    {
        if ($lhs instanceof AnyComparableInterface) {
            return true;
        } elseif ($lhs instanceof RestrictedComparableInterface && $lhs->canCompare($rhs)) {
            return true;
        } elseif ($lhs instanceof SelfComparableInterface) {
            return is_object($rhs)
                && get_class($lhs) === get_class($rhs);
        } elseif ($lhs instanceof SubClassComparableInterface) {
            $className = $this->compareImplementationClass($lhs);

            return $rhs instanceof $className;
        }

        return false;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    protected function compareImplementationClass($value)
    {
        $className = get_class($value);

        if (array_key_exists($className, $this->compareImplementationClasses)) {
            return $this->compareImplementationClasses[$className];
        }

        $reflector = new ReflectionMethod($value, 'compare');
        $declaringClassName = $reflector->getDeclaringClass()->getName();
        $this->compareImplementationClasses[$className] = $declaringClassName;

        return $declaringClassName;
    }

    private $fallbackComparator;
    private $compareImplementationClasses;
}
