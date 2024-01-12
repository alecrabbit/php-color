<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter;

use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

interface IColorDTOConverter
{
    public function convert(IColorDTO $color): IColorDTO;
}
