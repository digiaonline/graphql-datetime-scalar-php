<?php

namespace Digia\GraphQL\Types;

use Digia\GraphQL\Error\InvalidTypeException;
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

                throw new InvalidTypeException(sprintf('Failed to serialize %s, expected value to be an instance of \DateTimeInterface',
                    $this->getName()));
            },
            function ($value) {
                if (\is_string($value)) {
                    return new \DateTime($value);
                }

                throw new InvalidTypeException(sprintf('Failed to parse value for %s, expected value to be a string, got %s',
                    $this->getName(), \gettype($value)));
            },
            function ($node) {
                if ($node instanceof StringValueNode) {
                    return new \DateTime($node->getValue());
                }

                throw new InvalidTypeException(sprintf('Failed to parse literal %s, expected node to be an instance of %s, got %s',
                    $this->getName(), StringValueNode::class, \gettype($node)));
            },
            null);
    }
}
