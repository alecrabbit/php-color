<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Wrapper\IWrapper;
use AlecRabbit\Color\Store\ConverterStore;
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
                ConverterStore::registerOld($target, $converterClass);
                InstantiatorStore::registerOld($target, $item->getInstantiatorClass());
            }
        }
    }
}
