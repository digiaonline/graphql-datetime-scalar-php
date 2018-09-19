<?php

namespace Digia\GraphQL\Types\Tests;

use Digia\GraphQL\Language\Node\IntValueNode;
use Digia\GraphQL\Language\Node\StringValueNode;
use Digia\GraphQL\Types\DateScalarType;
use PHPUnit\Framework\TestCase;

class DateScalarTypeTest extends TestCase
{

    /**
     * @covers \Digia\GraphQL\Types\DateScalarType::__construct()
     * @covers \Digia\GraphQL\Types\DateScalarType::getName()
     * @covers \Digia\GraphQL\Types\DateScalarType::getDescription()
     * @covers \Digia\GraphQL\Types\DateScalarType::getDefaultFormat()
     */
    public function testScalarType(): void
    {
        $dateType = new DateScalarType();

        $this->assertEquals('Date', $dateType->getName());
        $this->assertEquals('Represents a date', $dateType->getDescription());

        $this->assertEquals('2018-01-01', $dateType->serialize(new \DateTime('2018-01-01')));
        $this->assertEquals('1.1.2018', (new DateScalarType('j.n.Y'))->serialize(new \DateTime('2018-01-01')));
        $this->assertNull($dateType->serialize('not a datetime object'));

        /** @var \DateTimeInterface $date */
        $date = $dateType->parseValue('2018-01-01');
        $this->assertEquals(2018, $date->format('Y'));
        $this->assertEquals('01', $date->format('m'));
        $this->assertEquals('01', $date->format('d'));
        $this->assertNull($dateType->parseValue(['not a string']));

        $node = new StringValueNode('2018-01-01', false, null);
        $date = $dateType->parseLiteral($node);
        $this->assertEquals(2018, $date->format('Y'));
        $this->assertEquals('01', $date->format('m'));
        $this->assertEquals('01', $date->format('d'));
        $this->assertNull($dateType->parseLiteral(new IntValueNode(1, null)));
    }
}
