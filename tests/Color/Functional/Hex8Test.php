<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional;

use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\HSL;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Hex8Test extends TestCase
{
    public static function canBeCreatedFromInteger8DataProvider(): iterable
    {
        foreach (self::canBeCreatedFromInteger8DataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::RED => $resulting[1],
                        self::GREEN => $resulting[2],
                        self::BLUE => $resulting[3],
                        self::ALPHA => $resulting[4],
                        self::TO_STRING => $resulting[5],
                    ]
                ],
                [
                    self::VALUE => $incoming[0],
                ]
            ];
        }
    }

    private static function canBeCreatedFromInteger8DataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, r, g, b, a, toString], (incoming)[value8]
            [[0x89ABCD, 0x89, 0xAB, 0xCD, 0xEF, '#89abcdef'], [0x89ABCDEF]],
            [[0xFEDCBA, 0xFE, 0xDC, 0xBA, 0x98, '#fedcba98'], [0xFEDCBA98]],
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 0xFF, '#ff00ffff'], [0xFF00FFFF]],
            [[0x00FF00, 0x00, 0xFF, 0x00, 0xFF, '#00ff00ff'], [0x00FF00FF]],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0xFF, '#0000ffff'], [0x0000FFFF]],
            [[0x000000, 0x00, 0x00, 0x00, 0xFF, '#000000ff'], [0x000000FF]],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0xFF, '#ffffffff'], [0xFFFFFFFF]],
            [[0x110000, 0x11, 0x00, 0x00, 0xFF, '#110000ff'], [0x110000FF]],
            [[0x00ae00, 0x00, 0xae, 0x00, 0xFF, '#00ae00ff'], [0x00AE00FF]],
        ];
    }

    public static function canGetValue8DataProvider(): iterable
    {
        foreach (self::canGetValue8DataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::VALUE => $resulting[0],
                    self::VALUE_8 => $resulting[1],
                    self::ALPHA => $resulting[2],
                    self::TO_STRING => $resulting[3],
                ],
                $incoming,
            ];
        }
    }

    private static function canGetValue8DataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, value8, a, toString], (incoming)value
            [[0xFF00FF, 0xFF00FF00, 0x00, '#ff00ff00'], 0xFF00FF00],
            [[0x00FF00, 0x00FF00AD, 0xAD, '#00ff00ad'], 0x00FF00AD],
            [[0x0000FF, 0x0000FF00, 0x00, '#0000ff00'], 0x0000FF00],
            [[0x000000, 0x00000011, 0x11, '#00000011'], 0x00000011],
            [[0xFFFFFF, 0xFFFFFF00, 0x00, '#ffffff00'], 0xFFFFFF00],
            [[0x110000, 0x11000022, 0x22, '#11000022'], 0x11000022],
            [[0x00AE00, 0x00AE0000, 0x00, '#00ae0000'], 0x00AE0000],
            [[0x0AAE00, 0x0AAE00DD, 0xDD, '#0aae00dd'], 0x0AAE00DD],
        ];
    }

    public static function canBeCreatedFromStringDataProvider(): iterable
    {
        foreach (self::canBeCreatedFromStringDataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::RED => $resulting[1],
                        self::GREEN => $resulting[2],
                        self::BLUE => $resulting[3],
                        self::ALPHA => $resulting[4],
                        self::TO_STRING => $resulting[5],
                    ]
                ],
                [
                    self::VALUE => $incoming[0],
                ]
            ];
        }
    }

    private static function canBeCreatedFromStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, r, g, b, a, toString], (incoming)[value]
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 0xFF, '#ff00ffff'], ['#ff00ff']],
            [[0x00FF00, 0x00, 0xFF, 0x00, 0xFF, '#00ff00ff'], ['#00ff00']],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0xFF, '#0000ffff'], ['#0000ff']],
            [[0x000000, 0x00, 0x00, 0x00, 0xFF, '#000000ff'], ['#000000']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0xFF, '#ffffffff'], ['#ffffff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0xFF, '#ffffffff'], ['ffffff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0xFF, '#ffffffff'], ['fff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0xFF, '#ffffffff'], ['#fff']],
            [[0x110000, 0x11, 0x00, 0x00, 0xFF, '#110000ff'], ['#110000']],
            [[0x00ae00, 0x00, 0xae, 0x00, 0xFF, '#00ae00ff'], ['#00ae00']],
        ];
    }

    #[Test]
    #[DataProvider('canGetValue8DataProvider')]
    public function canGetValue8(array $expected, int $incoming): void
    {
        $testee = Hex8::fromInteger8($incoming);

        self::assertSame(dechex($expected[self::VALUE]), dechex($testee->getValue()));
        self::assertSame(dechex($expected[self::VALUE_8]), dechex($testee->getValue8()));
        self::assertSame(dechex($expected[self::ALPHA]), dechex($testee->getAlpha()));
        self::assertSame($expected[self::TO_STRING], $testee->toString());
        self::assertSame($expected[self::TO_STRING], (string)$testee);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromInteger8DataProvider')]
    public function canBeCreatedFromInteger8(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $value = $incoming[self::VALUE];
        $testee = self::getTesteeFromInteger8($value);
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::TO_STRING], $testee->toString());
    }

    private static function getTesteeFromInteger8(int $value8): IHex8Color
    {
        return Hex8::fromInteger8($value8);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromStringDataProvider')]
    public function canBeCreatedFromString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $value = $incoming[self::VALUE];
        $testee = self::getTesteeFromString($value);
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::TO_STRING], $testee->toString());
    }

    private static function getTesteeFromString(string $value): IHex8Color
    {
        return Hex8::fromString($value);
    }

    #[Test]
    public function canBeImmutablyModifiedByWithMethods(): void
    {
        $testee = self::getTesteeFromInteger(0x000000);

        $modifiedRed = $testee->withRed(0xFF);
        self::assertNotSame($testee, $modifiedRed);
        self::assertSame(0x00, $testee->getRed());
        self::assertSame(0xFF, $modifiedRed->getRed());
        $modifiedGreen = $testee->withGreen(0xFF);
        self::assertNotSame($testee, $modifiedGreen);
        self::assertSame(0x00, $testee->getGreen());
        self::assertSame(0xFF, $modifiedGreen->getGreen());
        $modifiedBlue = $testee->withBlue(0xFF);
        self::assertNotSame($testee, $modifiedBlue);
        self::assertSame(0x00, $testee->getBlue());
        self::assertSame(0xFF, $modifiedBlue->getBlue());
    }

    #[Test]
    public function canFrom(): void
    {
        $color = HSL::fromString('black');
        self::assertInstanceOf(Hex8::class, Hex8::from($color));
    }

    private static function getTesteeFromInteger(int $value): IHex8Color
    {
        return Hex8::fromInteger($value);
    }

}
