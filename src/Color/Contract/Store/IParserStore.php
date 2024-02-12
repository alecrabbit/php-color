<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Contract\Store;

use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Exception\ParserUnavailable;

interface IParserStore
{
    /**
     * @param class-string<IParser> $parserClass
     */
    public static function register(string $parserClass): void;

    /**
     * @throws ParserUnavailable
     */
    public function getByValue(mixed $value): IParser;

    public function findByValue(mixed $value): ?IParser;
}
