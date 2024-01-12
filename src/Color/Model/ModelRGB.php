<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\Contract\IModelRGB;
use AlecRabbit\Color\Model\DTO\DRGB;

/** @internal */
final class ModelRGB implements IModelRGB
{
    /** @inheritDoc */
    public function dtoType(): string
    {
        return DRGB::class;
    }
}
