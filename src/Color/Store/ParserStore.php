<?php

declare(strict_types=1);

namespace AlecRabbit\Color\Store;

use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Contract\Store\IParserStore;
use AlecRabbit\Color\Exception\InvalidArgument;

use function array_reverse;
use function is_string;

final class ParserStore implements IParserStore
{
    /** @var Array<class-string<IParser>> */
    protected static array $registered = [];

    /**
     * @param class-string<IParser> $parserClass
     */
    public static function register(string $parserClass): void
    {
        self::assertClass($parserClass);

        if (!in_array($parserClass, self::$registered, true)) {
            self::$registered[] = $parserClass;
        }
    }

    protected static function assertClass(string $class): void
    {
        if (!is_subclass_of($class, IParser::class)) {
            throw new InvalidArgument(
                sprintf(
                    'Parser class "%s" must implement "%s" interface.',
                    $class,
                    IParser::class,
                )
            );
        }
    }

    public function getByValue(mixed $value): IParser
    {
        return $this->findByValue($value)
            ??
            throw new InvalidArgument($this->createErrorMessage($value));
    }

    public function findByValue(mixed $value): ?IParser
    {
        /** @var class-string<IParser> $class */
        foreach ($this->getRegistered() as $class) {
            $parser = new $class();
            if ($parser->isSupported($value)) {
                return $parser;
            }
        }

        return null;
    }

    private function getRegistered(): array
    {
        return array_reverse(self::$registered, true);
    }

    private function createErrorMessage(mixed $value): string
    {
        return is_string($value)
            ? sprintf('Parser for color "%s" is not registered.', $value)
            : sprintf('Parser for value of type "%s" is not registered.', get_debug_type($value));
    }
}
