<?php
/**
 *
 * Created by mtils on 01.05.2024 at 08:53.
 **/

namespace XType\Test;

use BadMethodCallException;use OutOfBoundsException;use PHPUnit\Framework\TestCase;
use stdClass;use XType\AbstractType;
use XType\NamedFieldType;

class SimpleType extends AbstractType {
    public function getGroup() {
        return 'simple';
    }

    public function valueToString($value) {
        return strval($value);
    }
}

class NamedFieldTypeTest extends TestCase {
    public function testEmptyInitially() {
        $namedFieldType = new NamedFieldType();
        $this->assertCount(0, $namedFieldType);
    }

    public function testAddingAndAccessingTypes() {
        $namedFieldType = new NamedFieldType();
        $type = new SimpleType();

        $namedFieldType->set('key1', $type);
        $this->assertTrue($namedFieldType->offsetExists('key1'));
        $this->assertSame($type, $namedFieldType['key1']);
    }

    public function testUnsettingType() {
        $namedFieldType = new NamedFieldType();
        $type = new SimpleType();

        $namedFieldType->set('key1', $type);
        $namedFieldType->offsetUnset('key1');

        $this->assertFalse(isset($namedFieldType['key1']));
    }

    public function testCountable() {
        $namedFieldType = new NamedFieldType();
        $namedFieldType->set('key1', new SimpleType());
        $namedFieldType->set('key2', new SimpleType());

        $this->assertCount(2, $namedFieldType);
    }

    public function testIterator() {
        $namedFieldType = new NamedFieldType();
        $namedFieldType->set('key1', new SimpleType());
        $namedFieldType->set('key2', new SimpleType());

        $keys = [];
        foreach ($namedFieldType as $key => $type) {
            $keys[] = $key;
        }

        $this->assertEquals(['key1', 'key2'], $keys);
    }

    public function testValueToString() {
        $namedFieldType = new NamedFieldType();
        $type = new SimpleType();
        $namedFieldType->set('key1', $type);

        $value = ['key1' => 123];
        $string = $namedFieldType->valueToString($value);

        $this->assertStringContainsString('key1 123', $string);
    }

    public function testGetWithInvalidKey() {
        $this->expectException(OutOfBoundsException::class);
        $namedFieldType = new NamedFieldType();
        $namedFieldType->get('nonexistent_key');
    }

}
