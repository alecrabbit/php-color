<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

interface IModifiableWithGreen
{
    public function withGreen(int $green): IModifiableWithGreen;
}
