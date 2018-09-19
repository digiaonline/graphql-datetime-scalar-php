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
    protected function getDefaultFormat(): string
    {
        return 'H:i:sP';
    }
}
