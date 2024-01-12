<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class DLAB implements IColorDTO
{
    public function __construct(
        public float $lightness,
        public float $a,
        public float $b,
        public float $alpha = 1.0,
    ) {
    }
}
