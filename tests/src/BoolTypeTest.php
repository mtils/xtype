<?php

namespace XType\Test;

use PHPUnit\Framework\TestCase;
use XType\BoolType;

class BoolTypeTest extends TestCase {
    public function testDefaultValue() {
        $boolType = new BoolType();
        $this->assertFalse($boolType->getDefaultValue()); // Default is false
    }

    public function testGroup() {
        $boolType = new BoolType();
        $this->assertEquals(BoolType::BOOL, $boolType->getGroup());
    }

    public function testValueToString() {
        $boolType = new BoolType();
        $boolType->setTrueString("Yes");
        $boolType->setFalseString("No");

        $this->assertEquals("Yes", $boolType->valueToString(true));
        $this->assertEquals("No", $boolType->valueToString(false));
    }

    public function testCustomStringValues() {
        $boolType = new BoolType();
        $boolType->setTrueString("Custom True");
        $boolType->setFalseString("Custom False");

        $this->assertEquals("Custom True", $boolType->getTrueString());
        $this->assertEquals("Custom False", $boolType->getFalseString());
    }

    public function testCastToBool() {
        $boolType = new BoolType();

        // Test different inputs
        $this->assertTrue($boolType->castToBool(1));
        $this->assertFalse($boolType->castToBool(0));
        $this->assertTrue($boolType->castToBool("true"));
        $this->assertFalse($boolType->castToBool("false"));
        $this->assertFalse($boolType->castToBool("no"));
        $this->assertTrue($boolType->castToBool("yes"));
        $this->assertTrue($boolType->castToBool("anything else"));
        $this->assertFalse($boolType->castToBool("0"));
    }

    public function testDefaultStringValues() {
        $boolType = new BoolType();
        $this->assertEquals("true", $boolType->getTrueString());
        $this->assertEquals("false", $boolType->getFalseString());
    }

    public function testInvoke() {
        $boolType = new BoolType();
        $boolType->setTrueString("Affirmative");
        $boolType->setFalseString("Negative");

        $this->assertEquals("Affirmative", $boolType(true));
        $this->assertEquals("Negative", $boolType(false));
    }
}
