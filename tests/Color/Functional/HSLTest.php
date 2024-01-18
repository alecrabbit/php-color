<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class HSLTest extends TestCase
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
            [[350, 0.5, 0.5,], [710, 0.5, 0.5]],
            [[305, 0.5, 0.5,], [2345345, 0.5, 0.5]],
            [[305, 1.0, 1.0,], [2345345, 15, 15]],
        ];
    }

    public static function canBeConvertedToStringDataProvider(): iterable
    {
        foreach (self::canBeConvertedToStringDataFeeder() as $item) {
            [$left, $right] = $item;
            yield [
                [
                    self::RESULT => $left,
                ],
                [
                    self::VALUE => [
                        self::HUE => $right[0],
                        self::SATURATION => $right[1],
                        self::LIGHTNESS => $right[2],
                    ],
                ]
            ];
        }
    }

    private static function canBeConvertedToStringDataFeeder(): iterable
    {
        yield from [
            // (left)[h, s, l], (right)[h, s, l]
            ['hsl(124, 0%, 50%)', [124, 0.0, 0.5]],
            ['hsl(0, 0%, 0%)', [0, 0, 0]],
            ['hsl(350, 20%, 0%)', [350, 0.2, 0]],
            ['hsl(350, 20%, 0%)', [350, 0.2, 0]],
            ['hsl(14, 0%, 100%)', [14, 0, 1]],
            ['hsl(114, 50%, 50%)', [114, 0.5, 0.5]],
            ['hsl(350, 50%, 50%)', [350, 0.5, 0.5]],
            ['hsl(123, 39%, 89%)', [123, 0.39, 0.89]],
            ['hsl(123, 30%, 92%)', [123, 0.3, 0.92]],
            ['hsl(32, 34%, 100%)', [32, 0.34, 1]],
        ];
    }

    public static function canBeCreatedFromStringDataProvider(): iterable
    {
        foreach (self::canBeConvertedToStringDataFeeder() as $item) {
            [$left, $right] = $item;
            yield [
                [
                    self::RESULT => [
                        self::HUE => $right[0],
                        self::SATURATION => $right[1],
                        self::LIGHTNESS => $right[2],
                    ],
                ],
                [
                    self::VALUE => $left,
                ]
            ];
        }

        foreach (self::canBeCreatedFromStringDataFeeder() as $item) {
            [$left, $right] = $item;
            yield [
                [
                    self::RESULT => [
                        self::HUE => $right[0],
                        self::SATURATION => $right[1],
                        self::LIGHTNESS => $right[2],
                    ],
                ],
                [
                    self::VALUE => $left,
                ]
            ];
        }
    }

    private static function canBeCreatedFromStringDataFeeder(): iterable
    {
        yield from [
            // (left)[h, s, l], (right)[h, s, l]
            ['hsl(124 0% 50%)', [124, 0.0, 0.5]],
            ['hsl(0, 0%, 0%)', [0, 0, 0]],
            ['hsl(350, 20%, 0%)', [350, 0.2, 0]],
            ['hsl(350, 20%, 0%)', [350, 0.2, 0]],
            ['hsl(14, 0%, 100%)', [14, 0, 1]],
            ['hsl(114, 50%, 50%)', [114, 0.5, 0.5]],
            ['hsl(350, 50%, 50%)', [350, 0.5, 0.5]],
            ['hsl(123, 39%, 89%)', [123, 0.39, 0.89]],
            ['hsl(123, 30%, 92%)', [123, 0.3, 0.92]],
            ['hsl(32, 34%, 100%)', [32, 0.34, 1]],
        ];
    }

    public static function canBeCreatedFromDataProvider(): iterable
    {
        yield from [
            [HSL::fromHSL(0, 0, 0), RGBA::fromRGBA(0, 0, 0, 0),],
            [HSL::fromHSL(36, 0.1, 0.2), RGBA::fromRGBA(56, 52, 46, 0),],
//            [HSL::fromHSL(), Hex::fromInteger(0x23142),],
        ];
    }

    public static function canBeConvertedToDTODataProvider(): iterable
    {
        foreach (self::canBeConvertedToDTODataFeeder() as $item) {
            [$left, $right] = $item;
            yield [
                [
                    self::RESULT => [
                        self::DTO => $right,
                    ],
                ],
                [
                    self::VALUE => $left,
                ]
            ];
        }
    }

    private static function canBeConvertedToDTODataFeeder(): iterable
    {
        yield from [
            // (left)string, (right)[dto],
            ['hsl(124 0% 50%)', new DRGB(0.5,0.5,0.5, 1)],
            ['hsl(169 100% 50%)', new DRGB(0,1,0.816664, 1)],
            ['hsl(124 0% 50%)', new DHSL(0.344444,0,0.5, 1)],
        ];
    }

    #[Test]
    #[DataProvider('canBeCreatedFromDataProvider')]
    public function canBeCreatedFrom(IColor $expected, IColor $incoming): void
    {
        $testee = HSL::from($incoming);
        self::assertEquals($expected, $testee);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromHSLDataProvider')]
    public function canBeCreatedFromHSL(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $hsl = $incoming[self::VALUE];
        $testee = self::getTestee($hsl);
        self::assertSame($result[self::HUE], $testee->getHue());
        self::assertSame($result[self::SATURATION], $testee->getSaturation());
        self::assertSame($result[self::LIGHTNESS], $testee->getLightness());
    }

    private static function getTestee(mixed $value): IHSLColor
    {
        if (\is_array($value)) {
            return
                HSL::fromHSL(
                    $value[self::HUE],
                    $value[self::SATURATION],
                    $value[self::LIGHTNESS],
                );
        }

        return HSL::from($value);
    }

    #[Test]
    #[DataProvider('canBeConvertedToStringDataProvider')]
    public function canBeConvertedToString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $hsl = $incoming[self::VALUE];
        $testee = self::getTestee($hsl);
        self::assertSame($result, $testee->toString());
    }

    #[Test]
    #[DataProvider('canBeConvertedToDTODataProvider')]
    public function canBeConvertedToDTO(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $value = $incoming[self::VALUE];

        $dto = $result[self::DTO];

        $testee = self::getTestee($value);
        self::assertEquals($dto, $testee->to($dto::class));

    }

    #[Test]
    #[DataProvider('canBeCreatedFromStringDataProvider')]
    public function canBeCreatedFromString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $hsl = $incoming[self::VALUE];
        $testee = self::getTestee($hsl);
        self::assertEquals($result[self::HUE], $testee->getHue());
        self::assertEquals($result[self::SATURATION], $testee->getSaturation());
        self::assertEquals($result[self::LIGHTNESS], $testee->getLightness());
    }

    #[Test]
    public function canBeModifiedWithHue(): void
    {
        $original = self::getTestee(
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
        $original = self::getTestee(
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
    public function canBeCreatedFromStringWithConversion(): void
    {
        $color = Hex::from('black');
        self::assertInstanceOf(HSL::class, HSL::from($color));
    }

    #[Test]
    public function canBeModifiedWithLightness(): void
    {
        $original = self::getTestee(
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
