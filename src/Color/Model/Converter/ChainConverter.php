<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Contract\Converter\IColorDTOConverter;
use AlecRabbit\Color\Model\Contract\DTO\DColor;

/**
 * @internal
 * @codeCoverageIgnore
 */
final readonly class ChainConverter implements IColorDTOConverter
{
    /** @param iterable<class-string<IColorDTOConverter>> $chain */
    public function __construct(
        private iterable $chain,
    ) {
    }

    public function convert(DColor $color): DColor
    {
        /** @var class-string<IColorDTOConverter> $converter */
        foreach ($this->chain as $converter) {
            $color = (new $converter())->convert($color);
        }

        return $color;
    }
}
