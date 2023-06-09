<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\DTO;

/**
 * @codeCoverageIgnore Coverage does not make sense.
 */
final class DRGB
{
    public function __construct(
        public readonly int $red,
        public readonly int $green,
        public readonly int $blue,
    ) {
    }
}
