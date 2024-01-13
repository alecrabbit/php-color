<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Instantiator\A;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use AlecRabbit\Color\Exception\UnrecognizedColorString;

use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

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

    public function fromString(string $value): IColor
    {
        $value = self::normalize($value);

        return
            $this->instantiate($value)
            ??
            throw new UnrecognizedColorString(
                sprintf(
                    'Unrecognized color string: "%s".',
                    $value
                )
            );
    }

    abstract protected function instantiate(string $value): ?IColor;

    public function fromDTO(IColorDTO $dto): IColor
    {
        // TODO: Implement fromDTO() method.
        throw new \RuntimeException('Not implemented.');
    }
}
