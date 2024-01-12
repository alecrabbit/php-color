<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Model\Converter;

use AlecRabbit\Color\Model\Contract\Converter\IStore;

final class Store implements IStore
{
    public static function add(string ...$classes): void
    {
        // TODO: Implement add() method.
        throw new \RuntimeException(__METHOD__ . ' Not implemented.');
    }
}
