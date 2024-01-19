<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Converter\Builder;

abstract class AbstractBuilder
{
    protected function isDummy(mixed $value): bool
    {
        return $value instanceof IDummy;
    }

    abstract protected function validate(): void;

    abstract public function build(): mixed;
}
