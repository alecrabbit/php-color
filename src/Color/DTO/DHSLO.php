<?php

declare(strict_types=1);

namespace AlecRabbit\Color\DTO;

/**
 * @codeCoverageIgnore
 */
final readonly class DHSLO
{
    public function __construct(
        public int $hue,
        public float $saturation,
        public float $lightness,
        public float $opacity,
    ) {
    }
}
