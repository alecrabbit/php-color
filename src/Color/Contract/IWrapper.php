<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use Traversable;

interface IWrapper
{
    /**
     * @return Traversable<IConvertableColor>
     */
    public function getTargets(): Traversable;

    /**
     * @return class-string<IToConverter>
     */
    public function getConverterClass(): string;

    /**
     * @return class-string<IInstantiator>
     */
    public function getInstantiatorClass(): string;
}
