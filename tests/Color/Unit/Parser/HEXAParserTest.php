<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Parser;

use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Parser\HEXAParser;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HEXAParserTest extends TestCase
{
    public static function canParseDataProvider(): iterable
    {
        foreach (self::canParseDataFeeder() as $item) {
            yield [
                [self::RESULT => $item[0],],
                $item[1],
            ];
        }
        yield from [
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Invalid color format: "hsl(0 0% 0% / 0.5)".',
                    ],
                ],
                'hsl(0 0% 0% / 0.5)',
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Invalid color format: "rgb(0, 0, 0)".',
                    ],
                ],
                'rgb(0, 0, 0)',
            ],
        ];
    }

    private static function canParseDataFeeder(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0), '#000'],
            [new DRGB(0, 0, 0), '(#000)'],
            [new DRGB(0, 0, 0, 0), '(#0000)'],
            [new DRGB(0, 0, 0, 0.666667), '(#a000)'],
            [new DRGB(0, 0, 0, 0), '0000'],
            [new DRGB(1, 1, 1, 1), 'ffff'],
            [new DRGB(1, 1, 1, 1), '(ffff)'],
            [new DRGB(1, 1, 1, 1), '(#ffff)'],
            [new DRGB(0.066667, 0.133333, 0.2, 0.266667), '11223344'],
            [new DRGB(0.666667, 0.733333, 0.8, 0.866667), '#abcd'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $parser = $this->getTesteeInstance();

        self::assertInstanceOf(IDRGBParser::class, $parser);
        self::assertInstanceOf(HEXAParser::class, $parser);
    }

    protected function getTesteeInstance(): IParser
    {
        return new HEXAParser();
    }

    #[Test]
    #[DataProvider('canParseDataProvider')]
    public function canParse(array $expected, string $input): void
    {
        $expectedException = $this->expectsException($expected);
        $exceptionMessage =
            $expectedException === null ?: $expectedException->getMessage();

        if ($expectedException) {
            $this->expectException($expectedException::class);
            $this->expectExceptionMessage($exceptionMessage);
        }

        $parser = $this->getTesteeInstance();

        $color = $parser->parse($input);

        if ($expectedException) {
            self::fail(
                'Exception was not thrown.' . ' ' . $exceptionMessage
            );
        }

        self::assertTrue($parser->isSupported($input));

        $expectedResult = $expected[self::RESULT];
        self::assertEquals($expectedResult, $color);
    }
}
