<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter\Store;

use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Model\Contract\Converter\IColorDTOConverter;
use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\IColorModel;

interface IConverterStore
{
    /**
     * @param class-string<IModelConverter> ...$classes
     */
    public static function add(string ...$classes): void;

    /**
     * @throws UnsupportedColorConversion
     */
    public function getColorConverter(IColorModel $from, IColorModel $to): IColorDTOConverter;
}
