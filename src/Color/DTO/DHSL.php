<?php

declare(strict_types=1);

namespace AlecRabbit\Color\DTO;

/**
 * @codeCoverageIgnore Coverage does not make sense.
 */
final readonly class DHSL
{
    public function __construct(
        public int $hue,
        public float $saturation,
        public float $lightness,
    ) {
    }
}
