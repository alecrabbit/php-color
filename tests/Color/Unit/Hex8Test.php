<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\Contract\IHex8Color;
use AlecRabbit\Color\Exception\InvalidArgument;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\Hex8;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class Hex8Test extends TestCase
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
                        self::OPACITY => $resulting[4],
                        self::ALPHA => $resulting[5],
                        self::TO_STRING => $resulting[6],
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
            // (resulting)[value, r, g, b, o, a, toString], (incoming)[value]
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ff00ffff'], [0xFF00FF]],
            [[0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#00ff00ff'], [0x00FF00]],
            [[0x0000FF, 0x00, 0x00, 0xFF, 1.0, 0xFF, '#0000ffff'], [0x0000FF]],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#000000ff'], [0x000000]],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFFFFFF]],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#110000ff'], [0x110000]],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#00ae00ff'], [0x00AE00]],
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
            // (resulting)[value, value8, a, toString], (incoming)value8
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
                        self::OPACITY => $resulting[4],
                        self::ALPHA => $resulting[5],
                        self::TO_STRING => $resulting[6],
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
            // (resulting)[value, r, g, b, o, a, toString], (incoming)[value]
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ff00ffff'], ['#ff00ffff']],
            [[0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#00ff00ff'], ['#00ff00ff']],
            [[0x0000FF, 0x00, 0x00, 0xFF, 1.0, 0xFF, '#0000ffff'], ['#0000ffff']],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#000000ff'], ['#000000ff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], ['#ffffffff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], ['ffffffff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], ['ffff']],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], ['#ffff']],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#110000ff'], ['#110000ff']],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#00ae00ff'], ['#00ae00ff']],
        ];
    }

    public static function canBeCreatedFromRGBDataProvider(): iterable
    {
        foreach (self::canBeCreatedFromRGBDataFeeder() as $item) {
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $item[0],
                        self::RED => $item[1],
                        self::GREEN => $item[2],
                        self::BLUE => $item[3],
                        self::OPACITY => $item[4],
                        self::ALPHA => $item[5],
                        self::TO_STRING => $item[6],
                    ]
                ],
                [
                    self::VALUE => $item[0],
                    self::RED => $item[1],
                    self::GREEN => $item[2],
                    self::BLUE => $item[3],
                    self::OPACITY => $item[4],
                    self::ALPHA => $item[5],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBDataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, r, g, b, o, a, toString],
            [0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ff00ffff'],
            [0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#00ff00ff'],
            [0x0000FF, 0x00, 0x00, 0xFF, 1.0, 0xFF, '#0000ffff'],
            [0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#000000ff'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#110000ff'],
            [0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#00ae00ff'],
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
                        self::RED => $resulting[1],
                        self::GREEN => $resulting[2],
                        self::BLUE => $resulting[3],
                        self::OPACITY => $resulting[4],
                        self::ALPHA => $resulting[5],
                        self::TO_STRING => $resulting[6],
                    ]
                ],
                [
                    self::RED => $incoming[0],
                    self::GREEN => $incoming[1],
                    self::BLUE => $incoming[2],
                    self::ALPHA => $incoming[3],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBADataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, r, g, b, o, a, toString],
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ff00ffff'], [0xFF, 0x00, 0xFF, 0xFF],],
            [[0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#00ff00ff'], [0x00, 0xFF, 0x00, 0xFF],],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0.678431, 0xAD, '#0000ffad'], [0x00, 0x00, 0xFF, 0xAD],],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#000000ff'], [0x00, 0x00, 0x00, 0xFF],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 0xFF],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.141176, 0x24, '#ffffff24'], [0xFF, 0xFF, 0xFF, 0x24],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 0xFF],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.066667, 0x11, '#ffffff11'], [0xFF, 0xFF, 0xFF, 0x11],],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#110000ff'], [0x11, 0x00, 0x00, 0xFF],],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#00ae00ff'], [0x00, 0xae, 0x00, 0xFF],],
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
                        self::RED => $resulting[1],
                        self::GREEN => $resulting[2],
                        self::BLUE => $resulting[3],
                        self::OPACITY => $resulting[4],
                        self::ALPHA => $resulting[5],
                        self::TO_STRING => $resulting[6],
                    ]
                ],
                [
                    self::RED => $incoming[0],
                    self::GREEN => $incoming[1],
                    self::BLUE => $incoming[2],
                    self::OPACITY => $incoming[3],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBODataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, r, g, b, o, a, toString],
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ff00ffff'], [0xFF, 0x00, 0xFF, 1.0],],
            [[0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#00ff00ff'], [0x00, 0xFF, 0x00, 1.0],],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0.67451, 0xAC, '#0000ffac'], [0x00, 0x00, 0xFF, 0.678],],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0.678431, 0xAD, '#0000ffad'], [0x00, 0x00, 0xFF, 0.679],],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#000000ff'], [0x00, 0x00, 0x00, 1.0],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 1.0],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.137255, 0x23, '#ffffff23'], [0xFF, 0xFF, 0xFF, 0.141],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 1.0],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.066667, 0x11, '#ffffff11'], [0xFF, 0xFF, 0xFF, 0.067],],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#110000ff'], [0x11, 0x00, 0x00, 1.0],],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#00ae00ff'], [0x00, 0xae, 0x00, 1.0],],
        ];
    }

    #[Test]
    #[DataProvider('canBeCreatedFromIntegerDataProvider')]
    public function canBeCreatedFromInteger(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $value = $incoming[self::VALUE];
        $testee = self::getTesteeFromInteger($value);
        self::assertSame($result[self::OPACITY], $testee->getOpacity());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::TO_STRING], $testee->toString());
    }

    private static function getTesteeFromInteger(int $value): IHex8Color
    {
        return Hex8::fromInteger($value);
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
    #[DataProvider('canBeCreatedFromRGBDataProvider')]
    public function canBeCreatedFromRGB(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];

        $testee = Hex8::fromRGB(
            $incoming[self::RED],
            $incoming[self::GREEN],
            $incoming[self::BLUE]
        );

        self::assertSame($result[self::OPACITY], $testee->getOpacity());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::TO_STRING], $testee->toString());
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBADataProvider')]
    public function canBeCreatedFromRGBA(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];

        $testee = Hex8::fromRGBA(
            $incoming[self::RED],
            $incoming[self::GREEN],
            $incoming[self::BLUE],
            $incoming[self::ALPHA],
        );

        self::assertSame($result[self::OPACITY], $testee->getOpacity());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::TO_STRING], $testee->toString());
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBODataProvider')]
    public function canBeCreatedFromRGBO(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];

        $testee = Hex8::fromRGBO(
            $incoming[self::RED],
            $incoming[self::GREEN],
            $incoming[self::BLUE],
            $incoming[self::OPACITY],
        );

        self::assertSame($result[self::OPACITY], $testee->getOpacity());
        self::assertSame($result[self::ALPHA], $testee->getAlpha());
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
        self::assertSame($result[self::TO_STRING], $testee->toString());
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
    public function canBeModifiedWithRed(): void
    {
        $original = Hex8::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withRed(0xFF);
        self::assertSame(0xFF, $modified->getRed());
        self::assertSame(0x00, $original->getRed());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithGreen(): void
    {
        $original = Hex8::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withGreen(0xFF);
        self::assertSame(0xFF, $modified->getGreen());
        self::assertSame(0x00, $original->getGreen());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithBlue(): void
    {
        $original = Hex8::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withBlue(0xFF);
        self::assertSame(0xFF, $modified->getBlue());
        self::assertSame(0x00, $original->getBlue());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithAlpha(): void
    {
        $original = Hex8::fromRGBA(0x00, 0x00, 0x00, 0x00);
        $modified = $original->withAlpha(0xFF);
        self::assertSame(0xFF, $modified->getAlpha());
        self::assertSame(0x00, $original->getAlpha());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithOpacity(): void
    {
        $original = Hex8::fromRGBA(0x00, 0x00, 0x00, 0xFF);
        $modified = $original->withOpacity(0.5);
        self::assertEquals(0.498039, $modified->getOpacity());
        self::assertEquals(1.0, $original->getOpacity());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    #[DataProvider('canGetValue8DataProvider')]
    public function canGetValue8(array $expected, int $incoming): void
    {
        $testee = Hex8::fromInteger8($incoming);

        self::assertSame($expected[self::VALUE], $testee->getValue());
        self::assertSame($expected[self::VALUE_8], $testee->getValue8());
        self::assertSame($expected[self::ALPHA], $testee->getAlpha());
        self::assertSame($expected[self::TO_STRING], $testee->toString());
        self::assertSame($expected[self::TO_STRING], (string)$testee);
    }

    #[Test]
    public function canGetColorModel(): void
    {
        $testee = self::getTesteeFromInteger(0x000000);

        self::assertInstanceOf(ModelRGB::class, $testee->getColorModel());
    }

    #[Test]
    public function canToDTO(): void
    {
        $testee = self::getTesteeFromInteger8(0x01020300);

        $dto = $testee->toDTO();

        self::assertInstanceOf(DRGB::class, $dto);
        self::assertSame(0.003922, $dto->red);
        self::assertSame(0.007843, $dto->green);
        self::assertSame(0.011765, $dto->blue);
        self::assertSame(0.0, $dto->alpha);
    }

    private static function getTesteeFromInteger8(int $value8): IHex8Color
    {
        return Hex8::fromInteger8($value8);
    }

    #[Test]
    public function throwsIfPassedDTOIsInvalid(): void
    {
        $this->expectException(InvalidArgument::class);
        $this->expectExceptionMessage(
            'Color must be instance of "AlecRabbit\Color\Model\DTO\DRGB", "AlecRabbit\Tests\Color\Unit\Override\ColorDTOOverride" given.'
        );

        Hex8::fromDTO(new \AlecRabbit\Tests\Color\Unit\Override\ColorDTOOverride());
    }
}
