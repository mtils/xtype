<?php
/**
 *
 * Created by mtils on 01.05.2024 at 09:09.
 **/

namespace XType\Test;

use PHPUnit\Framework\TestCase;
use XType\UnitType;

class UnitTypeTest extends TestCase {
    public function testDefaultValue() {
        $unitType = new UnitType();
        $this->assertEquals(0.0, $unitType->getDefaultValue());
    }

    public function testUnitHandling() {
        $unitType = new UnitType();
        $unitType->setUnit('kg');
        $unitType->setValueUnitGap(1);

        $this->assertEquals('kg', $unitType->getUnit());
        $this->assertEquals(1, $unitType->getValueUnitGap());
    }

    public function testUnitPositioning() {
        $unitType = new UnitType();
        $unitType->setUnit('kg');
        $unitType->prependUnit();

        $this->assertEquals(UnitType::PREPEND, $unitType->getUnitPosition());

        $unitType->appendUnit();
        $this->assertEquals(UnitType::APPEND, $unitType->getUnitPosition());
    }

    public function testValueToString() {
        $unitType = new UnitType();
        $unitType->setUnit('kg');
        $unitType->setUnitPosition(UnitType::APPEND);
        $unitType->setValueUnitGap(1);

        // Testing append position
        $this->assertEquals('123.00 kg', $unitType->valueToString(123));

        // Testing prepend position
        $unitType->prependUnit();
        $this->assertEquals('kg 123.00', $unitType->valueToString(123));
    }

    public function testNoUnit() {
        $unitType = new UnitType();
        $unitType->setUnit('');
        $unitType->setDecimalsCount(0);
        $this->assertEquals('123', $unitType->valueToString(123));
    }

    public function testMaxLengthHandling() {
        $unitType = new UnitType();
        $unitType->setMaxLength(10);

        $this->assertEquals(10, $unitType->getMaxLength());
    }

    public function testMinLengthHandling() {
        $unitType = new UnitType();
        $unitType->setMinLength(1); // Assuming this should store value even though no actual property

        $this->assertEquals(1, $unitType->getMinLength());
    }
}
