<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Parser;

use AlecRabbit\Color\Model\Contract\DTO\DColor;

interface IParser
{
    public function parse(string $value): DColor;

    public function tryParse(string $value): ?DColor;

    public function isSupported(mixed $value): bool;
}
