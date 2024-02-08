<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\IPrecisionAdjuster;
use AlecRabbit\Color\Contract\Parser\IDHSLParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\PrecisionAdjuster;

final readonly class HSLAParser implements IDHSLParser
{
    private const REGEXP_HSLA = '/^hsla?\((\d+)(?:,\s*|\s*)(\d+)%(?:,\s*|\s*)(\d+)%(?:(?:,\s*|\s*\/\s*)(([\d.]+)|(\d.+%)))?\)$/';

    public function __construct(
        private IPrecisionAdjuster $precision = new PrecisionAdjuster(),
    ) {
    }

    public function parse(string $value): DHSL
    {
        if (preg_match(self::REGEXP_HSLA, $value, $matches)) {
            return new DHSL(
                $this->precision->adjust((int)$matches[1] / 360),
                $this->precision->adjust((int)$matches[2] / 100),
                $this->precision->adjust((int)$matches[3] / 100),
                $this->precision->adjust(
                    isset($matches[4])
                        ? $this->extractValue((string)$matches[4])
                        : 1.0
                ),
            );
        }

        throw new InvalidArgument(
            sprintf(
                'Invalid color format: "%s".',
                $value,
            )
        );
    }

    private function extractValue(string $value): float
    {
        if (str_contains($value, '%')) {
            return (float)$value / 100;
        }

        return (float)$value;
    }

    public function isSupported(string $value): bool
    {
        return
            str_starts_with($value, 'hsl(') ||
            str_starts_with($value, 'hsla(');
    }
}
