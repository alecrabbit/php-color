<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\Contract\IModelCMY;
use AlecRabbit\Color\Model\DTO\DCMY;

final class ModelCMY implements IModelCMY
{
    /** @inheritDoc */
    public function dtoType(): string
    {
        return DCMY::class;
    }
}
