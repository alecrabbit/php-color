<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithHue
{
    public function withHue(int $hue): IModifiableWithHue;
}
