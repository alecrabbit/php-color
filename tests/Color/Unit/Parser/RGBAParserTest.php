<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Parser;

use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Parser\RGBAParser;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBAParserTest extends TestCase
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
                        self::MESSAGE => 'Invalid color format: "#fff".',
                    ],
                ],
                '#fff',
            ],
        ];
    }

    private static function canParseDataFeeder(): iterable
    {
        yield from [
            [new DRGB(0, 0, 0), 'rgb(0, 0, 0)'],
            [new DRGB(0, 0, 0, 0), 'rgba(0, 0, 0, 0)'],
            [new DRGB(1, 1, 1, 0), 'rgba(255, 255, 255, 0)'],
            [new DRGB(0.501961, 0.501961, 0.501961, 0.5), 'rgba(128, 128, 128, 0.5)'],
            [new DRGB(0.12549, 0.176471, 0.305882, 0.78), 'rgb(32, 45, 78, 0.78)'],
//            [new DRGB(0.12549,0.176471,0.305882, 0.78), 'rgb(32 45 78 / 78%)'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $parser = $this->getTesteeInstance();

        self::assertInstanceOf(IDRGBParser::class, $parser);
        self::assertInstanceOf(RGBAParser::class, $parser);
    }

    protected function getTesteeInstance(): IParser
    {
        return new RGBAParser();
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
