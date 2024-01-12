<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class DCMYK implements IColorDTO
{
    public function __construct(
        public float $cyan,
        public float $magenta,
        public float $yellow,
        public float $black,
        public float $alpha = 1.0,
    ) {
    }
}
