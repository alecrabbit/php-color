<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Service;

interface IPrecisionAdjuster
{
    public function adjust(float $v): float;
}
