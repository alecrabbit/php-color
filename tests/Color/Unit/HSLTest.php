<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\HSL;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class HSLTest extends TestCase
{
    public static function canBeCreatedFromHSLDataProvider(): iterable
    {
        foreach (self::canBeCreatedFromHSLDataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::HUE => $resulting[0],
                        self::SATURATION => $resulting[1],
                        self::LIGHTNESS => $resulting[2],
                    ]
                ],
                [
                    self::VALUE => [
                        self::HUE => $incoming[0],
                        self::SATURATION => $incoming[1],
                        self::LIGHTNESS => $incoming[2],
                    ],
                ]
            ];
        }
    }

    private static function canBeCreatedFromHSLDataFeeder(): iterable
    {
        yield from [
            // (resulting)[h, s, l], (incoming)[h, s, l]
            [[124, 0.0, 0.5], [124, 0.0, 0.5]],
            [[359, 0.0, 0.0], [-1, 0, 0]],
            [[359, 1.0, 0.0], [-1, 2, 0]],
            [[14, 0.0, 1.0], [14, 0, 2]],
            [[114, 0.5, 0.5,], [114, 0.5, 0.5]],
            [[359, 0.5, 0.5,], [-1, 0.5, 0.5]],
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
                    ],
                ]
            ];
        }
    }

    private static function canBeConvertedToStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)[h, s, l], (incoming)[h, s, l]
            ['hsl(124, 0%, 50%)', [124, 0.0, 0.5]],
            ['hsl(0, 0%, 0%)', [0, 0, 0]],
            ['hsl(350, 20%, 0%)', [350, 0.2, 0]],
            ['hsl(350, 20%, 0%)', [350, 0.2, 0]],
            ['hsl(14, 0%, 100%)', [14, 0, 1]],
            ['hsl(114, 50%, 50%)', [114, 0.5, 0.5]],
            ['hsl(350, 50%, 50%)', [350, 0.5, 0.5]],
            ['hsl(123, 39%, 89%)', [123, 0.39, 0.89]],
            ['hsl(123, 30%, 92%)', [123, 0.3, 0.92]],
            ['hsl(350, 50%, 50%)', [710, 0.5, 0.5]],
            ['hsl(32, 34%, 100%)', [32, 0.34, 1]],
        ];
    }

    #[Test]
    #[DataProvider('canBeCreatedFromHSLDataProvider')]
    public function canBeCreatedFromHSL(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $hsl = $incoming[self::VALUE];
        $testee = self::getTesteeFromHSL($hsl);
        self::assertSame($result[self::HUE], $testee->getHue());
        self::assertSame($result[self::SATURATION], $testee->getSaturation());
        self::assertSame($result[self::LIGHTNESS], $testee->getLightness());
    }

    private static function getTesteeFromHSL(array $hsl): IHSLColor
    {
        return
            HSL::fromHSL(
                $hsl[self::HUE],
                $hsl[self::SATURATION],
                $hsl[self::LIGHTNESS],
            );
    }

    #[Test]
    #[DataProvider('canBeConvertedToStringDataProvider')]
    public function canBeConvertedToString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $hsl = $incoming[self::VALUE];
        $testee = self::getTesteeFromHSL($hsl);
        self::assertSame($result, $testee->toString());
    }


    #[Test]
    public function canBeModifiedWithHue(): void
    {
        $original = self::getTesteeFromHSL(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
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
        $original = self::getTesteeFromHSL(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
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
        $original = self::getTesteeFromHSL(
            [
                self::HUE => 0,
                self::SATURATION => 0,
                self::LIGHTNESS => 0,
            ]
        );
        $modified = $original->withLightness(0.24);
        self::assertSame(0.0, $original->getLightness());
        self::assertSame(0.24, $modified->getLightness());
        self::assertNotSame($original, $modified);
    }

}
