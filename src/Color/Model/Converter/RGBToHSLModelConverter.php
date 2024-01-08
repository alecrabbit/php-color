<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;
use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\Converter\Core\CoreConverter;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class RGBToHSLModelConverter extends AModelConverter
{
    public function __construct(
        private ICoreConverter $converter = new CoreConverter(),
    ) {
        parent::__construct(self::from()->dtoType());
    }

    public static function from(): IColorModel
    {
        return new ModelRGB();
    }

    public static function to(): IColorModel
    {
        return new ModelHSL();
    }

    public function convert(IColorDTO $color): IColorDTO
    {
        $this->assertColor($color);

        /** @var DRGB $color */
        return $this->converter
            ->rgbToHsl(
                $color->red,
                $color->green,
                $color->blue,
                $color->alpha,
            );
    }
}
