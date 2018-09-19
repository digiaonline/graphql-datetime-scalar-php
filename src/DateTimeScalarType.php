<?php

namespace Digia\GraphQL\Types;

class DateTimeScalarType extends AbstractDateTimeScalarType
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'DateTime';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'Represents a date and time';
    }

    /**
     * @inheritdoc
     */
    protected function getFormat(): string
    {
        return \DateTime::ATOM;
    }
}
