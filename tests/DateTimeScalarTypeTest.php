<?php

namespace Digia\GraphQL\Types\Tests;

use Digia\GraphQL\Language\Node\IntValueNode;
use Digia\GraphQL\Language\Node\StringValueNode;
use Digia\GraphQL\Types\DateTimeScalarType;
use PHPUnit\Framework\TestCase;

class DateTimeScalarTypeTest extends TestCase
{

    /**
     * @covers \Digia\GraphQL\Types\DateTimeScalarType::__construct()
     * @covers \Digia\GraphQL\Types\DateTimeScalarType::getName()
     * @covers \Digia\GraphQL\Types\DateTimeScalarType::getDescription()
     * @covers \Digia\GraphQL\Types\DateTimeScalarType::getDefaultFormat()
     */
    public function testScalarType(): void
    {
        $dateTimeType = new DateTimeScalarType();

        $this->assertEquals('DateTime', $dateTimeType->getName());
        $this->assertEquals('Represents a date and time', $dateTimeType->getDescription());

        $this->assertEquals('2018-01-01T14:30:37+00:00',
            $dateTimeType->serialize(new \DateTime('2018-01-01T14:30:37+00:00')));
        $this->assertEquals('1.1.2018 14:30:37',
            (new DateTimeScalarType('j.n.Y H:i:s'))->serialize(new \DateTime('2018-01-01T14:30:37Z+00:00')));
        $this->assertNull($dateTimeType->serialize('not a datetime object'));

        /** @var \DateTimeInterface $date */
        $date = $dateTimeType->parseValue('2018-01-01T14:30:37+00:00');
        $this->assertEquals(2018, $date->format('Y'));
        $this->assertEquals('01', $date->format('m'));
        $this->assertEquals('01', $date->format('d'));
        $this->assertEquals('14', $date->format('H'));
        $this->assertEquals('30', $date->format('i'));
        $this->assertEquals('37', $date->format('s'));
        $this->assertEquals('+00:00', $date->format('P'));
        $this->assertNull($dateTimeType->parseValue(['not a string']));

        $node = new StringValueNode('2018-01-01T14:30:37+00:00', false, null);
        $date = $dateTimeType->parseLiteral($node);
        $this->assertEquals(2018, $date->format('Y'));
        $this->assertEquals('01', $date->format('m'));
        $this->assertEquals('01', $date->format('d'));
        $this->assertEquals('14', $date->format('H'));
        $this->assertEquals('30', $date->format('i'));
        $this->assertEquals('37', $date->format('s'));
        $this->assertEquals('+00:00', $date->format('P'));
        $this->assertNull($dateTimeType->parseLiteral(new IntValueNode(1, null)));
    }
}
