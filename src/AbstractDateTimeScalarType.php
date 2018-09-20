<?php

namespace Digia\GraphQL\Types;

use Digia\GraphQL\Error\InvalidTypeException;
use Digia\GraphQL\Language\Node\NodeInterface;
use Digia\GraphQL\Language\Node\StringValueNode;
use Digia\GraphQL\Type\Definition\ScalarType;

abstract class AbstractDateTimeScalarType extends ScalarType
{

    /**
     * @return string the default format when representing the date time as a string
     */
    abstract protected function getDefaultFormat(): string;

    /**
     * @var string
     */
    protected $format;

    /**
     * AbstractDateTimeScalarType constructor.
     *
     * @param null|string $format
     */
    public function __construct(?string $format = null)
    {
        $this->format = $format ?? $this->getDefaultFormat();

        parent::__construct(
            $this->getName(),
            $this->getDescription(),
            // These callbacks are not used since we're overriding the methods
            function () {
            },
            null,
            null,
            null);
    }

    /**
     * @inheritdoc
     *
     * @throws InvalidTypeException
     */
    public function serialize($value)
    {
        if ($value instanceof \DateTimeInterface) {
            return $value->format($this->format);
        }

        throw new InvalidTypeException(sprintf('Failed to serialize %s, expected value to be an instance of \DateTimeInterface',
            $this->getName()));
    }

    /**
     * @inheritdoc
     *
     * @throws InvalidTypeException
     */
    public function parseValue($value)
    {
        if (\is_string($value)) {
            return \DateTime::createFromFormat($this->format, $value);
        }

        throw new InvalidTypeException(sprintf('Failed to parse value for %s, expected value to be a string, got %s',
            $this->getName(), \gettype($value)));
    }

    /**
     * @inheritdoc
     *
     * @throws InvalidTypeException
     */
    public function parseLiteral(NodeInterface $node, ?array $variables = null)
    {
        if ($node instanceof StringValueNode) {
            return new \DateTime($node->getValue());
        }

        throw new InvalidTypeException(sprintf('Failed to parse literal %s, expected node to be an instance of %s, got %s',
            $this->getName(), StringValueNode::class, \get_class($node)));
    }
}
