<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Contract\Converter\ICoreConverter;
use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Contract\Model\IColorModel;
use AlecRabbit\Color\Converter\CoreConverter;
use AlecRabbit\Color\Model\Converter\A\AModelConverter;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\ModelHSL;
use AlecRabbit\Color\Model\ModelRGB;

/** @internal */
final readonly class HSLToRGBModelConverter extends AModelConverter
{
    public function __construct(
        private ICoreConverter $converter = new CoreConverter(),
    ) {
        parent::__construct(self::from()->dtoType());
    }

    public static function from(): IColorModel
    {
        return new ModelHSL();
    }

    public static function to(): IColorModel
    {
        return new ModelRGB();
    }

    public function convert(IColorDTO $color): IColorDTO
    {
        $this->assertColor($color);

        /** @var DHSL $color */
        return $this->converter
            ->hslToRgb(
                $color->hue,
                $color->saturation,
                $color->lightness,
                $color->alpha,
            );
    }

}
