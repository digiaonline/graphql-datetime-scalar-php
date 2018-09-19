<?php

namespace Digia\GraphQL\Types\Tests;

use Digia\GraphQL\Language\Node\IntValueNode;
use Digia\GraphQL\Language\Node\StringValueNode;
use Digia\GraphQL\Types\TimeScalarType;
use PHPUnit\Framework\TestCase;

class TimeScalarTypeTest extends TestCase
{

    public function testScalarType(): void
    {
        $timeType = new TimeScalarType();

        $this->assertEquals('Time', $timeType->getName());
        $this->assertEquals('Represents a time', $timeType->getDescription());

        $this->assertEquals('14:30:37+00:00', $timeType->serialize(new \DateTime('2018-01-01T14:30:37+00:00')));
        $this->assertNull($timeType->serialize('not a datetime object'));

        /** @var \DateTimeInterface $date */
        $date = $timeType->parseValue('14:30:37+00:00');
        $this->assertEquals('14', $date->format('H'));
        $this->assertEquals('30', $date->format('i'));
        $this->assertEquals('37', $date->format('s'));
        $this->assertEquals('+00:00', $date->format('P'));
        $this->assertNull($timeType->parseValue(['not a string']));

        $node = new StringValueNode('14:30:37+00:00', false, null);
        $date = $timeType->parseLiteral($node);
        $this->assertEquals('14', $date->format('H'));
        $this->assertEquals('30', $date->format('i'));
        $this->assertEquals('37', $date->format('s'));
        $this->assertEquals('+00:00', $date->format('P'));
        $this->assertNull($timeType->parseLiteral(new IntValueNode(1, null)));
    }
}
