<?php
/**
 *
 * Created by mtils on 01.05.2024 at 08:57.
 **/

namespace XType\Test;

use PHPUnit\Framework\TestCase;
use XType\NumberType;

class NumberTypeTest extends TestCase {
    public function testDefaults() {
        $numberType = new NumberType();

        // Test default values
        $this->assertEquals(0, $numberType->getDefaultValue());
        $this->assertEquals('float', $numberType->getNativeType());
        $this->assertEquals(NumberType::$defaultMin, $numberType->getMin());
        $this->assertEquals(NumberType::$defaultMax, $numberType->getMax());
        $this->assertEquals(2, $numberType->getDecimalsCount()); // Default for float
    }

    public function testSettingValues() {
        $numberType = new NumberType();
        $numberType->setNativeType('int');
        $numberType->setNumberFormat('#.##');
        $numberType->setPrefix('$');
        $numberType->setSuffix(' USD');
        $numberType->setMin(-10);
        $numberType->setMax(10);
        $numberType->setDecimalsCount(0); // For int type
        $numberType->setDecimalsSeparator('.');
        $numberType->setThousandsSeparator(',');

        // Assert set values
        $this->assertEquals('int', $numberType->getNativeType());
        $this->assertEquals('#.##', $numberType->getNumberFormat());
        $this->assertEquals('$', $numberType->getPrefix());
        $this->assertEquals(' USD', $numberType->getSuffix());
        $this->assertEquals(-10, $numberType->getMin());
        $this->assertEquals(10, $numberType->getMax());
        $this->assertEquals(0, $numberType->getDecimalsCount());
        $this->assertEquals('.', $numberType->getDecimalsSeparator());
        $this->assertEquals(',', $numberType->getThousandsSeparator());
    }

    public function testValueToString() {
        $numberType = new NumberType();
        $numberType->setNativeType('int');
        $numberType->setPrefix('$');
        $numberType->setSuffix(' USD');
        $numberType->setDecimalsCount(0);

        $this->assertEquals('$123 USD', $numberType->valueToString(123.456)); // Test rounding for int
        $numberType->setNativeType('float');
        $numberType->setDecimalsCount(2);
        $this->assertEquals('$123.46 USD', $numberType->valueToString(123.456)); // Test floating point precision
    }

    public function testBoundaries() {
        $numberType = new NumberType();
        $numberType->setMin(0);
        $numberType->setMax(100);

        // Check values at boundary conditions
        $this->assertEquals(0, $numberType->getMin());
        $this->assertEquals(100, $numberType->getMax());
    }
}
