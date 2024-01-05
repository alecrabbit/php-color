<?php

declare(strict_types=1);

namespace AlecRabbit\Color\A;

use AlecRabbit\Color\Contract\IHasOpacity;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;

abstract class ARGBValueColor extends AColor
{
    protected const MAX = 0xFFFFFF;
    protected const RED = 0xFF0000;
    protected const GREEN = 0x00FF00;
    protected const BLUE = 0x0000FF;

    protected function __construct(
        protected readonly int $value,
    ) {
        parent::__construct(
            colorModel: new ModelRGB(),
        );
    }

    protected static function componentsToValue(int $r, int $g, int $b): int
    {
        return (
                ((abs($r) & self::COMPONENT) << 16) |
                ((abs($g) & self::COMPONENT) << 8) |
                ((abs($b) & self::COMPONENT) << 0)
            ) & self::MAX;
    }

    public function toDTO(): IColorDTO
    {
        return new DRGB(
            red: $this->getRed(),
            green: $this->getGreen(),
            blue: $this->getBlue(),
            alpha: $this instanceof IHasOpacity ? $this->getOpacity() : 1.0,
        );
    }

    public function getRed(): int
    {
        return (self::RED & $this->value) >> 16;
    }

    public function getGreen(): int
    {
        return (self::GREEN & $this->value) >> 8;
    }

    public function getBlue(): int
    {
        return (self::BLUE & $this->value) >> 0;
    }

    abstract public function toString(): string;

    public function getValue(): int
    {
        return $this->value;
    }
}
