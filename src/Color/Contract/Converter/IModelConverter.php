<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Converter;

use AlecRabbit\Color\Contract\DTO\IColorDTO;

interface IModelConverter
{
    public function convert(IColorDTO $color): IColorDTO;
}
