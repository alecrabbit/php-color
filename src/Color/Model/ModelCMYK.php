<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\Contract\IModelCMYK;
use AlecRabbit\Color\Model\DTO\DCMYK;

final class ModelCMYK implements IModelCMYK
{
    /** @inheritDoc */
    public function dtoType(): string
    {
        return DCMYK::class;
    }
}
