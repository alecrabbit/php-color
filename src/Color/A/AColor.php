<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Color\Util\Converter;

abstract class AColor implements IColor
{
    protected const COMPONENT = 0xFF;

    public function __construct(
        protected readonly IColorModel $colorModel
    ) {
    }

    abstract public static function from(IColor $color): IColor;

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
        $converter = Converter::to($to);

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

    protected static function assertDTO(IColorDTO $dto): void
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
     * @return class-string<IColorDTO>
     */
    abstract protected static function dtoType(): string;

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
