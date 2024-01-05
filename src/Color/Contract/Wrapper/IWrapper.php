<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Wrapper;

use AlecRabbit\Color\Contract\Converter\IFromConverter;
use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\Instantiator\IInstantiator;
use Traversable;

interface IWrapper
{
    /**
     * @return Traversable<class-string<IColor>>
     */
    public function getTargets(): Traversable;

    /**
     * @return Traversable<class-string<IColor>, class-string<IFromConverter>>
     */
    public function getSources(): Traversable;

    /**
     * @return class-string<IToConverter>
     */
    public function getConverterClass(): string;

    /**
     * @return class-string<IInstantiator>
     */
    public function getInstantiatorClass(): string;
}
