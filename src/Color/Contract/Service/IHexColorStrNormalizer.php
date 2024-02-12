<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Service;

interface IHexColorStrNormalizer
{
    public function normalize(string $v): string;
}
