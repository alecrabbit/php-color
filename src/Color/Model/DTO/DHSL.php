<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class DHSL implements IColorDTO
{
    public function __construct(
        public int $hue,
        public float $saturation,
        public float $lightness,
        public float $alpha = 1.0,
    ) {
    }
}
