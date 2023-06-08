<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithBlue
{
    public function withBlue(int $blue): IModifiableWithBlue;
}
