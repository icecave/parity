<?php

namespace Icecave\Parity\Comparator;

/**
 * A comparator that compares objects by identity.
 */
class ObjectIdentityComparator implements Comparator
{
    /**
     * @param Comparator $fallbackComparator The comparator to use for non-objects.
     */
    public function __construct(Comparator $fallbackComparator)
    {
        $this->fallbackComparator = $fallbackComparator;
    }

    /**
     * Fetch the fallback comparator.
     *
     * @return Comparator The comparator to use for non-objects.
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
     * If either of the operands is not an object the fallback comparator is
     * used.
     *
     * @param mixed $lhs The first value to compare.
     * @param mixed $rhs The second value to compare.
     *
     * @return int The result of the comparison.
     */
    public function compare($lhs, $rhs): int
    {
        if (!is_object($lhs) || !is_object($rhs)) {
            return $this->fallbackComparator()->compare($lhs, $rhs);
        }

        return strcmp(
            spl_object_hash($lhs),
            spl_object_hash($rhs)
        );

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

    private $fallbackComparator;
}
