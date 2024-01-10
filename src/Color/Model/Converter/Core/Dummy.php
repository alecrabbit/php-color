<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter\Core;

use AlecRabbit\Color\Contract\Model\DTO\IColorDTO;
use AlecRabbit\Color\Exception\UnimplementedFunctionality;
use AlecRabbit\Color\Model\Contract\Converter\Core\ICoreConverter;

final readonly class Dummy implements ICoreConverter
{
    public function convert(IColorDTO $color): IColorDTO
    {
        throw new UnimplementedFunctionality(__METHOD__ . ': INTENTIONALLY Not implemented.');
    }
}
