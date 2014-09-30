<?php
namespace Icecave\Parity\Comparator;

use Phake;
use PHPUnit_Framework_TestCase;
use stdClass;

class ObjectIdentityComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->fallbackComparator = Phake::mock(__NAMESPACE__ . '\ComparatorInterface');
        $this->comparator = new ObjectIdentityComparator($this->fallbackComparator);

        Phake::when($this->fallbackComparator)
            ->compare(Phake::anyParameters())
            ->thenReturn(-1);
    }

    public function testInvoke()
    {
        $this->assertSame(
            -1,
            call_user_func(
                $this->comparator,
                array(1, 2, 3),
                array(1, 2, 3)
            )
        );
    }

    public function testCompare()
    {
        $obj1 = new stdClass();
        $obj2 = new stdClass();

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        // The first property compared is infinitely recusive, so just the hash will be used.
        // Since the hash's wont match the 'bar' property will not be compared.
        if (spl_object_hash($obj1) < spl_object_hash($obj2)) {
            $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
            $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));
        } else {
            $this->assertLessThan(0, $this->comparator->compare($obj2, $obj1));
            $this->assertGreaterThan(0, $this->comparator->compare($obj1, $obj2));
        }
    }

    public function testCompareWithFallback()
    {
        $lhs = new stdClass();

        $result = $this->comparator->compare($lhs, 20);

        Phake::verify($this->fallbackComparator)->compare($lhs, 20);

        $this->assertSame($result, -1);
    }
}
