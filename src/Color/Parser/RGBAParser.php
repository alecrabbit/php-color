<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\IPrecisionAdjuster;
use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\PrecisionAdjuster;

final readonly class RGBAParser implements IDRGBParser
{
    protected const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';

    public function __construct(
        private IPrecisionAdjuster $precision = new PrecisionAdjuster(),
    ) {
    }

    public function parse(string $value): DRGB
    {
        if (preg_match(self::REGEXP_RGBA, $value, $matches)) {
            return new DRGB(
                $this->precision->adjust((int)$matches[1] / 255),
                $this->precision->adjust((int)$matches[2] / 255),
                $this->precision->adjust((int)$matches[3] / 255),
                $this->precision->adjust(isset($matches[4]) ? (float)$matches[4] : 1.0),
            );
        }

        throw new InvalidArgument(
            sprintf(
                'Invalid color format: "%s".',
                $value,
            )
        );
    }

    public function isSupported(string $value): bool
    {
        return
            str_starts_with($value, 'rgb(') ||
            str_starts_with($value, 'rgba(');
    }
}
