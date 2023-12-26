<?php

declare(strict_types=1);

namespace AlecRabbit\Color;

use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Contract\IInstantiator;
use Traversable;

interface IWrapper
{
    /**
     * @return Traversable<IConvertableColor>
     */
    public function getTargets(): Traversable;

    /**
     * @return class-string<IConverter>
     */
    public function getConverterClass(): string;

    /**
     * @return class-string<IInstantiator>
     */
    public function getInstantiatorClass(): string;
}
