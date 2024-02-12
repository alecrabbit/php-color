<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Service;

use AlecRabbit\Color\Contract\Service\IPrecisionAdjuster;

use function round;

/**
 * @codeCoverageIgnore
 */
final readonly class PrecisionAdjuster implements IPrecisionAdjuster
{
    private const PRECISION = 6;

    public function __construct(
        private int $precision = self::PRECISION,
        private int $mode = PHP_ROUND_HALF_UP,
    ) {
    }

    public function adjust(float $v): float
    {
        return round($v, $this->precision, $this->mode);
    }
}
