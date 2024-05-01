<?php

namespace XType\Test\Factory;

use PHPUnit\Framework\TestCase;
use XType\Factory\TemplateFactory;
use DateTime;

class TemplateFactoryTest extends TestCase
{

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(
            'XType\Factory\FactoryInterface',
            new TemplateFactory
        );
    }

    public function testCreateBoolean()
    {
        $factory = new TemplateFactory();

        $this->assertTrue($factory->canCreate(true));

        $boolType = $factory->create(true);

        $this->assertInstanceOf('XType\BoolType', $boolType);

        $this->assertTrue($boolType->getDefaultValue());

        $boolType = $factory->create(false);

        $this->assertInstanceOf('XType\BoolType', $boolType);

        $this->assertFalse($boolType->getDefaultValue());
    }

    public function testCreateIntegerType()
    {
        $factory = new TemplateFactory();

        $testInt = 44;

        $this->assertTrue($factory->canCreate($testInt));

        $intType = $factory->create($testInt);

        $this->assertInstanceOf('XType\NumberType', $intType);

        $this->assertEquals($testInt, $intType->getDefaultValue());

        $this->assertEquals('int', $intType->getNativeType());
    }

    public function testCreateFloatType()
    {
        $factory = new TemplateFactory();

        $testFloat = 44.7;

        $this->assertTrue($factory->canCreate($testFloat));

        $floatType = $factory->create($testFloat);

        $this->assertInstanceOf('XType\NumberType', $floatType);

        $this->assertEquals($testFloat, $floatType->getDefaultValue());

        $this->assertEquals('float', $floatType->getNativeType());
    }

    public function testCreateStringType()
    {
        $factory = new TemplateFactory();

        $testString = 'foo';

        $this->assertTrue($factory->canCreate($testString));

        $stringType = $factory->create($testString);

        $this->assertInstanceOf('XType\StringType', $stringType);

        $this->assertEquals($testString, $stringType->getDefaultValue());
    }

    public function testCreateTemporalType()
    {
        $factory = new TemplateFactory();

        $testDate = new DateTime('1976-05-31 14:15:00');

        $this->assertTrue($factory->canCreate($testDate));

        $temporalType = $factory->create($testDate);

        $this->assertInstanceOf('XType\TemporalType', $temporalType);

        $this->assertEquals(
            $testDate->getTimestamp(),
            $temporalType->getDefaultValue()->getTimestamp()
        );
    }

    public function testCreateSequenceType()
    {
        $factory = new TemplateFactory();

        $testSequence = [];

        $this->assertTrue($factory->canCreate($testSequence));

        $sequenceType = $factory->create($testSequence);

        $this->assertInstanceOf('XType\SequenceType', $sequenceType);

        $this->assertEquals($testSequence, $sequenceType->getDefaultValue());
    }

    public function testCreateNamedFieldType()
    {
        $factory = new TemplateFactory();

        $testDict = [
            'foo' => 'bar',
            'bool' => false
        ];

        $this->assertTrue($factory->canCreate($testDict));

        $dictType = $factory->create($testDict);

        $this->assertInstanceOf('XType\NamedFieldType', $dictType);

        $this->assertInstanceOf('XType\StringType', $dictType->get('foo'));

        $this->assertEquals(
            $testDict['foo'],
            $dictType->get('foo')->getDefaultValue()
        );

        $this->assertInstanceOf('XType\BoolType', $dictType->get('bool'));

        $this->assertEquals(
            $testDict['bool'],
            $dictType->get('bool')->getDefaultValue()
        );
    }

    public function testCreateComplexType()
    {
        $factory = new TemplateFactory();

        $testDict = [
            'bool' => false,
            'string' => 'foo',
            'items' => [
                [
                    'age' => 36,
                    'birthday' => new DateTime('1976-05-31 14:15:00')
                ]
            ]
        ];


        $this->assertTrue($factory->canCreate($testDict));

        $dictType = $factory->create($testDict);

        $this->assertInstanceOf('XType\NamedFieldType', $dictType);

        $this->assertInstanceOf('XType\BoolType', $dictType->get('bool'));
        $this->assertInstanceOf('XType\StringType', $dictType->get('string'));

        $itemsType = $dictType->get('items');

        $this->assertInstanceOf('XType\SequenceType', $itemsType);

        $itemsSubType = $itemsType->getItemType();

        $this->assertInstanceOf('XType\NamedFieldType', $itemsSubType);

        $this->assertEquals(
            $testDict['items'][0],
            $itemsSubType->getDefaultValue()
        );

        $ageType = $itemsSubType->get('age');

        $this->assertInstanceOf('XType\NumberType', $ageType);

        $this->assertEquals('int', $ageType->getNativeType());

        $this->assertEquals(
            $testDict['items'][0]['age'],
            $ageType->getDefaultValue()
        );

        $birthdayType = $itemsSubType->get('birthday');

        $this->assertInstanceOf('XType\TemporalType', $birthdayType);

        $this->assertEquals(
            $testDict['items'][0]['birthday']->getTimestamp(),
            $birthdayType->getDefaultValue()->getTimestamp()
        );
    }

}
