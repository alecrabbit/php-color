<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract;

use AlecRabbit\Color\Model\Contract\DTO\IColorDTO;

interface IColorModel
{
    /**
     * @return class-string<IColorDTO>
     */
    public function dtoType(): string;
}
