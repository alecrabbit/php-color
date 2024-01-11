<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class RGBATest extends TestCase
{
    public static function canBeCreatedFromRGBADataProvider(): iterable
    {
        foreach (self::canBeCreatedFromRGBADataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::ALPHA => $resulting[1],
                        self::RED => $resulting[2],
                        self::GREEN => $resulting[3],
                        self::BLUE => $resulting[4],
                        self::OPACITY => $resulting[5],
                    ]
                ],
                [
                    self::VALUE => [
                        self::RED => $incoming[0],
                        self::GREEN => $incoming[1],
                        self::BLUE => $incoming[2],
                        self::ALPHA => $incoming[3],
                    ],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBADataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, alpha, r, g, b, opacity], (incoming)[r, g, b, alpha,]
            [[0xFF00FF, 0x00, 0xFF, 0x00, 0xFF, 0.0], [0xFF, 0x00, 0xFF, 0x00,]],               // #0
            [[0xFF00FF, 0xFF, 0xFF, 0x00, 0xFF, 1.0], [0xFF, 0x00, 0xFF, 0xFF,]],               // #1
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0xFF, 1.0], [0xFF, 0xFF, 0xFF, 0xFF,]],               // #2
            [[0x000000, 0x00, 0x00, 0x00, 0x00, 0.0], [0x00, 0x00, 0x00, 0x00,]],               // #3
            [[0x112233, 0x7F, 0x11, 0x22, 0x33, 0.498039], [0x11, 0x22, 0x33, 0x7F,]],             // #4
            [[0x112233, 0x01, 0x11, 0x22, 0x33, 0.003922], [0x11, 0x22, 0x33, 0x01,]],             // #5
            [[0x112233, 0xFE, 0x11, 0x22, 0x33, 0.996078], [0x11, 0x22, 0x33, 0xFE,]],             // #6
            [[0xFE2233, 0xFE, 0xFE, 0x22, 0x33, 0.996078], [0xFE, 0x22, 0x33, 0xFE,]],             // #7
            [[0xFE2233, 0xFE, 0xFE, 0x22, 0x33, 0.996078], [0xFE, 0x22, -0x33, 0xFE,]],            // #8
            [[0xFE2233, 0xFE, 0xFE, 0x22, 0x33, 0.996078], [0xFE, 0x22, -0x33, -0xFE,]],           // #9
            [[0xFA2233, 0xFE, 0xFA, 0x22, 0x33, 0.996078], [-0xFA, 0x22, -0x33, 0xFE,]],           // #10
            [[0xFA2200, 0xFE, 0xFA, 0x22, 0x00, 0.996078], [-0xFA, 0x22, 256, 0xFE,]],             // #11
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [0, 0, 0, 0xCA,]],                      // #13
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [256, 256, 256, 0xCA,]],                // #14
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [-256, 256, 256, 0xCA,]],               // #15
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [256, -256, 256, 0xCA,]],               // #16
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [256, 256, -256, 0xCA,]],               // #17
        ];
    }

    public static function canBeCreatedFromRGBODataProvider(): iterable
    {
        foreach (self::canBeCreatedFromRGBODataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::ALPHA => $resulting[1],
                        self::RED => $resulting[2],
                        self::GREEN => $resulting[3],
                        self::BLUE => $resulting[4],
                        self::OPACITY => $resulting[5],
                    ]
                ],
                [
                    self::VALUE => [
                        self::RED => $incoming[0],
                        self::GREEN => $incoming[1],
                        self::BLUE => $incoming[2],
                        self::OPACITY => $incoming[3],
                    ],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBODataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, alpha, r, g, b, opacity], (incoming)[r, g, b, opacity,]
            [[0xFF00FF, 0x00, 0xFF, 0x00, 0xFF, 0.0], [0xFF, 0x00, 0xFF, 0.0,]],               // #0
            [[0xFF00FF, 0xFF, 0xFF, 0x00, 0xFF, 1.0], [0xFF, 0x00, 0xFF, 1.0,]],               // #1
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0xFF, 1.0], [0xFF, 0xFF, 0xFF, 1.0,]],               // #2
            [[0x000000, 0x00, 0x00, 0x00, 0x00, 0.0], [0x00, 0x00, 0x00, 0.0,]],               // #3
            [[0x112233, 0x7F, 0x11, 0x22, 0x33, 0.498039], [0x11, 0x22, 0x33, 0.5,]],           // #4
            [[0x112233, 0x01, 0x11, 0x22, 0x33, 0.003922], [0x11, 0x22, 0x33, 0.004,]],           // #5
            [[0x112233, 0xFE, 0x11, 0x22, 0x33, 0.996078], [0x11, 0x22, 0x33, 0.998,]],           // #6
            [[0xFE2233, 0xFE, 0xFE, 0x22, 0x33, 0.996078], [0xFE, 0x22, 0x33, 0.998,]],           // #7
            [[0xFE2233, 0xFE, 0xFE, 0x22, 0x33, 0.996078], [0xFE, 0x22, -0x33, 0.998,]],          // #8
            [[0xFE2233, 0xFE, 0xFE, 0x22, 0x33, 0.996078], [0xFE, 0x22, -0x33, -0.998,]],         // #9
            [[0xFA2233, 0xFE, 0xFA, 0x22, 0x33, 0.996078], [-0xFA, 0x22, -0x33, 0.998,]],         // #10
            [[0xFA2200, 0xFE, 0xFA, 0x22, 0x00, 0.996078], [-0xFA, 0x22, 256, 0.998,]],           // #11
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [0, 0, 0, 0.794,]],                    // #13
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [256, 256, 256, 0.794,]],              // #14
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [-256, 256, 256, 0.794,]],             // #15
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [256, -256, 256, 0.794,]],             // #16
            [[0x000000, 0xCA, 0x00, 0x00, 0x00, 0.792157], [256, 256, -256, 0.794,]],             // #17
        ];
    }

    public static function canBeConvertedToStringDataProvider(): iterable
    {
        foreach (self::stringAndRGBADataFeeder() as $item) {
            [$left, $right] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $left[0],
                    ]
                ],
                [
                    self::VALUE => [
                        self::RED => $right[0],
                        self::GREEN => $right[1],
                        self::BLUE => $right[2],
                        self::ALPHA => $right[3],
                    ],
                ]
            ];
        }
    }

    private static function stringAndRGBADataFeeder(): iterable
    {
        yield from [
            // (left)[string], (right)[r, g, b, alpha,]
            [['rgba(254, 32, 22, 0.086)'], [254, 32, 22, 22,]],      // #0
            [['rgba(254, 32, 22, 1)'], [254, 32, 22, 255,]],         // #1
            [['rgba(254, 32, 22, 0)'], [254, 32, 22, 0,]],           // #2
            [['rgba(0, 0, 0, 0)'], [0, 0, 0, 0,]],                   // #3
            [['rgba(17, 34, 51, 0.498)'], [17, 34, 51, 127,]],       // #4
            [['rgba(17, 34, 22, 0.004)'], [17, 34, 22, 1,]],         // #5
            [['rgba(17, 34, 51, 0.996)'], [17, 34, 51, 254,]],       // #6
            [['rgba(254, 34, 51, 0.996)'], [254, 34, 51, 254,]],     // #7
            [['rgba(254, 18, 51, 0.996)'], [254, 18, -51, 254,]],    // #8
            [['rgba(29, 34, 51, 0.996)'], [29, 34, -51, -254,]],     // #9
            [['rgba(254, 34, 51, 0.996)'], [-254, 34, -51, 254,]],   // #10
            [['rgba(254, 34, 0, 0.996)'], [-254, 34, 256, 254,]],    // #11
            [['rgba(0, 0, 0, 0.792)'], [0, 0, 0, 202,]],             // #12
            [['rgba(0, 0, 0, 0.792)'], [256, 256, 256, 202,]],       // #13
            [['rgba(0, 0, 0, 0.792)'], [-256, 256, 256, 202,]],      // #14
            [['rgba(0, 0, 0, 0.792)'], [256, -256, 256, 202,]],      // #15
            [['rgba(0, 0, 0, 0.792)'], [256, 256, -256, 202,]],      // #16
        ];
    }

    public static function canBeInstantiatedFromStringDataProvider(): iterable
    {
        yield from [
            ['rgb(0, 0, 0)', 0, 0, 0, 1.0],
            ['rgba(0, 0, 0, 1.0)', 0, 0, 0, 1.0],
            ['rgba(0, 12, 33, 0.333)', 0, 12, 33, 0.329412],
            ['rgba(0, 0, 1, 1.0)', 0, 0, 1, 1.0],
            ['rgb(0, 12, 1)', 0, 12, 1, 1.0],
        ];
    }

    public static function canBeCreatedFromDataProvider(): iterable
    {
        yield from [
            [RGBA::fromRGBA(0, 0, 0, 0), RGBA::fromRGBA(0, 0, 0, 0),],
            [RGBA::fromRGBA(0, 20, 0, 0), RGBA::fromRGBA(0, 20, 0, 0),],
            [RGBA::fromRGBA(0, 20, 0, 255), RGB::fromRGB(0, 20, 0),],
            [RGBA::fromRGBA(0, 21, 0, 255), Hex::fromInteger(0x001500),],
            [RGBA::fromRGBA(56, 52, 46, 255), HSLA::fromHSLA(34, 0.1, 0.2),],
            [RGBA::fromRGBA(56, 52, 46, 255), HSL::fromHSL(34, 0.1, 0.2),],
        ];
    }

    #[Test]
    #[DataProvider('canBeInstantiatedFromStringDataProvider')]
    public function canBeInstantiatedFromString(string $color, int $r, int $g, int $b, float $o): void
    {
        $testee = RGBA::fromString($color);
        self::assertSame($r, $testee->getRed());
        self::assertSame($g, $testee->getGreen());
        self::assertSame($b, $testee->getBlue());
        self::assertSame($o, $testee->getOpacity());
    }

    #[Test]
    #[DataProvider('canBeCreatedFromDataProvider')]
    public function canBeCreatedFrom(IColor $expected, IColor $incoming): void
    {
        $testee = RGBA::from($incoming);
        self::assertEquals($expected, $testee);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBADataProvider')]
    public function canBeCreatedFromRGBA(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $rgba = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGBA($rgba);
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
        self::assertEquals($result[self::OPACITY], $testee->getOpacity());
        self::assertSame($result[self::VALUE], $testee->getValue());
    }

    private static function getTesteeFromRGBA(array $rgba): IRGBAColor
    {
        return RGBA::fromRGBA(
            $rgba[self::RED],
            $rgba[self::GREEN],
            $rgba[self::BLUE],
            $rgba[self::ALPHA],
        );
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBODataProvider')]
    public function canBeCreatedFromRGBO(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $rgbo = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGBO($rgbo);
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
        self::assertEquals($result[self::OPACITY], $testee->getOpacity());
        self::assertSame($result[self::VALUE], $testee->getValue());
    }

    private static function getTesteeFromRGBO(array $rgbo): IRGBAColor
    {
        return RGBA::fromRGBO(
            $rgbo[self::RED],
            $rgbo[self::GREEN],
            $rgbo[self::BLUE],
            $rgbo[self::OPACITY],
        );
    }

    #[Test]
    public function canBeModifiedWithRed(): void
    {
        $original = RGBA::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withRed(0xFF);
        self::assertSame(0xFF, $modified->getRed());
        self::assertSame(0x00, $original->getRed());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithGreen(): void
    {
        $original = RGBA::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withGreen(0xFF);
        self::assertSame(0xFF, $modified->getGreen());
        self::assertSame(0x00, $original->getGreen());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithBlue(): void
    {
        $original = RGBA::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withBlue(0xFF);
        self::assertSame(0xFF, $modified->getBlue());
        self::assertSame(0x00, $original->getBlue());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithAlpha(): void
    {
        $original = RGBA::fromRGBA(0x00, 0x00, 0x00, 0x00);
        $modified = $original->withAlpha(0xFF);
        self::assertSame(0xFF, $modified->getAlpha());
        self::assertSame(0x00, $original->getAlpha());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithOpacity(): void
    {
        $original = RGBA::fromRGBA(0x00, 0x00, 0x00, 0xFF);
        $modified = $original->withOpacity(0.5);
        self::assertEquals(0.498039, $modified->getOpacity());
        self::assertEquals(1.0, $original->getOpacity());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    #[DataProvider('canBeConvertedToStringDataProvider')]
    public function canBeConvertedToString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $rgba = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGBA($rgba);
        self::assertSame($result[self::VALUE], $testee->toString());
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBODataProvider')]
    public function canBeSerialized(array $expected, array $incoming): void
    {
        $rgbo = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGBO($rgbo);
        $serialized = serialize($testee);
        self::assertEquals($testee, unserialize($serialized));
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBODataProvider')]
    public function canBeCreatedFromRGB(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $rgbo = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGB($rgbo);
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame(255, $testee->getAlpha());
        self::assertEquals(1.0, $testee->getOpacity());
    }

    private static function getTesteeFromRGB(array $rgbo): IRGBAColor
    {
        return
            RGBA::fromRGB(
                $rgbo[self::RED],
                $rgbo[self::GREEN],
                $rgbo[self::BLUE],
            );
    }

    #[Test]
    public function returnsSelfIfConvertToRGBA(): void
    {
        $testee = RGBA::fromRGBA(0x00, 0x00, 0x00);

        self::assertSame($testee, $testee->to(RGBA::class));
        self::assertEquals($testee, $testee->to(IRGBAColor::class));

        self::assertNotSame($testee, $testee->to(RGB::class));
    }

    #[Test]
    public function canGetColorModel(): void
    {
        $testee = RGBA::fromRGBA(0x00, 0x00, 0x00);

        self::assertInstanceOf(ModelRGB::class, $testee->getColorModel());
    }

    #[Test]
    public function canToDTO(): void
    {
        $testee = RGBA::fromRGBO(0x01, 0x02, 0x03, 0.5);

        $dto = $testee->toDTO();

        self::assertInstanceOf(DRGB::class, $dto);
        self::assertSame(0.003922, $dto->red);
        self::assertSame(0.007843, $dto->green);
        self::assertSame(0.011765, $dto->blue);
        self::assertSame(0.498039, $dto->alpha);
    }
}
