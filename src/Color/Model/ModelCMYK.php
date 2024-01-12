<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\Contract\IModelRGB;
use AlecRabbit\Color\Model\DTO\DCMYK;

/** @internal */
final class ModelCMYK implements IModelRGB
{
    /** @inheritDoc */
    public function dtoType(): string
    {
        return DCMYK::class;
    }
}
