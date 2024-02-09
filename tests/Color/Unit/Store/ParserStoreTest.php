<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Store;

use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Contract\Store\IParserStore;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Parser\HEXAParser;
use AlecRabbit\Color\Parser\HSLAParser;
use AlecRabbit\Color\Parser\RGBAParser;
use AlecRabbit\Color\Store\ParserStore;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use stdClass;

final class ParserStoreTest extends TestCase
{
    public static function canProvideParserDataProvider(): iterable
    {
        yield from [
            [RGBAParser::class, 'rgb(0, 0, 0)'],
            [HEXAParser::class, '000'],
            [HSLAParser::class, 'hsl(0, 0%, 0%)'],
        ];
    }

    public static function throwsIfProvidedValueIsInvalidDataProvider(): iterable
    {
        yield from [
            ['', 'Parser for color "" is not registered.'],
            ['blabla', 'Parser for color "blabla" is not registered.'],
            [1, 'Parser for value of type "int" is not registered.'],
            [new stdClass(), 'Parser for value of type "stdClass" is not registered.'],
            [stdClass::class, 'Parser for color "stdClass" is not registered.'],
        ];
    }

    #[Test]
    #[DataProvider('canProvideParserDataProvider')]
    public function canProvideParser(string $class, string $color): void
    {
        $factory = $this->getTestee();
        $parser = $factory->getByValue($color);

        self::assertInstanceOf($class, $parser);
    }

    protected function getTestee(): IParserStore
    {
        return new ParserStore();
    }

    #[Test]
    public function throwsIfParserClassProvidedIsInvalid(): void
    {
        $class = stdClass::class;

        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            sprintf(
                'Parser class "%s" must implement "%s" interface.',
                $class,
                IParser::class,
            )
        );

        ParserStore::register($class);

        self::fail('Exception was not thrown.');
    }

    #[Test]
    #[DataProvider('throwsIfProvidedValueIsInvalidDataProvider')]
    public function throwsIfProvidedColorStringIsInvalid(mixed $value, string $message): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage($message);

        $this->getTestee()->getByValue($value);

        self::fail('Exception was not thrown.');
    }
}
