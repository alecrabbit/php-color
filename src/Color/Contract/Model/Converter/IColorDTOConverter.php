<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Model\Converter;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;

interface IColorDTOConverter
{
    public function convert(IColorDTO $color): IColorDTO;
}
