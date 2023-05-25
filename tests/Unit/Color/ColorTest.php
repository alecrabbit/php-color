<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color;

use AlecRabbit\Color\Color;
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
            [0x12345678, -0x12345678],
            [0xFFFFFFFF, -0xFFFFFFFFFF],
            [0xFFFFFFFF, 0xFFFFFFFFFF],
            [0xFFFFFFFF, 0xFFFFFFFF],
            [0x000000FF, 0xFF],
            [0x0000FF00, 0xFF00],
            [0x00FF0000, 0xFF0000],
            [0xFF000000, 0xFF000000],
            [0xFFFFFFFF, PHP_INT_MAX], // 64bit
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
            [0x00FF00FF, [0xFF, 0x00, 0xFF, 0.0]],
            [0xFFFF00FF, [0xFF, 0x00, 0xFF, 1.0]],
            [0xFFFFFFFF, [255, 255, 255, 1.0]],
            [0x00000000, [256, 256, 256, 0.0]],
            [0xFF000000, [256, 256, 256, 1.0]],
            [0xFF252525, [0x25, 0x25, 0x25, 1.0]],
            [0x7F252525, [0x25, 0x25, 0x25, 0.5]],
        ];
    }

    private static function getTesteeFromRGBO(array $rgbo): IColor
    {
        return Color::fromRGBO(
            $rgbo[self::RED],
            $rgbo[self::GREEN],
            $rgbo[self::BLUE],
            $rgbo[self::OPACITY],
        );
    }

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTesteeInstance();
        self::assertInstanceOf(Color::class, $testee);
    }

    protected static function getTesteeInstance(?int $value = null): IColor
    {
        return
            new Color($value ?? 0);
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
}
