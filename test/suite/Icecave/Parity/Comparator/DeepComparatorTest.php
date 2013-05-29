<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\TestFixture\ParentObject;
use Icecave\Parity\TestFixture\ChildObject;
use PHPUnit_Framework_TestCase;
use stdClass;

class DeepComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = new DeepComparator;
    }

    /**
     * @dataProvider differentTypesCompare
     */
    public function testDefaultCompareDifferentTypes($less, $greater)
    {
        $this->assertLessThan(0, $this->comparator->compare($less, $greater));
        $this->assertGreaterThan(0, $this->comparator->compare($greater, $less));
    }

    public function differentTypesCompare()
    {
        $stdClassOne = new stdClass;
        $stdClassOne->foo = 1;

        $leftTypes = array(
            'Null' => null,
            'Boolean False'     => false,
            'Boolean True'      => true,
            'Integer Zero'      => 0,
            'Integer One'       => 1,
            'Double Zero'       => 0.0,
            'Double One'        => 1.0,
            'String Empty'      => '',
            'String Space'      => ' ',
            'String Zero'       => '0',
            'Array Empty'       => array(),
            'Array Zero'        => array(0),
            'Array One'         => array(1),
            'StdClass Empty'    => new stdClass,
            'StdClass One'      => $stdClassOne,
            'Class Empty'       => new ParentObject(null, null),
            'Class Zero'        => new ParentObject(0, 0),
            'Class One'         => new ParentObject(1, 1),
        );
        $rightTypes = $leftTypes;

        $compare = array();
        foreach ($leftTypes as $leftName => $leftValue) {
            foreach ($rightTypes as $rightName => $rightValue) {
                $leftTypeName = gettype($leftValue);
                $rightTypeName = gettype($rightValue);
                if ($leftTypeName === $rightTypeName) {
                    // Skip same types for this test.
                    continue;
                }
                $description = $leftName . ' and ' . $rightName;

                // Type names will be used for the compare.
                if (strcmp($leftTypeName, $rightTypeName) < 0) {
                    $compare[$description] = array($leftValue, $rightValue);
                } else {
                    $compare[$description] = array($rightValue, $leftValue);
                }
            }
        }

        return $compare;
    }

    public function testDefaultCompare()
    {
        $this->assertSame(0, $this->comparator->compare(0, 0));
        $this->assertLessThan(0, $this->comparator->compare(-1, 0));
        $this->assertGreaterThan(0, $this->comparator->compare(1, 0));
    }

    public function testDefaultCompareNull()
    {
        $this->assertSame(0, $this->comparator->compare(null, null));
    }

    public function testDefaultCompareBoolean()
    {
        $this->assertSame(0, $this->comparator->compare(true, true));
        $this->assertSame(0, $this->comparator->compare(false, false));

        $this->assertLessThan(0, $this->comparator->compare(false, true));
        $this->assertGreaterThan(0, $this->comparator->compare(true, false));
    }

    public function testDefaultCompareInteger()
    {
        $this->assertSame(0, $this->comparator->compare(0, 0));
        $this->assertSame(0, $this->comparator->compare(2, 2));

        $this->assertLessThan(0, $this->comparator->compare(0, 1));
        $this->assertLessThan(0, $this->comparator->compare(0, 2));
        $this->assertLessThan(0, $this->comparator->compare(1, 2));

        $this->assertGreaterThan(0, $this->comparator->compare(2, 1));
        $this->assertGreaterThan(0, $this->comparator->compare(2, 0));
        $this->assertGreaterThan(0, $this->comparator->compare(1, 0));
    }

    public function testDefaultCompareFloat()
    {
        $this->assertSame(0, $this->comparator->compare(0.0, 0.0));
        $this->assertSame(0, $this->comparator->compare(2.2, 2.2));

        $this->assertLessThan(0, $this->comparator->compare(0.0, 1.1));
        $this->assertLessThan(0, $this->comparator->compare(0.0, 2.2));
        $this->assertLessThan(0, $this->comparator->compare(1.1, 2.2));

        $this->assertGreaterThan(0, $this->comparator->compare(2.2, 1.1));
        $this->assertGreaterThan(0, $this->comparator->compare(2.2, 0.0));
        $this->assertGreaterThan(0, $this->comparator->compare(1.1, 0.0));
    }

    public function testDefaultCompareString()
    {
        $this->assertSame(0, $this->comparator->compare('', ''));
        $this->assertSame(0, $this->comparator->compare('0', '0'));
        $this->assertSame(0, $this->comparator->compare(' ', ' '));
        $this->assertSame(0, $this->comparator->compare('foo', 'foo'));

        $this->assertLessThan(0, $this->comparator->compare('A', 'B'));
        $this->assertLessThan(0, $this->comparator->compare('A', 'C'));
        $this->assertLessThan(0, $this->comparator->compare('B', 'C'));

        $this->assertGreaterThan(0, $this->comparator->compare('C', 'B'));
        $this->assertGreaterThan(0, $this->comparator->compare('C', 'A'));
        $this->assertGreaterThan(0, $this->comparator->compare('B', 'A'));
    }

    public function testDefaultCompareBasic()
    {
        $this->assertSame(0, $this->comparator->compare(0, 0));
        $this->assertLessThan(0, $this->comparator->compare(-1, 0));
        $this->assertGreaterThan(0, $this->comparator->compare(1, 0));
    }

    public function testDefaultCompareWithArrayAndNonArray()
    {
        $array = array('foo');
        $nonArray = 123;

        $this->assertSame(0, $this->comparator->compare($array, $array));
        $this->assertSame(0, $this->comparator->compare($nonArray, $nonArray));

        $this->assertLessThan(0, $this->comparator->compare($array, $nonArray));
        $this->assertGreaterThan(0, $this->comparator->compare($nonArray, $array));
    }

    public function testDefaultCompareWithArrays()
    {
        $ab  = array('a', 'b');
        $abc = array('a', 'b', 'c');
        $bc  = array('b', 'c');
        $bx  = array('b', 'x');

        $this->assertSame(0, $this->comparator->compare(array(), array()));
        $this->assertSame(0, $this->comparator->compare($abc, array('a', 'b', 'c')));
        $this->assertSame(0, $this->comparator->compare($abc, $abc));

        $this->assertLessThan(0, $this->comparator->compare(array(), $abc));
        $this->assertLessThan(0, $this->comparator->compare($ab, $abc));
        $this->assertLessThan(0, $this->comparator->compare($bc, $abc));
        $this->assertLessThan(0, $this->comparator->compare($bc, $bx));

        $this->assertGreaterThan(0, $this->comparator->compare($abc, array()));
        $this->assertGreaterThan(0, $this->comparator->compare($abc, $ab));
        $this->assertGreaterThan(0, $this->comparator->compare($abc, $bc));
        $this->assertGreaterThan(0, $this->comparator->compare($bx, $bc));
    }

    public function testDefaultCompareWithAsocArrays()
    {
        $ab  = array('a' => 1, 'b' => 2);
        $abc = array('a' => 1, 'b' => 2, 'c' => 3);
        $bc  = array('b' => 2, 'c' => 3);
        $bx  = array('b' => 2, 'x' => 3);

        $this->assertSame(0, $this->comparator->compare($abc, $abc));
        $this->assertSame(0, $this->comparator->compare($abc, array('a' => 1, 'b' => 2, 'c' => 3)));

        $this->assertLessThan(0, $this->comparator->compare(array(), $abc));
        $this->assertLessThan(0, $this->comparator->compare($ab, $abc));
        $this->assertLessThan(0, $this->comparator->compare($bc, $abc));
        $this->assertLessThan(0, $this->comparator->compare($bc, $bx));

        $this->assertGreaterThan(0, $this->comparator->compare($abc, array()));
        $this->assertGreaterThan(0, $this->comparator->compare($abc, $ab));
        $this->assertGreaterThan(0, $this->comparator->compare($abc, $bc));
        $this->assertGreaterThan(0, $this->comparator->compare($bx, $bc));
    }

    public function testDefaultCompareWithObjectAndNonObjectScalar()
    {
        $object = new stdClass;
        $scalar = 123;

        $this->assertSame(0, $this->comparator->compare($object, $object));
        $this->assertSame(0, $this->comparator->compare($scalar, $scalar));

        $this->assertLessThan(0, $this->comparator->compare($scalar, $object));
        $this->assertGreaterThan(0, $this->comparator->compare($object, $scalar));
    }

    public function testDefaultCompareWithObjectAndNonObjectArray()
    {
        $object = new stdClass;
        $array = array();

        $this->assertSame(0, $this->comparator->compare($object, $object));
        $this->assertSame(0, $this->comparator->compare($array, $array));

        $this->assertLessThan(0, $this->comparator->compare($array, $object));
        $this->assertGreaterThan(0, $this->comparator->compare($object, $array));
    }

    public function testDefaultCompareWithObjectsDifferentClassTypes()
    {
        $obj1 = new stdClass;
        $obj2 = new ParentObject(0, 0);

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        $this->assertLessThan(0, $this->comparator->compare($obj2, $obj1));
        $this->assertGreaterThan(0, $this->comparator->compare($obj1, $obj2));
    }

    public function testDefaultCompareWithObjectsDifferentInnerClassTypes()
    {
        $obj1 = new stdClass;
        $obj1->foo = new stdClass;

        $obj2 = new stdClass;
        $obj2->foo = new ParentObject(0, 0);

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        $this->assertLessThan(0, $this->comparator->compare($obj2, $obj1));
        $this->assertGreaterThan(0, $this->comparator->compare($obj1, $obj2));
    }

    public function testDefaultCompareWithObjectsParentAndDerived()
    {
        $obj1 = new ParentObject(0, 0);
        $obj2 = new ChildObject(0, 0);

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        $this->assertLessThan(0, $this->comparator->compare($obj2, $obj1));
        $this->assertGreaterThan(0, $this->comparator->compare($obj1, $obj2));
    }

    public function testDefaultCompareWithSimpleObjects()
    {
        $obj1  = new stdClass;
        $obj1->prop1 = 'foo';
        $obj1->prop2 = 0;
        $obj1->prop3 = 999;

        $obj2  = new stdClass;
        $obj2->prop1 = 'foo';
        $obj2->prop2 = 1;
        $obj2->prop3 = 900;

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));

        $obj2->prop2 = 0;

        $this->assertGreaterThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertLessThan(0, $this->comparator->compare($obj2, $obj1));

        $obj2->prop3 = 999;

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj1, $obj2));
    }

    public function testDefaultCompareWithSimpleObjectsHavingDifferentTotalProperties()
    {
        $obj1  = new stdClass;
        $obj1->prop1 = 'foo';
        $obj1->prop2 = 0;
        $obj1->prop3 = 999;

        $obj2  = new stdClass;
        $obj2->prop = 1;

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        $this->assertLessThan(0, $this->comparator->compare($obj2, $obj1));
        $this->assertGreaterThan(0, $this->comparator->compare($obj1, $obj2));
    }

    public function testDefaultCompareWithObjects()
    {
        $obj1 = new ParentObject(111, 'foo');
        $obj2 = new ParentObject(222, 'bar');

        $obj3 = new ChildObject(333, 'foo');
        $obj4 = new ChildObject(444, 'bar');

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj3, $obj3));

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));

        $this->assertLessThan(0, $this->comparator->compare($obj3, $obj4));
        $this->assertGreaterThan(0, $this->comparator->compare($obj4, $obj3));
    }

    public function testDefaultCompareWithObjectsHavingUndeclaredProperties()
    {
        $obj1 = new ParentObject(111, 'foo');
        $obj2 = new ParentObject(222, 'bar');

        $obj1->jazzUndeclared = 'jazz1';
        $obj2->jazzUndeclared = 'jazz2';

        $obj3 = new ChildObject(333, 'foo');
        $obj4 = new ChildObject(444, 'bar');

        $obj3->jazzUndeclared = 'jazz3';
        $obj4->jazzUndeclared = 'jazz4';

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj3, $obj3));

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));

        $this->assertLessThan(0, $this->comparator->compare($obj3, $obj4));
        $this->assertGreaterThan(0, $this->comparator->compare($obj4, $obj3));
    }

    public function testDefaultCompareWithObjectsHavingSharedInnerObject()
    {
        $shared = new ParentObject('foo', 'bar');

        $obj1 = new ParentObject(111, $shared);
        $obj2 = new ParentObject(222, $shared);

        $obj3 = new ChildObject(333, $shared);
        $obj4 = new ChildObject(444, $shared);

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj3, $obj3));

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));

        $this->assertLessThan(0, $this->comparator->compare($obj3, $obj4));
        $this->assertGreaterThan(0, $this->comparator->compare($obj4, $obj3));
    }

    public function testDefaultCompareWithSimpleObjectsRecursion()
    {
        $obj1 = new stdClass;
        $obj1->foo = $obj1;
        $obj1->bar = 1;

        $obj2 = new stdClass;
        $obj2->foo = $obj2;
        $obj2->bar = 2;

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

    public function testDefaultCompareWithSimpleObjectsDoubleRecursion()
    {
        $obj1 = new stdClass;
        $obj1->recurse = new stdClass;
        $obj1->recurse->recurse = $obj1;
        $obj1->value = 1;

        $obj2 = new stdClass;
        $obj2->recurse = new stdClass;
        $obj2->recurse->recurse = $obj2;
        $obj2->value = 2;

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        // The first property compared is infinitely recusive, so just the hash will be used.
        // Since the hash's wont match the 'value' property will not be compared.
        if (spl_object_hash($obj1) < spl_object_hash($obj2)) {
            $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
            $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));
        } else {
            $this->assertLessThan(0, $this->comparator->compare($obj2, $obj1));
            $this->assertGreaterThan(0, $this->comparator->compare($obj1, $obj2));
        }
    }

    public function testDefaultCompareWithSimpleObjectsBothHavingObject1AsFirstProperty()
    {
        $obj1 = new stdClass;
        $obj1->foo = $obj1;
        $obj1->bar = 1;

        $obj2 = new stdClass;
        $obj2->foo = $obj1;
        $obj2->bar = 2;

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));
    }

    public function testDefaultCompareWithSimpleObjectsCrossReference()
    {
        $obj1 = new stdClass;
        $obj2 = new stdClass;

        $obj1->foo = $obj2;
        $obj2->foo = $obj1;

        $obj2->bar = 2;

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj2, $obj2));

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));
    }

    public function testDefaultCompareWithObjectsRecursive()
    {
        $obj1 = new stdClass;
        $obj1->foo = new ParentObject('foo1', $obj1);

        $obj2 = new stdClass;
        $obj2->foo = new ParentObject('foo2', $obj2);

        $obj3 = new stdClass;
        $obj3->foo = new ChildObject('bar3', $obj1);

        $obj4 = new stdClass;
        $obj4->foo = new ChildObject('bar4', $obj2);

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj3, $obj3));

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj2));
        $this->assertGreaterThan(0, $this->comparator->compare($obj2, $obj1));

        $this->assertLessThan(0, $this->comparator->compare($obj3, $obj4));
        $this->assertGreaterThan(0, $this->comparator->compare($obj4, $obj3));
    }

    public function testDefaultCompareWithObjectsHavingInternalArraysAndObjects()
    {
        $shared = new ChildObject('foo', 'bar');

        $obj1 = new ParentObject(array('a', 'b'), array($shared, 'foo'));
        $obj2 = new ParentObject(array('a', 'b'), array($shared, 'foo'));
        $obj3 = new ParentObject(array('x', 'y'), array($shared, 'foo'));

        $this->assertSame(0, $this->comparator->compare($obj1, $obj1));
        $this->assertSame(0, $this->comparator->compare($obj1, $obj2));
        $this->assertSame(0, $this->comparator->compare($obj3, $obj3));

        $this->assertLessThan(0, $this->comparator->compare($obj1, $obj3));
        $this->assertGreaterThan(0, $this->comparator->compare($obj3, $obj1));
    }
}
