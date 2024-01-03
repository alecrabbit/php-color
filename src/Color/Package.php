<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\Wrapper\IWrapper;
use AlecRabbit\Color\Factory\ConverterFactory;
use AlecRabbit\Color\Factory\InstantiatorFactory;
use AlecRabbit\Color\Registry\Registry;

/**
 * @codeCoverageIgnore
 */
final class Package
{
    public static function add(IWrapper ...$wrapper): void
    {
        foreach ($wrapper as $item) {
            $converterClass = $item->getConverterClass();

            /** @var class-string<IConvertableColor> $target */
            foreach ($item->getTargets() as $target) {
                ConverterFactory::register($target, $converterClass);
            }
            InstantiatorFactory::register($item->getInstantiatorClass());

            Registry::register($converterClass, $item->getSources());
        }
    }
}
