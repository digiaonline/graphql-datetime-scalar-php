<?php

namespace Digia\GraphQL\Types;

class TimeScalarType extends AbstractDateTimeScalarType
{

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        return 'Time';
    }

    /**
     * @inheritdoc
     */
    public function getDescription(): ?string
    {
        return 'Represents a time';
    }

    /**
     * @inheritdoc
     */
    protected function getFormat(): string
    {
        return 'H:i:sP';
    }
}
