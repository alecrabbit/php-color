<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Util\Color;

abstract class AColor implements IColor
{
    protected const COMPONENT = 0xFF;

    public function __construct(
        protected readonly IColorModel $colorModel
    ) {
    }

    abstract public static function from(IColor $color): IColor;

    protected static function assertDTO(DColor $dto): void
    {
        if (is_a($dto, static::dtoType(), true)) {
            return;
        }

        throw new InvalidArgument(
            sprintf(
                'Color must be instance of "%s", "%s" given.',
                static::dtoType(),
                $dto::class,
            ),
        );
    }

    /**
     * @return class-string<DColor>
     */
    abstract protected static function dtoType(): string;

    abstract protected static function createFromDTO(DColor $dto): IColor;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return T
     */
    protected static function convert(IColor $color, string $to): IColor
    {
        if ($color::class === $to) {
            return $color;
        }

        /** @var IToConverter<T> $converter */
        $converter = Color::to($to);

        return $converter->convert($color);
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return T
     */
    public function to(string $class): IColor
    {
        return self::convert($this, $class);
    }

    protected static function getFromString(string $color): IColor
    {
        return Color::fromString($color);
    }

    abstract public static function fromString(string $value): IColor;

    public function __toString(): string
    {
        return $this->toString();
    }

    abstract public function toString(): string;

    public function getColorModel(): IColorModel
    {
        return $this->colorModel;
    }
}
