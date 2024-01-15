<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
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

    public static function isSupported(string $color): bool
    {
        $color = self::normalize($color);

        return static::canInstantiate($color);
    }

    protected static function normalize(string $color): string
    {
        return strtolower(trim($color));
    }

    abstract protected static function canInstantiate(string $color): bool;

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
     * @psalm-return T
     */
    public function fromDTO(DColor $dto): IColor
    {
        // TODO: Implement fromDTO() method.
        throw new RuntimeException('Not implemented.');
    }
}
