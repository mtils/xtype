<?php
/**
 *
 * Created by mtils on 01.05.2024 at 09:03.
 **/

namespace XType\Test;

use PHPUnit\Framework\TestCase;
use XType\AbstractType;
use XType\SequenceType;

class DumbType extends AbstractType
{
    public function getGroup()
    {
        return 'simple';
    }

    public function valueToString($value)
    {
        return (string)$value;
    }
}

class SequenceTypeTest extends TestCase
{
    public function testInitialConditions()
    {
        $sequenceType = new SequenceType();

        // Check initial conditions
        $this->assertEquals([], $sequenceType->getDefaultValue());
        $this->assertEquals(0, $sequenceType->getMinItems());
        $this->assertEquals(1000000, $sequenceType->getMaxItems());
        $this->assertNull($sequenceType->getItemType());
    }

    public function testSetAndGetItemType()
    {
        $sequenceType = new SequenceType();
        $itemType = new DumbType();

        $sequenceType->setItemType($itemType);
        $this->assertSame($itemType, $sequenceType->getItemType());
    }

    public function testSetMinAndMaxItems()
    {
        $sequenceType = new SequenceType();

        // Set minimum and maximum items
        $sequenceType->setMinItems(1);
        $sequenceType->setMaxItems(10);

        // Check getters
        $this->assertEquals(1, $sequenceType->getMinItems());
        $this->assertEquals(10, $sequenceType->getMaxItems());
    }

    public function testValueToString()
    {
        $sequenceType = new SequenceType();
        $sequenceType->setItemType(new DumbType());

        $values = [1, 2, 3];
        $string = $sequenceType->valueToString($values);

        $this->assertEquals('1,2,3', $string);
    }

    public function testBoundaryConditions()
    {
        $sequenceType = new SequenceType();
        $sequenceType->setMinItems(5);
        $sequenceType->setMaxItems(5);

        // Check the edge cases for exact boundary conditions
        $this->assertEquals(5, $sequenceType->getMinItems());
        $this->assertEquals(5, $sequenceType->getMaxItems());
    }

    public function testValueToStringWithNoItems()
    {
        $sequenceType = new SequenceType();

        $values = [];
        $string = $sequenceType->valueToString($values);

        $this->assertEquals('', $string);
    }
}
