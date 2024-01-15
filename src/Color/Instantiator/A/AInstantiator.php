<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Exception\UnrecognizedColorString;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use RuntimeException;

use function strtolower;
use function trim;

/**
 * @template-covariant T of IColor
 *
 * @implements IInstantiator<T>
 */
abstract class AInstantiator implements IInstantiator
{
    protected const PRECISION = 2;

    public static function isSupported(string $value): bool
    {
        $value = self::normalize($value);

        return static::canInstantiate($value);
    }

    protected static function normalize(string $color): string
    {
        return strtolower(trim($color));
    }

    abstract protected static function canInstantiate(string $color): bool;

    /**
     * @psalm-return T
     */
    public function from(DColor|string $value): IColor
    {
        return
            $value instanceof DColor
                ? $this->fromDTO($value)
                : $this->fromString($value);
    }

    /**
     * @psalm-return T
     */
    protected function fromDTO(DColor $dto): IColor
    {
        return $this->createFromDTO($dto)
            ??
            throw new InvalidArgument( // TODO (2024-01-15 15:31) [Alec Rabbit]: clarify exception message
                sprintf(
                    'Cannot instantiate "%s" from "%s".',
                    static::getTargetClass(),
                    $dto::class
                )
            );
    }

    /**
     * @psalm-return T
     */
    public function fromString(string $value): IColor
    {
        $value = self::normalize($value);

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

    /**
     * @psalm-return null|T
     */
    abstract protected function createFromDTO(DColor $value): ?IColor;
}
