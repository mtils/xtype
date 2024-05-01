<?php
/**
 *
 * Created by mtils on 01.05.2024 at 09:06.
 **/

namespace XType\Test;


use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use XType\TemporalType;
use DateTime;

class TemporalTypeTest extends TestCase
{
    public function testDefaultValue()
    {
        $temporalType = new TemporalType();
        $defaultValue = $temporalType->getDefaultValue();

        $this->assertInstanceOf(DateTime::class, $defaultValue);
        $this->assertEquals(
            (new DateTime())->format(DateTimeInterface::ATOM),
            $defaultValue->format(DateTimeInterface::ATOM)
        );
    }

    public function testFormatHandling()
    {
        $temporalType = new TemporalType();
        $temporalType->setFormat(DateTimeInterface::RFC2822);

        $this->assertEquals(DateTimeInterface::RFC2822, $temporalType->getFormat());
    }

    public function testDefaultFormat()
    {
        $temporalType = new TemporalType();

        $this->assertEquals(DateTime::ATOM, $temporalType->getFormat());
    }

    public function testMinMaxConstraints()
    {
        $temporalType = new TemporalType();
        $minDate = new DateTime('2020-01-01');
        $maxDate = new DateTime('2020-12-31');

        $temporalType->setMin($minDate);
        $temporalType->setMax($maxDate);

        $this->assertEquals($minDate, $temporalType->getMin());
        $this->assertEquals($maxDate, $temporalType->getMax());
    }

    public function testValueToString()
    {
        $temporalType = new TemporalType();
        $temporalType->setFormat(DateTime::RFC2822);
        $date = new DateTime('2020-01-01');

        $this->assertEquals(
            $date->format(DateTime::RFC2822),
            $temporalType->valueToString($date)
        );
    }

    public function testStringToDateConversion()
    {
        $temporalType = new TemporalType();
        $temporalType->setFormat(DateTimeInterface::RFC2822);
        $dateString = 'Tue, 21 Mar 2006 20:50:14 +0000';

        $dateTime = $temporalType->castToModel($dateString);

        $this->assertInstanceOf(DateTime::class, $dateTime);
        $this->assertEquals($dateString, $dateTime->format(DateTimeInterface::RFC2822));
    }

    public function testInvalidDateToString()
    {
        $temporalType = new TemporalType();
        $nonDateValue = 123;

        $this->assertEquals('123', $temporalType->valueToString($nonDateValue));
    }
}
