<?php
/**
 *
 * Created by mtils on 01.05.2024 at 08:43.
 **/

namespace XType\Test;

use PHPUnit\Framework\TestCase;
use XType\AbstractType;

class ConcreteType extends AbstractType {
    public function getGroup() {
        return 'test_group';
    }

    public function valueToString($value) {
        return (string)$value;
    }
}

class AbstractTypeTest extends TestCase {
    public function testCanBeNull() {
        $type = new ConcreteType();
        $this->assertTrue($type->getCanBeNull()); // Default is true

        $type->setCanBeNull(false);
        $this->assertFalse($type->getCanBeNull());
    }

    public function testDefaultValue() {
        $type = new ConcreteType();
        $this->assertNull($type->getDefaultValue()); // Default is null

        $type->setDefaultValue('default');
        $this->assertEquals('default', $type->getDefaultValue());
    }

    public function testForceInteraction() {
        $type = new ConcreteType();
        $this->assertFalse($type->getForceInteraction()); // Default is false

        $type->setForceInteraction(true);
        $this->assertTrue($type->getForceInteraction());
    }

    public function testMagicGet() {
        $type = new ConcreteType();
        $type->setDefaultValue('magic');

        $this->assertEquals('magic', $type->defaultValue); // Testing magic __get
    }

    public function testInvoke() {
        $type = new ConcreteType();
        $result = $type(123); // Testing __invoke

        $this->assertEquals('123', $result);
    }

    public function testCastToView() {
        $type = new ConcreteType();
        $this->assertEquals('test', $type->castToView('test'));
    }

    public function testCastToModel() {
        $type = new ConcreteType();
        $this->assertEquals(123, $type->castToModel(123));
    }
}
