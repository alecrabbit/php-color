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

    public function __construct(
        protected readonly IColorModel $colorModel
    ) {
    }

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
        return Color::from($value);
    }

    /**
     * @template T of IColor|DColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return T
     */
    public function to(string $to): IColor|DColor
    {
        if ($to === $this->dtoType()) {
            return $this->toDTO();
        }

        return $this->convert($to);
    }

    /**
     * @return class-string<DColor>
     */
    protected function dtoType(): string
    {
        return $this->colorModel->dtoType();
    }

    abstract protected function toDTO(): DColor;

    /**
     * @template T of IColor|DColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return T
     */
    protected function convert(string $to): IColor|DColor
    {
        if ($this::class === $to) {
            return $this;
        }

        return $this->doConvert($to);
    }

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

        return is_subclass_of($to, DColor::class)
            ? $converter->partialConvert($this)
            : $converter->convert($this);
    }

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
        return $this->colorModel;
    }
}
