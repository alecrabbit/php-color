<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IRegistry;
use AlecRabbit\Color\Registry\Registry;
use AlecRabbit\Color\Util\Contract\IConverterUtility;

final readonly class Converter implements IConverterUtility
{
    /**
     * @codeCoverageIgnore
     */
    private function __construct()
    {
        // Can not be instantiated
    }

    /** @inheritDoc */
    public static function to(string $target): IToConverter
    {
        return self::getRegistry()->getToConverter($target);
    }

    private static function getRegistry(): IRegistry
    {
        return new Registry();
    }
}
