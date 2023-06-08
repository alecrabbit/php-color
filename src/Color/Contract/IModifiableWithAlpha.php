<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithAlpha
{
    public function withAlpha(int $alpha): IModifiableWithAlpha;
}
