<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Contract\Service\IPrecisionAdjuster;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Service\PrecisionAdjuster;

final readonly class RGBAParser implements IDRGBParser
{
    private const REGEXP_RGBA = '/^rgba?\((\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:(?:,\s*|\s*\/\s*)(\d+(\.\d+)?%?))?\)$/';

    public function __construct(
        private IPrecisionAdjuster $precision = new PrecisionAdjuster(),
    ) {
    }

    public function parse(string $value): DRGB
    {
        if (preg_match(self::REGEXP_RGBA, $value, $matches)) {
            return new DRGB(
                $this->precision->adjust($this->extractValue((string)$matches[1], 255)),
                $this->precision->adjust($this->extractValue((string)$matches[3], 255)),
                $this->precision->adjust($this->extractValue((string)$matches[5], 255)),
                $this->precision->adjust($this->extractValue((string)($matches[7] ?? '1'))),

            );
        }

        throw new InvalidArgument(
            sprintf(
                'Invalid color format: "%s".',
                $value,
            )
        );
    }

    private function extractValue(string $value, float $div = 1): float
    {
        if (str_ends_with($value, '%')) {
            return (float)$value / 100;
        }

        return (float)$value / $div;
    }
    public function isSupported(mixed $value): bool
    {
        return match (true) {
            is_string($value) => str_starts_with($value, 'rgb(') ||
                str_starts_with($value, 'rgba('),
            default => false,
        };
    }
}
