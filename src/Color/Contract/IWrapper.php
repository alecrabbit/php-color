<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract;

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
