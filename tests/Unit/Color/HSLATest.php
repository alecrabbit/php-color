<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color;

use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HSLATest extends TestCase
{
    public static function canBeCreatedFromHSLADataProvider(): iterable
    {
        foreach (self::canBeCreatedFromHSLADataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::HUE => $resulting[0],
                        self::SATURATION => $resulting[1],
                        self::LIGHTNESS => $resulting[2],
                        self::OPACITY => $resulting[3],
                        self::ALPHA => $resulting[4],
                    ]
                ],
                [
                    self::VALUE => [
                        self::HUE => $incoming[0],
                        self::SATURATION => $incoming[1],
                        self::LIGHTNESS => $incoming[2],
                        self::OPACITY => $incoming[3],

                    ],
                ]
            ];
        }
    }

    private static function canBeCreatedFromHSLADataFeeder(): iterable
    {
        yield from [
            // (resulting)[h, s, l, Opacity, alpha], (incoming)[h, s, l, O]
            [[124, 0.0, 0.5, 1.0, 255], [124, 0.0, 0.5, 1]],
            [[359, 0.0, 0.0, 0.73, 186], [-1, 0, 0, 0.7311]],
            [[359, 1.0, 0.0, 0.56, 143], [-1, 2, 0, 0.557]],
            [[14, 0.0, 1.0, 0.0, 0], [14, 0, 2, 0]],
            [[114, 0.5, 0.5, 0.5, 128], [114, 0.5, 0.5, 0.5]],
            [[359, 0.5, 0.5, 1.0, 255], [-1, 0.5, 0.5, 2]],
            [[359, 0.5, 0.5, 0.0, 0], [-1, 0.5, 0.5, -1]],
            [[359, 0.0, 0.5, 0.0, 0], [-1, -0.5, 0.5, -1]],
        ];
    }

    public static function canBeConvertedToStringDataProvider(): iterable
    {
        foreach (self::canBeConvertedToStringDataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => $resulting,
                ],
                [
                    self::VALUE => [
                        self::HUE => $incoming[0],
                        self::SATURATION => $incoming[1],
                        self::LIGHTNESS => $incoming[2],
                        self::OPACITY => $incoming[3],
                    ],
                ]
            ];
        }
    }

    private static function canBeConvertedToStringDataFeeder(): iterable
    {
        yield from [
            // (resulting), (incoming)[h, s, l, O]
            ['hsla(124, 0%, 50%, 1)', [124, 0.0, 0.5, 1]],
//            ['hsla(0, 0%, 0%)', [0, 0, 0]],
//            ['hsla(350, 20%, 0%)', [350, 0.2, 0]],
//            ['hsla(350, 20%, 0%)', [350, 0.2, 0]],
//            ['hsla(14, 0%, 100%)', [14, 0, 1]],
//            ['hsla(114, 50%, 50%)', [114, 0.5, 0.5]],
//            ['hsla(350, 50%, 50%)', [350, 0.5, 0.5]],
//            ['hsla(123, 39%, 89%)', [123, 0.39, 0.89]],
//            ['hsla(123, 30%, 92%)', [123, 0.3, 0.92]],
//            ['hsla(350, 50%, 50%)', [710, 0.5, 0.5]],
//            ['hsla(32, 34%, 100%)', [32, 0.34, 1]],
        ];
    }

    #[Test]
    #[DataProvider('canBeCreatedFromHSLADataProvider')]
    public function canBeCreatedFromHSLA(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $hsla = $incoming[self::VALUE];
        $testee = self::getTesteeFromHSLA($hsla);
        self::assertSame($result[self::HUE], $testee->getHue());
        self::assertSame($result[self::SATURATION], $testee->getSaturation());
        self::assertSame($result[self::LIGHTNESS], $testee->getLightness());
        self::assertSame($result[self::OPACITY], $testee->getOpacity());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
    }

    private static function getTesteeFromHSLA(array $hsla): IHSLAColor
    {
        return
            HSLA::fromHSLA(
                $hsla[self::HUE],
                $hsla[self::SATURATION],
                $hsla[self::LIGHTNESS],
                $hsla[self::OPACITY]
            );
    }

    #[Test]
    #[DataProvider('canBeConvertedToStringDataProvider')]
    public function canBeConvertedToString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $hsla = $incoming[self::VALUE];
        $testee = self::getTesteeFromHSLA($hsla);
        self::assertSame($result, $testee->toString());
    }


    #[Test]
    public function canBeModifiedWithHue(): void
    {
        $original = self::getTesteeFromHSLA(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
                self::OPACITY => 0,
            ]
        );
        $modified = $original->withHue(22);
        self::assertSame(0, $original->getHue());
        self::assertSame(22, $modified->getHue());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithSaturation(): void
    {
        $original = self::getTesteeFromHSLA(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
                self::OPACITY => 0,
            ]
        );
        $modified = $original->withSaturation(0.33);
        self::assertSame(0.0, $original->getSaturation());
        self::assertSame(0.33, $modified->getSaturation());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithLightness(): void
    {
        $original = self::getTesteeFromHSLA(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
                self::OPACITY => 0,
            ]
        );
        $modified = $original->withLightness(0.24);
        self::assertSame(0.0, $original->getLightness());
        self::assertSame(0.24, $modified->getLightness());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithOpacity(): void
    {
        $original = self::getTesteeFromHSLA(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
                self::OPACITY => 0,
            ]
        );
        $modified = $original->withOpacity(0.74);
        self::assertSame(0.0, $original->getOpacity());
        self::assertSame(0.74, $modified->getOpacity());
        self::assertNotSame($original, $modified);
    }
    #[Test]
    public function canBeModifiedWithAlpha(): void
    {
        $original = self::getTesteeFromHSLA(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
                self::OPACITY => 0,
            ]
        );
        $modified = $original->withAlpha(233);
        self::assertSame(0, $original->getAlpha());
        self::assertSame(232, $modified->getAlpha());
        self::assertNotSame($original, $modified);
    }

}
