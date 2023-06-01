<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\A\AConvertableColor;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IRGBColor;

use function abs;
use function sprintf;

class Hex extends AConvertableColor implements IHexColor
{
    protected const MAX = 0xFFFFFF;
    protected const COMPONENT = 0xFF;
    protected const RED = 0xFF0000;
    protected const GREEN = 0x00FF00;
    protected const BLUE = 0x0000FF;

    protected function __construct(
        protected readonly int $value,
    ) {
    }

    /** @psalm-suppress MoreSpecificReturnType */
    public static function fromString(string $color): IHexColor
    {
        /**
         * @noinspection PhpIncompatibleReturnTypeInspection
         * @psalm-suppress LessSpecificReturnStatement
         */
        return parent::fromString($color)->toHex();
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return sprintf(self::FORMAT_HEX, $this->getValue());
    }

    public static function fromInteger(int $value): IHexColor
    {
        return new self(abs($value) & self::MAX);
    }

    public function withRed(int $red): IHexColor
    {
        // TODO: Implement withRed() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function withGreen(int $green): IHexColor
    {
        // TODO: Implement withGreen() method.
        throw new \RuntimeException('Not implemented.');
    }

    public function withBlue(int $blue): IHexColor
    {
        // TODO: Implement withBlue() method.
        throw new \RuntimeException('Not implemented.');
    }
}
