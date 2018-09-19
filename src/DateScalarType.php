<?php

namespace Digia\GraphQL\Types;

class DateScalarType extends AbstractDateTimeScalarType
{
    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Date';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'Represents a date';
    }

    /**
     * @inheritdoc
     */
    protected function getFormat(): string
    {
        return 'Y-m-d';
    }
}
