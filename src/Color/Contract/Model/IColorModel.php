<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Model;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;

interface IColorModel
{
    /**
     * @return class-string<IColorDTO>
     */
    public function dtoType(): string;
}
