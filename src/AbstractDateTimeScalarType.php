<?php

namespace Digia\GraphQL\Types;

use Digia\GraphQL\Language\Node\StringValueNode;
use Digia\GraphQL\Type\Definition\ScalarType;

abstract class AbstractDateTimeScalarType extends ScalarType
{

    /**
     * @return string the format when representing the date time as a string
     */
    abstract protected function getFormat(): string;

    /**
     * AbstractDateTimeScalarType constructor.
     */
    public function __construct()
    {
        parent::__construct(
            $this->getName(),
            $this->getDescription(),
            function ($value) {
                if ($value instanceof \DateTimeInterface) {
                    return $value->format($this->getFormat());
                }

                return null;
            },
            function ($value) {
                if (\is_string($value)) {
                    return new \DateTime($value);
                }

                return null;
            },
            function ($node) {
                if ($node instanceof StringValueNode) {
                    return new \DateTime($node->getValue());
                }

                return null;
            },
            null);
    }
}
