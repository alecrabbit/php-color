<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnsupportedValue;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\Contract\IColorModel;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Color\Util\Converter;

use function is_string;

abstract class AColor implements IColor
{
    protected const COMPONENT = 0xFF;

    public static function from(mixed $value): IColor
    {
        if (is_string($value) || $value instanceof DColor) {
            $value = self::instantiateColor($value);
        }

        if ($value instanceof IColor) {
            return $value->to(static::class);
        }

        throw new UnsupportedValue(
            sprintf(
                '%s::%s(): Unsupported value of type "%s" provided.',
                static::class,
                __FUNCTION__,
                get_debug_type($value),
            ),
        );
    }

    protected static function instantiateColor(DColor|string $value): IColor
    {
        if ($value instanceof DColor && $value::class === self::getDtoType()) {
            return static::fromDTO($value);
        }
        return Color::from($value);
    }

    /**
     * @return class-string<DColor>
     */
    protected static function getDtoType(): string
    {
        return static::colorModel()->dtoType();
    }

    abstract protected static function colorModel(): IColorModel;

    abstract protected static function fromDTO(DColor $dto): IColor;

    /**
     * @template T of IColor|DColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return T
     */
    public function to(string $to): IColor|DColor
    {
        if ($to === self::getDtoType()) {
            return $this->dto();
        }

        if ($this::class === $to) {
            return $this;
        }

        return $this->doConvert($to);
    }

    public function dto(): DColor
    {
        return $this->toDTO();
    }

    abstract protected function toDTO(): DColor;

    /**
     * @template T of IColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return T
     */
    protected function doConvert(string $to): IColor|DColor
    {
        /** @var IToConverter<T> $converter */
        $converter = $this->getConverter($to);

        $result = $converter->convert($this);

        return is_subclass_of($to, DColor::class)
            ? $result->dto()
            : $result;
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return IToConverter<T>
     */
    protected function getConverter(string $to): IToConverter
    {
        return Converter::to($to);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    abstract public function toString(): string;

    public function getColorModel(): IColorModel
    {
        return static::colorModel();
    }
}
