<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model;

use AlecRabbit\Color\Model\Contract\IModelHSL;
use AlecRabbit\Color\Model\DTO\DHSL;

/** @internal */
final class ModelHSL implements IModelHSL
{
    /** @inheritDoc */
    public function dtoType(): string
    {
        return DHSL::class;
    }
}
