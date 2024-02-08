<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IHexColorStrNormalizer;

final readonly class HexColorStrNormalizer implements IHexColorStrNormalizer
{

    public function normalize(string $v): string
    {
        $v = ltrim($v, '#');

        $len = strlen($v);

        if ($len === 3) {
            $v = $v[0] . $v[0] . $v[1] . $v[1] . $v[2] . $v[2];
        }

        if ($len === 4) {
            $v = $v[0] . $v[0] . $v[1] . $v[1] . $v[2] . $v[2] . $v[3] . $v[3];
        }

        return $v;
    }
}
