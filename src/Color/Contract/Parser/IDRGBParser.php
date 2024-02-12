<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Parser;

use AlecRabbit\Color\Model\DTO\DRGB;

interface IDRGBParser extends IParser
{
    public function parse(string $value): DRGB;


}
