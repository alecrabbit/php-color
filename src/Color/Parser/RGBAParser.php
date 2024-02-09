<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Contract\Service\IFloatExtractor;
use AlecRabbit\Color\Contract\Service\IPrecisionAdjuster;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Service\FloatExtractor;
use AlecRabbit\Color\Service\PrecisionAdjuster;

final readonly class RGBAParser implements IDRGBParser
{
    private const REGEXP_RGBA = '/^rgba?\((\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:(?:,\s*|\s*\/\s*)(\d+(\.\d+)?%?))?\)$/';

    public function __construct(
        private IPrecisionAdjuster $precision = new PrecisionAdjuster(),
        private IFloatExtractor $extract = new FloatExtractor(),
    ) {
    }

    public function parse(string $value): DRGB
    {
        if (preg_match(self::REGEXP_RGBA, $value, $matches)) {
            return new DRGB(
                $this->precision->adjust($this->extract->value($matches[1], 255)),
                $this->precision->adjust($this->extract->value($matches[3], 255)),
                $this->precision->adjust($this->extract->value($matches[5], 255)),
                $this->precision->adjust($this->extract->value(($matches[7] ?? '1'))),

            );
        }

        throw new InvalidArgument(
            sprintf(
                'Invalid color format: "%s".',
                $value,
            )
        );
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
