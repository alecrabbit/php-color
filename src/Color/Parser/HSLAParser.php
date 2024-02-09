<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\Parser\IDHSLParser;
use AlecRabbit\Color\Contract\Service\IFloatExtractor;
use AlecRabbit\Color\Contract\Service\IPrecisionAdjuster;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Service\FloatExtractor;
use AlecRabbit\Color\Service\PrecisionAdjuster;

final readonly class HSLAParser implements IDHSLParser
{
    private const REGEXP_HSLA = '/^hsla?\((\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:,\s*|\s*)(\d+(\.\d+)?%?)(?:(?:,\s*|\s*\/\s*)(\d+(\.\d+)?%?))?\)$/';

    public function __construct(
        private IPrecisionAdjuster $precision = new PrecisionAdjuster(),
        private IFloatExtractor $extract = new FloatExtractor(),
    ) {
    }

    public function parse(string $value): DHSL
    {
        return $this->tryParse($value)
            ?? throw new InvalidArgument(
                sprintf(
                    'Invalid color format: "%s".',
                    $value,
                )
            );
    }

    public function tryParse(string $value): ?DHSL
    {
        if (preg_match(self::REGEXP_HSLA, $value, $matches)) {
            return new DHSL(
                $this->precision->adjust($this->extract->value($matches[1], 360)),
                $this->precision->adjust($this->extract->value($matches[3])),
                $this->precision->adjust($this->extract->value($matches[5])),
                $this->precision->adjust($this->extract->value(($matches[7] ?? '1'))),
            );
        }
        return null;
    }

    public function isSupported(mixed $value): bool
    {
        return match (true) {
            is_string($value) => str_starts_with($value, 'hsl(') ||
                str_starts_with($value, 'hsla('),
            default => false,
        };
    }
}
