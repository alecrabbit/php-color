<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithRed
{
    public function withRed(int $red): IModifiableWithRed;
}
