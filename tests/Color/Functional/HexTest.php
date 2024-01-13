<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HexTest extends TestCase
{
    public static function canBeCreatedFromIntegerDataProvider(): iterable
    {
        foreach (self::canBeCreatedFromIntegerDataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::RED => $resulting[1],
                        self::GREEN => $resulting[2],
                        self::BLUE => $resulting[3],
                        self::TO_STRING => $resulting[4],
                    ]
                ],
                [
                    self::VALUE => $incoming[0],
                ]
            ];
        }
    }

    private static function canBeCreatedFromIntegerDataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, r, g, b, toString], (incoming)[value]
            [[0xFF00FF, 0xFF, 0x00, 0xFF, '#ff00ff'], [0xFF00FF]],
            [[0x00FF00, 0x00, 0xFF, 0x00, '#00ff00'], [0x00FF00]],
            [[0x0000FF, 0x00, 0x00, 0xFF, '#0000ff'], [0x0000FF]],
            [[0x000000, 0x00, 0x00, 0x00, '#000000'], [0x000000]],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, '#ffffff'], [0xFFFFFF]],
            [[0x110000, 0x11, 0x00, 0x00, '#110000'], [0x110000]],
            [[0x00ae00, 0x00, 0xae, 0x00, '#00ae00'], [0x00AE00]],
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
                        self::TO_STRING => $resulting[4],
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
            // (resulting)[value, r, g, b, toString], (incoming)[value]
            [[0xFF00FF, 0xFF, 0x00, 0xFF, '#ff00ff'], ['#ff00ff']],
            [[0x00FF00, 0x00, 0xFF, 0x00, '#00ff00'], ['#00ff00']],
            [[0x0000FF, 0x00, 0x00, 0xFF, '#0000ff'], ['#0000ff']],
            [[0x000000, 0x00, 0x00, 0x00, '#000000'], ['#000000']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, '#ffffff'], ['#ffffff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, '#ffffff'], ['ffffff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, '#ffffff'], ['fff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, '#ffffff'], ['#fff']],
            [[0x110000, 0x11, 0x00, 0x00, '#110000'], ['#110000']],
            [[0x00ae00, 0x00, 0xae, 0x00, '#00ae00'], ['#00ae00']],
        ];
    }

    #[Test]
    #[DataProvider('canBeCreatedFromIntegerDataProvider')]
    public function canBeCreatedFromInteger(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $value = $incoming[self::VALUE];
        $testee = self::getTesteeFromInteger($value);
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::TO_STRING], $testee->toString());
    }

    private static function getTesteeFromInteger(int $value): IHexColor
    {
        return Hex::fromInteger($value);
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

    private static function getTesteeFromString(string $value): IHexColor
    {
        return Hex::fromString($value);
    }

    #[Test]
    public function canFrom(): void
    {
        $color = HSL::fromString('black');
        self::assertInstanceOf(Hex::class, Hex::from($color));
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

}
