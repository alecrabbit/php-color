<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Parser;

use AlecRabbit\Color\Contract\Parser\IDRGBParser;
use AlecRabbit\Color\Contract\Parser\IParser;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Parser\NameParser;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class NameParserTest extends TestCase
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
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Invalid color format: "000".',
                    ],
                ],
                '000',
            ],
            [
                [
                    self::EXCEPTION => [
                        self::CLASS_ => InvalidArgument::class,
                        self::MESSAGE => 'Invalid color format: "#000".',
                    ],
                ],
                '#000',
            ],
        ];
    }

    private static function canParseDataFeeder(): iterable
    {
        yield from [
            [new DRGB(0.545098, 0, 0.545098), 'darkmagenta'],
            [new DRGB(0, 0, 1), 'blue'],
            [new DRGB(0.627451,0.321569,0.176471), 'sienna'],
            [new DRGB(0.254902,0.411765,0.882353), 'royalblue'],
            [new DRGB(1.0,0.980392,0.980392), 'snow'],
            [new DRGB(0.933333,0.509804,0.933333), 'violet'],
            [new DRGB(0.603922,0.803922,0.196078), 'yellowgreen'],
            [new DRGB(1,0.713725,0.756863), 'lightpink'],
        ];
    }

    #[Test]
    public function canBeInstantiated(): void
    {
        $parser = $this->getTesteeInstance();

        self::assertInstanceOf(IDRGBParser::class, $parser);
        self::assertInstanceOf(NameParser::class, $parser);
    }

    protected function getTesteeInstance(): IParser
    {
        return new NameParser();
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
