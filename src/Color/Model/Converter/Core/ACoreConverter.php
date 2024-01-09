<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;

abstract readonly class ACoreConverter  implements ICoreConverter
{
    protected const FLOAT_PRECISION = 2;

    public function __construct(
        protected int $precision = self::FLOAT_PRECISION,
    ) {
    }

    protected function assertColor(IColorDTO $color): void
    {

    }
}
