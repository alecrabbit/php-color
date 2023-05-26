<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color;

use AlecRabbit\Color\RGB;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ColorTest extends TestCase
{
    // 4294967295 = 0xFFFFFFFF
    public static function createdWithDataProvider(): iterable
    {
        foreach (self::createdWithDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => $item[0]
                ],
                [
                    self::VALUE => $item[1]
                ]
            ];
        }
    }

    private static function createdWithDataFeeder(): iterable
    {
        yield from [
            // result, value
            [0x12345678, -0x12345678],           // #0
            [0xFFFFFFFF, -0xFFFFFFFFFF],         // #1
            [0xFFFFFFFF, 0xFFFFFFFFFF],          // #2
            [0xFFFFFFFF, 0xFFFFFFFF],            // #3
            [0x000000FF, 0xFF],                  // #4
            [0x0000FF00, 0xFF00],                // #5
            [0x00FF0000, 0xFF0000],              // #6
            [0xFF000000, 0xFF000000],            // #7
            [0xFFFFFFFF, PHP_INT_MAX], // 64bit  // #8
            [0x000000FF, -0xFF],                 // #9
            [0x0000FF00, -0xFF00],               // #10
            [0x00FF0000, -0xFF0000],             // #11
            [0xFF000000, -0xFF000000],           // #12
            [0xFFFFFFFF, -PHP_INT_MAX], // 64bit // #13
        ];
    }

    public static function canBeCreatedFromRGBODataProvider(): iterable
    {
        foreach (self::canBeCreatedFromRGBODataFeeder() as $item) {
            $set = $item[1];
            yield [
                [
                    self::RESULT => $item[0]
                ],
                [
                    self::VALUE => [
                        self::RED => $set[0],
                        self::GREEN => $set[1],
                        self::BLUE => $set[2],
                        self::OPACITY => $set[3],
                    ],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBODataFeeder(): iterable
    {
        yield from [
            // result, [r , g, b, opacity]
            [0x00FF00FF, [0xFF, 0x00, 0xFF, 0.0]],    // #0
            [0xFFFF00FF, [0xFF, 0x00, 0xFF, 1.0]],    // #1
            [0xFFFFFFFF, [255, 255, 255, 1.0]],       // #2
            [0x00000000, [256, 256, 256, 0.0]],       // #3
            [0xFF000000, [256, 256, 256, 1.0]],       // #4
            [0xFF252525, [0x25, 0x25, 0x25, 1.0]],    // #5
            [0x7F252525, [0x25, 0x25, 0x25, 0.5]],    // #6
            [0x00FF00FF, [-0xFF, 0x00, 0xFF, 0.0]],   // #7
            [0xFFFF00FF, [0xFF, 0x00, 0xFF, -1.0]],   // #8
            [0xFFFFFFFF, [255, 255, 255, 1.0]],       // #9
            [0x00000000, [256, -256, 256, 0.0]],      // #10
            [0xFF000000, [256, 256, -256, 1.0]],      // #11
            [0xFF252825, [0x25, 0x28, -0x25, 1.0]],   // #12
            [0x7F282525, [0x28, 0x25, 0x25, 0.5]],    // #13
        ];
    }

    public static function canBeCreatedFromRGBADataProvider(): iterable
    {
        foreach (self::canBeCreatedFromRGBADataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::ALPHA => $resulting[1][0],
                        self::RED => $resulting[1][1],
                        self::GREEN => $resulting[1][2],
                        self::BLUE => $resulting[1][3],
                        self::OPACITY => $resulting[1][4],
                    ]
                ],
                [
                    self::VALUE => [
                        self::ALPHA => $incoming[0],
                        self::RED => $incoming[1],
                        self::GREEN => $incoming[2],
                        self::BLUE => $incoming[3],
                    ],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBADataFeeder(): iterable
    {
        yield from [
            // [value, [alpha, r, g, b, opacity]], (incoming)[alpha, r, g, b]
            [[0x00FF00FF, [0x00, 0xFF, 0x00, 0xFF, 0.0]], [0x00, 0xFF, 0x00, 0xFF,]],     // #0
            [[0xFFFF00FF, [0xFF, 0xFF, 0x00, 0xFF, 1.0]], [0xFF, 0xFF, 0x00, 0xFF,]],     // #1
            [[0xFFFFFFFF, [0xFF, 0xFF, 0xFF, 0xFF, 1.0]], [0xFF, 255, 255, 255,]],        // #2
            [[0x00000000, [0x00, 0x00, 0x00, 0x00, 0.0]], [0x00, 256, 256, 256,]],        // #3
            [[0xFF000000, [0xFF, 0x00, 0x00, 0x00, 1.0]], [0xFF, 256, 256, 256,]],        // #4
            [[0xFF252525, [0xFF, 0x25, 0x25, 0x25, 1.0]], [0xFF, 0x25, 0x25, 0x25,]],     // #5
            [[0x7F252525, [0x7F, 0x25, 0x25, 0x25, 0.498]], [0x7F, 0x25, 0x25, 0x25,]],   // #6
            [[0x01282825, [0x01, 0x28, 0x28, 0x25, 0.004]], [0x01, 0x28, 0x28, 0x25,]],   // #7
            [[0xFE282825, [0xFE, 0x28, 0x28, 0x25, 0.996]], [0xFE, 0x28, 0x28, 0x25,]],   // #8
            [[0x00FF00FF, [0x00, 0xFF, 0x00, 0xFF, 0.0]], [0x00, -0xFF, 0x00, 0xFF,]],    // #9
            [[0xFFFF00FF, [0xFF, 0xFF, 0x00, 0xFF, 1.0]], [0xFF, 0xFF, 0x00, -0xFF,]],    // #10
            [[0xFFFFFFFF, [0xFF, 0xFF, 0xFF, 0xFF, 1.0]], [0xFF, 255, 255, -255,]],       // #11
            [[0x00000000, [0x00, 0x00, 0x00, 0x00, 0.0]], [0x00, -256, 256, 256,]],       // #12
            [[0xFF000000, [0xFF, 0x00, 0x00, 0x00, 1.0]], [0xFF, 256, -256, 256,]],       // #13
            [[0xFF252525, [0xFF, 0x25, 0x25, 0x25, 1.0]], [0xFF, 0x25, -0x25, 0x25,]],    // #14
            [[0x7F252525, [0x7F, 0x25, 0x25, 0x25, 0.498]], [-0x7F, 0x25, 0x25, 0x25,]],  // #15
            [[0x01282825, [0x01, 0x28, 0x28, 0x25, 0.004]], [-0x01, 0x28, -0x28, 0x25,]], // #16
            [[0xFE282825, [0xFE, 0x28, 0x28, 0x25, 0.996]], [0xFE, -0x28, 0x28, 0x25,]],  // #17
        ];
    }

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTesteeInstance();
        self::assertInstanceOf(RGB::class, $testee);
    }

    protected static function getTesteeInstance(?int $value = null): IColor
    {
        return
            new RGB($value ?? 0);
    }

    #[Test]
    public function canGetValue(): void
    {
        $testee = self::getTesteeInstance();
        self::assertIsInt($testee->getValue());
    }

    #[Test]
    public function canGetValueCreatedWith(): void
    {
        $value = 0x12345678;
        $testee = self::getTesteeInstance($value);
        self::assertSame($value, $testee->getValue());
    }

    #[Test]
    public function canGetValueIfCreatedWithNegative(): void
    {
        $testee = self::getTesteeInstance(-0x12345678);
        self::assertSame(0x12345678, $testee->getValue());
    }

    #[Test]
    #[DataProvider('createdWithDataProvider')]
    public function createdWith(array $expected, array $incoming): void
    {
        $value = $incoming[self::VALUE];
        $result = $expected[self::RESULT];
        $testee = self::getTesteeInstance($value);
        self::assertSame($result, $testee->getValue());
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBODataProvider')]
    public function canBeCreatedFromRGBO(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $testee = self::getTesteeFromRGBO($incoming[self::VALUE]);
        self::assertSame($result, $testee->getValue());
    }

    private static function getTesteeFromRGBO(array $rgbo): IColor
    {
        return RGB::fromRGBO(
            $rgbo[self::RED],
            $rgbo[self::GREEN],
            $rgbo[self::BLUE],
            $rgbo[self::OPACITY],
        );
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBADataProvider')]
    public function canBeCreatedFromRGBA(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $rgba = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGBA($rgba);
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
        self::assertEquals($result[self::OPACITY], $testee->getOpacity());
    }

    private static function getTesteeFromRGBA(array $rgba): IColor
    {
        return RGB::fromRGBA(
            $rgba[self::RED],
            $rgba[self::GREEN],
            $rgba[self::BLUE],
            $rgba[self::ALPHA],
        );
    }
}
