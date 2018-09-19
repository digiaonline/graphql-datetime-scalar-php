<?php

namespace Digia\GraphQL\Types;

use Digia\GraphQL\Language\Node\StringValueNode;
use Digia\GraphQL\Type\Definition\ScalarType;

abstract class AbstractDateTimeScalarType extends ScalarType
{

    /**
     * @return string the default format when representing the date time as a string
     */
    abstract protected function getDefaultFormat(): string;

    /**
     * AbstractDateTimeScalarType constructor.
     *
     * @param null|string $format
     */
    public function __construct(?string $format = null)
    {
        $format = $format ?? $this->getDefaultFormat();

        parent::__construct(
            $this->getName(),
            $this->getDescription(),
            function ($value) use ($format) {
                if ($value instanceof \DateTimeInterface) {
                    return $value->format($format);
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
