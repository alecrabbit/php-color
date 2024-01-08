<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\DTO;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class DRGB implements IColorDTO
{
    public function __construct(
        public int $red,
        public int $green,
        public int $blue,
        public float $alpha = 1.0,
    ) {
    }
}
