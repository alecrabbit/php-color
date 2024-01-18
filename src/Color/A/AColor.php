<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Exception\UnsupportedValue;
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

    public static function from(mixed $color): IColor
    {
        if (\is_string($color) || $color instanceof DColor) {
            $color = Color::from($color);
        }

        if ($color instanceof IColor) {
            return $color->to(static::class);
        }

        throw new UnsupportedValue(
            sprintf(
                '%s::%s: Unsupported value of type "%s" provided.',
                get_debug_type($color),
                static::class,
                __FUNCTION__
            ),
        );
    }

    /**
     * @template T of IColor|DColor
     *
     * @param class-string<T> $class
     *
     * @psalm-return T
     */
    public function to(string $class): IColor|DColor
    {
        if ($class === $this->dtoType()) {
            return $this->toDTO();
        }

        return $this->convert($class);
    }

    /**
     * @return class-string<DColor>
     */
    protected function dtoType(): string
    {
        return $this->colorModel->dtoType();
    }

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
        return match (true) {
            is_subclass_of($to, IColor::class) => $this->convertToColor($to),
            default => $this->convertToDTO($to),
        };
    }

    /**
     * @template T of IColor
     *
     * @param class-string<T> $to
     *
     * @psalm-return T
     */
    protected function convertToColor(string $to): IColor
    {
        /** @var IToConverter<T> $converter */
        $converter = Color::to($to);

        return $converter->convert($this);
    }

    /**
     * @template T of DColor
     *
     * @param class-string<DColor> $to
     *
     * @psalm-return T
     */
    protected function convertToDTO(string $to): DColor
    {
        return $this->toDTO();
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
