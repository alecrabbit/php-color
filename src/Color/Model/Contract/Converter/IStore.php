<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Contract\Converter;

interface IStore
{
    /**
     * @param class-string<IModelConverter> ...$classes
     */
    public static function add(string ...$classes): void;
}
