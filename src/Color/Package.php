<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Wrapper\IWrapper;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Store\InstantiatorStore;

/**
 * @codeCoverageIgnore
 */
final class Package
{
    public static function add(IWrapper ...$wrapper): void
    {
        foreach ($wrapper as $item) {
            $converterClass = $item->getConverterClass();

            /** @var class-string<IColor> $target */
            foreach ($item->getTargets() as $target) {
                ConverterFactory::register($target, $converterClass);
            }
            InstantiatorStore::register($item->getInstantiatorClass());
        }
    }
}
