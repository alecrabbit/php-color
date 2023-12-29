<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator\A;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;

use function strtolower;
use function trim;

abstract class AInstantiator implements IInstantiator
{
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

    public function fromString(string $color): IConvertableColor
    {
        $color = self::normalize($color);

        return
            $this->instantiate($color)
            ??
            throw new UnrecognizedColorString(
                sprintf(
                    'Unrecognized color string: "%s".',
                    $color
                )
            );
    }

    abstract protected function instantiate(string $color): ?IConvertableColor;
}
