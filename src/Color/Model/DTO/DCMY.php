<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class DCMY implements IColorDTO
{
    public function __construct(
        public float $cyan,
        public float $magenta,
        public float $yellow,
        public float $alpha = 1.0,
    ) {
    }
}
