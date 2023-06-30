<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\DTO;

/**
 * @codeCoverageIgnore Coverage does not make sense.
 */
final readonly class DRGB
{
    public function __construct(
        public int $red,
        public int $green,
        public int $blue,
    ) {
    }
}
