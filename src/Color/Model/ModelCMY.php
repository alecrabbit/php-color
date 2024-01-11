<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Contract\Model\IModelRGB;
use AlecRabbit\Color\Model\DTO\DCMY;

/** @internal */
final class ModelCMY implements IModelRGB
{
    /** @inheritDoc */
    public function dtoType(): string
    {
        return DCMY::class;
    }
}
