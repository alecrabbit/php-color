<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\AHex;
use AlecRabbit\Color\Contract\IAHexColor;
use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class AHexTest extends TestCase
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
            [[0x223344, 0x22, 0x33, 0x44, 0.0, 0x00, '#00223344'], [0x00223344]],
            [[0xff00ff, 0xff, 0x00, 0xff, 1.0, 0xff, '#ffff00ff'], [0xffff00ff]],
            [[0x00ff00, 0x00, 0xff, 0x00, 1.0, 0xff, '#ff00ff00'], [0xff00ff00]],
            [[0x0000ff, 0x00, 0x00, 0xff, 1.0, 0xff, '#ff0000ff'], [0xff0000ff]],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xff, '#ff000000'], [0xff000000]],
            [[0xffffff, 0xff, 0xff, 0xff, 1.0, 0xff, '#ffffffff'], [0xffffffff]],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xff, '#ff110000'], [0xff110000]],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xff, '#ff00ae00'], [0xff00ae00]],
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
            // (resulting)[value, value8, a, toString], (incoming)int
            [[0x223344, 0x11223344, 0x11, '#11223344'], 0x11223344],
            [[0xff00ff, 0x00ff00ff, 0x00, '#00ff00ff'], 0x00ff00ff],
            [[0x00ff00, 0xad00ff00, 0xad, '#ad00ff00'], 0xad00ff00],
            [[0x0000ff, 0x000000ff, 0x00, '#000000ff'], 0x000000ff],
            [[0x000000, 0x11000000, 0x11, '#11000000'], 0x11000000],
            [[0xffffff, 0x00ffffff, 0x00, '#00ffffff'], 0x00ffffff],
            [[0x110000, 0x22110000, 0x22, '#22110000'], 0x22110000],
            [[0x00ae00, 0x0000ae00, 0x00, '#0000ae00'], 0x0000ae00],
            [[0x0aae00, 0xdd0aae00, 0xdd, '#dd0aae00'], 0xdd0aae00],
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
            [[0xffffff, 0xff, 0xff, 0xff, 1.0, 0xff, '#ffffffff'], ['#ffffffff']],
            [[0xff00ff, 0xff, 0x00, 0xff, 1.0, 0xff, '#ffff00ff'], ['#ff00ffff']],
            [[0x00ff00, 0x00, 0xff, 0x00, 1.0, 0xff, '#ff00ff00'], ['#00ff00ff']],
            [[0x0000ff, 0x00, 0x00, 0xff, 1.0, 0xff, '#ff0000ff'], ['#0000ffff']],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xff, '#ff000000'], ['#000000ff']],
            [[0xffffff, 0xff, 0xff, 0xff, 1.0, 0xff, '#ffffffff'], ['ffffffff']],
            [[0xffffff, 0xff, 0xff, 0xff, 1.0, 0xff, '#ffffffff'], ['ffff']],
            [[0xffffff, 0xff, 0xff, 0xff, 1.0, 0xff, '#ffffffff'], ['#ffff']],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xff, '#ff110000'], ['#110000ff']],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xff, '#ff00ae00'], ['#00ae00ff']],
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
            [0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ffff00ff'],
            [0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#ff00ff00'],
            [0x0000FF, 0x00, 0x00, 0xFF, 1.0, 0xFF, '#ff0000ff'],
            [0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#ff000000'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'],
            [0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#ff110000'],
            [0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#ff00ae00'],
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
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ffff00ff'], [0xFF, 0x00, 0xFF, 0xFF],],
            [[0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#ff00ff00'], [0x00, 0xFF, 0x00, 0xFF],],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0.678431, 0xAD, '#ad0000ff'], [0x00, 0x00, 0xFF, 0xAD],],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#ff000000'], [0x00, 0x00, 0x00, 0xFF],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 0xFF],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.141176, 0x24, '#24ffffff'], [0xFF, 0xFF, 0xFF, 0x24],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 0xFF],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.066667, 0x11, '#11ffffff'], [0xFF, 0xFF, 0xFF, 0x11],],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#ff110000'], [0x11, 0x00, 0x00, 0xFF],],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#ff00ae00'], [0x00, 0xae, 0x00, 0xFF],],
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
            [[0xFF00FF, 0xFF, 0x00, 0xFF, 1.0, 0xFF, '#ffff00ff'], [0xFF, 0x00, 0xFF, 1.0],],
            [[0x00FF00, 0x00, 0xFF, 0x00, 1.0, 0xFF, '#ff00ff00'], [0x00, 0xFF, 0x00, 1.0],],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0.67451, 0xAC, '#ac0000ff'], [0x00, 0x00, 0xFF, 0.678],],
            [[0x0000FF, 0x00, 0x00, 0xFF, 0.678431, 0xAD, '#ad0000ff'], [0x00, 0x00, 0xFF, 0.679],],
            [[0x000000, 0x00, 0x00, 0x00, 1.0, 0xFF, '#ff000000'], [0x00, 0x00, 0x00, 1.0],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 1.0],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.137255, 0x23, '#23ffffff'], [0xFF, 0xFF, 0xFF, 0.141],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 1.0, 0xFF, '#ffffffff'], [0xFF, 0xFF, 0xFF, 1.0],],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF, 0.066667, 0x11, '#11ffffff'], [0xFF, 0xFF, 0xFF, 0.067],],
            [[0x110000, 0x11, 0x00, 0x00, 1.0, 0xFF, '#ff110000'], [0x11, 0x00, 0x00, 1.0],],
            [[0x00ae00, 0x00, 0xae, 0x00, 1.0, 0xFF, '#ff00ae00'], [0x00, 0xae, 0x00, 1.0],],
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

    private static function getTesteeFromInteger(int $value): IAHexColor
    {
        return AHex::fromInteger($value);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromStringDataProvider')]
    public function canBeCreatedFromString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $value = $incoming[self::VALUE];
        $testee = self::getTesteeFromString($value);
        self::assertSame($result[self::TO_STRING], $testee->toString());
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
    }

    private static function getTesteeFromString(string $value): IAHexColor
    {
        return AHex::from($value);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBDataProvider')]
    public function canBeCreatedFromRGB(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];

        $testee = AHex::fromRGB(
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

        $testee = AHex::fromRGBA(
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

        $testee = AHex::fromRGBO(
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
        $original = AHex::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withRed(0xFF);
        self::assertSame(0xFF, $modified->getRed());
        self::assertSame(0x00, $original->getRed());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithGreen(): void
    {
        $original = AHex::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withGreen(0xFF);
        self::assertSame(0xFF, $modified->getGreen());
        self::assertSame(0x00, $original->getGreen());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithBlue(): void
    {
        $original = AHex::fromRGBA(0x00, 0x00, 0x00);
        $modified = $original->withBlue(0xFF);
        self::assertSame(0xFF, $modified->getBlue());
        self::assertSame(0x00, $original->getBlue());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithAlpha(): void
    {
        $original = AHex::fromRGBA(0x00, 0x00, 0x00, 0x00);
        $modified = $original->withAlpha(0xFF);
        self::assertSame(0xFF, $modified->getAlpha());
        self::assertSame(0x00, $original->getAlpha());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithOpacity(): void
    {
        $original = AHex::fromRGBA(0x00, 0x00, 0x00, 0xFF);
        $modified = $original->withOpacity(0.5);
        self::assertEquals(0.498039, $modified->getOpacity());
        self::assertEquals(1.0, $original->getOpacity());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    #[DataProvider('canGetValue8DataProvider')]
    public function canGetValue8(array $expected, int $incoming): void
    {
        $testee = AHex::fromInteger($incoming);

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
        $testee = self::getTesteeFromInteger8(0x00010203);

        $dto = $testee->to(DRGB::class);

        self::assertInstanceOf(DRGB::class, $dto);
        self::assertSame(0.003922, $dto->r);
        self::assertSame(0.007843, $dto->g);
        self::assertSame(0.011765, $dto->b);
        self::assertSame(0.0, $dto->alpha);
    }

    private static function getTesteeFromInteger8(int $value8): IAHexColor
    {
        return AHex::fromInteger($value8);
    }

    #[Test]
    public function canBeCreatedFromOtherColor(): void
    {
        $colorClass = AHex::class;

        $result = $this->getColorMock($colorClass);

        $color = $this->getColorMock();
        $color->expects(self::once())
            ->method('to')
            ->with($colorClass)
            ->willReturn($result);

        self::assertSame($result, AHex::from($color));
    }

    private function getColorMock(?string $colorClass = null): MockObject&IColor
    {
        return $this->createMock($colorClass ?? IColor::class);
    }
}
