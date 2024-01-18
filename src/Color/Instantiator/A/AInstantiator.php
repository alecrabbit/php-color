<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

use function is_string;
use function strtolower;
use function trim;

/**
 * @template-covariant T of IColor
 *
 * @implements IInstantiator<T>
 */
abstract class AInstantiator implements IInstantiator
{
    final protected const PRECISION = 3;

    public function __construct(
        protected int $precision = self::PRECISION,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function tryFrom(mixed $value): ?IColor
    {
        return static::isSupported($value) ? $this->from($value) : null;
    }

    public static function isSupported(mixed $value): bool
    {
        /** @var mixed $value */
        $value = is_string($value) ? self::normalizeString($value) : $value;

        return static::canInstantiate($value);
    }

    protected static function normalizeString(string $value): string
    {
        return strtolower(trim($value));
    }

    protected static function canInstantiate(mixed $color): bool
    {
        return match (true) {
            $color instanceof DColor => static::canInstantiateFromDTO($color),
            is_string($color) => static::canInstantiateFromString($color),
            default => false,
        };
    }

    abstract protected static function canInstantiateFromDTO(DColor $color): bool;

    abstract protected static function canInstantiateFromString(string $color): bool;

    /** @inheritDoc */
    public function from(mixed $value): IColor
    {
        return match (true) {
            $value instanceof DColor => $this->fromDTO($value),
            is_string($value) => $this->fromString($value),
            default => throw new UnsupportedValue(
                sprintf(
                    'Unsupported value of type "%s" provided.',
                    get_Debug_Type($value),
                )
            ),
        };
    }

    /**
     * @psalm-return T
     */
    protected function fromDTO(DColor $dto): IColor
    {
        return
            $this->createFromDTO($dto)
            ??
            throw new UnsupportedValue(
                sprintf(
                    'Unsupported dto value of type "%s" provided.',
                    $dto::class
                )
            );
    }

    /**
     * @psalm-return null|T
     */
    abstract protected function createFromDTO(DColor $value): ?IColor;

    /**
     * @psalm-return T
     */
    protected function fromString(string $value): IColor
    {
        $value = self::normalizeString($value);

        return
            $this->createFromString($value)
            ??
            throw new UnrecognizedColorString(
                sprintf(
                    'Unrecognized color string: "%s".',
                    $value
                )
            );
    }

    /**
     * @psalm-return null|T
     */
    abstract protected function createFromString(string $value): ?IColor;
}
