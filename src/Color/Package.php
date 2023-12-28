<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IWrapper;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Factory\InstantiatorFactory;

/**
 * @codeCoverageIgnore
 */
final class Package
{
    public static function add(IWrapper ...$wrapper): void
    {
        foreach ($wrapper as $item) {
            /** @var class-string<IConvertableColor> $target */
            foreach ($item->getTargets() as $target) {
                ConverterFactory::register($target, $item->getConverterClass());
            }
            InstantiatorFactory::register($item->getInstantiatorClass());
        }
    }
}
