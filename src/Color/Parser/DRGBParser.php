<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;

final class DRGBParser implements IDRGBParser
{
    protected const REGEXP_RGBA = '/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)$/';

    public function parse(string $value): DRGB
    {
        if (preg_match(self::REGEXP_RGBA, $value, $matches)) {
            return new DRGB(
                (int)$matches[1] / 255,
                (int)$matches[2] / 255,
                (int)$matches[3] / 255,
                isset($matches[4]) ? (float)$matches[4] : 1.0
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
