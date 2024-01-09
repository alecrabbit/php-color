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
        public int $hue,    // TODO (2024-01-09 12:53) [Alec Rabbit]: should be float
        public float $saturation,
        public float $lightness,
        public float $alpha = 1.0,
    ) {
    }
}
