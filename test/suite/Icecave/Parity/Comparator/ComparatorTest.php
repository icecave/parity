<?php
namespace Icecave\Parity\Comparator;

use Icecave\Parity\TestFixture\ParentObject;
use PHPUnit_Framework_TestCase;
use stdClass;

class ComparatorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->comparator = new Comparator;
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
}
