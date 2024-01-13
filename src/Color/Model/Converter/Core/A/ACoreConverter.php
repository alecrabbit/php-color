<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core\A;

use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

abstract readonly class ACoreConverter implements ICoreConverter
{
    protected const FLOAT_PRECISION = ICoreConverter::PRECISION;

    /** @var class-string<DColor> */
    protected string $inputType;

    public function __construct(
        string $type = null,
        protected int $precision = self::FLOAT_PRECISION,
    ) {
        /** @var null|class-string<DColor> $type */
        $this->inputType = $type ?? static::inputType();
    }

    /**
     * @return class-string<DColor>
     */
    abstract protected static function inputType(): string;

    public function convert(DColor $color): DColor
    {
        $this->assertColor($color);

        return $this->doConvert($color);
    }

    protected function assertColor(DColor $color): void
    {
        if (is_a($color, $this->inputType, true)) {
            return;
        }

        throw new InvalidArgument(
            sprintf(
                'Color must be instance of "%s", "%s" given.',
                $this->inputType,
                $color::class,
            ),
        );
    }

    abstract protected function doConvert(DColor $color): DColor;
}
