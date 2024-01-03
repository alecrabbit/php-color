<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Wrapper;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IConvertableColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use Traversable;

interface IWrapper
{
    /**
     * @return Traversable<class-string<IConvertableColor>>
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
