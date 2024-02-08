<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IHexColorStrNormalizer
{
    public function normalize(string $v): string;
}
