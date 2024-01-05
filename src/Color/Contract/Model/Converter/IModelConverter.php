<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Model\Converter;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;

interface IModelConverter
{
    public function convert(IColorDTO $color): IColorDTO;

    public static function to(): IColorModel;

    public static function from(): IColorModel;
}
