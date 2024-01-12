<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Model\Converter\Override;

use AlecRabbit\Color\Model\Contract\Converter\IModelConverter;
use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\IColorModel;
use RuntimeException;

final class ModelConverterOverrideTwo implements IModelConverter
{

    public static function to(): IColorModel
    {
        return new ColorModelOverrideTwo();
    }

    public static function from(): IColorModel
    {
        return new ColorModelOverrideOne();
    }

    public function convert(IColorDTO $color): IColorDTO
    {
        throw new RuntimeException(__METHOD__ . ' INTENTIONALLY Not implemented.');
    }
}
