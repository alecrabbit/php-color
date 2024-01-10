<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;

interface IRGBAColor extends IRGBColor,
                             IHasAlpha,
                             IHasOpacity,
                             IModifiableWithAlpha,
                             IModifiableWithOpacity
{
    public const FORMAT_RGBA = 'rgba(%d, %d, %d, %s)';

    public static function fromRGBA(int $r, int $g, int $b, int $alpha = 0xFF): IRGBAColor;

    public static function fromRGBO(int $r, int $g, int $b, float $opacity = 1.0): IRGBAColor;

    public static function fromDTO(IColorDTO $dto): IRGBAColor;

    public function withRed(int $red): IRGBAColor;

    public function withGreen(int $green): IRGBAColor;

    public function withBlue(int $blue): IRGBAColor;

    public function withAlpha(int $alpha): IRGBAColor;

    public function withOpacity(float $opacity): IRGBAColor;
}
