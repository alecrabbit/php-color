<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\IHexColorStrNormalizer;
use AlecRabbit\Color\Contract\IPrecisionAdjuster;
use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\HexColorStrNormalizer;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\PrecisionAdjuster;

use function hexdec;
use function ltrim;
use function preg_match;
use function rtrim;
use function sprintf;
use function strlen;

final readonly class HEXAParser implements IDRGBParser
{
    private const REGEXP_HEXA = '/^\(?#?(?:[a-f\d]{3}|[a-f\d]{4}|[a-f\d]{6}|[a-f\d]{8})\)?$/i';

    public function __construct(
        private IPrecisionAdjuster $precision = new PrecisionAdjuster(),
        private IHexColorStrNormalizer $hex = new HexColorStrNormalizer(),
    ) {
    }

    public function parse(string $value): DRGB
    {
        if (preg_match(self::REGEXP_HEXA, $value, $matches)) {
            $m = $this->removePrentheses((string)$matches[0]);

            $hex = $this->hex->normalize($m);
            $auxNotation = $this->auxNotation($value);

            if (strlen($hex) === 6) {
                $hex = $auxNotation ? 'ff' . $hex : $hex . 'ff';
            }

            if ($auxNotation) {
                $hex = $hex[2] . $hex[3] . $hex[4] . $hex[5] . $hex[6] . $hex[7] . $hex[0] . $hex[1];
            }

            $r = $hex[0] . $hex[1];
            $g = $hex[2] . $hex[3];
            $b = $hex[4] . $hex[5];
            $a = $hex[6] . $hex[7];

            return new DRGB(
                $this->precision->adjust(hexdec($r) / 255),
                $this->precision->adjust(hexdec($g) / 255),
                $this->precision->adjust(hexdec($b) / 255),
                $this->precision->adjust(hexdec($a) / 255),
            );
        }

        throw new InvalidArgument(
            sprintf(
                'Invalid color format: "%s".',
                $value,
            )
        );
    }

    private function removePrentheses(string $v): string
    {
        return ltrim(rtrim($v, ')'), '(');
    }

    protected function auxNotation(string $value): bool
    {
        return str_starts_with($value, '(');
    }

    public function isSupported(string $value): bool
    {
        return preg_match(self::REGEXP_HEXA, $value) === 1;
    }
}
