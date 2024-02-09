<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Parser;

use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Contract\Service\IHexColorStrNormalizer;
use AlecRabbit\Color\Contract\Service\IPrecisionAdjuster;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Service\HexColorStrNormalizer;
use AlecRabbit\Color\Service\PrecisionAdjuster;

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
        return $this->tryParse($value)
            ??
            throw new InvalidArgument(
                sprintf(
                    'Invalid color format: "%s".',
                    $value,
                )
            );
    }

    public function tryParse(string $value): ?DRGB
    {
        if (preg_match(self::REGEXP_HEXA, $value, $matches)) {
            $hex = $this->normalize(
                $this->removeParentheses($matches[0]),
                $this->isAuxNotation($value),
            );

            return $this->createDRGB($hex);
        }
        return null;
    }

    private function normalize(string $matches, bool $swapAlpha): string
    {
        $hex = $this->hex->normalize($matches);

        if (strlen($hex) === 6) {
            $hex = $swapAlpha ? 'ff' . $hex : $hex . 'ff';
        }

        if ($swapAlpha) {
            $hex = $hex[2] . $hex[3] . $hex[4] . $hex[5] . $hex[6] . $hex[7] . $hex[0] . $hex[1];
        }

        return $hex;
    }

    private function removeParentheses(string $v): string
    {
        return ltrim(rtrim($v, ')'), '(');
    }

    private function isAuxNotation(string $value): bool
    {
        return str_starts_with($value, '(');
    }

    private function createDRGB(string $hex): DRGB
    {
        $r = hexdec($hex[0] . $hex[1]) / 255;
        $g = hexdec($hex[2] . $hex[3]) / 255;
        $b = hexdec($hex[4] . $hex[5]) / 255;
        $a = hexdec($hex[6] . $hex[7]) / 255;

        return new DRGB(
            $this->precision->adjust($r),
            $this->precision->adjust($g),
            $this->precision->adjust($b),
            $this->precision->adjust($a),
        );
    }

    public function isSupported(mixed $value): bool
    {
        return match (true) {
            is_string($value) => preg_match(self::REGEXP_HEXA, $value) === 1,
            default => false,
        };
    }
}
