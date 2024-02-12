<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit;

use AlecRabbit\Color\Contract\IColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Model\Contract\DTO\DColor;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Model\ModelRGB;
use AlecRabbit\Color\RGB;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;

final class RGBTest extends TestCase
{
    public static function canBeCreatedFromRGBDataProvider(): iterable
    {
        foreach (self::canBeCreatedFromRGBDataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                        self::RED => $resulting[1],
                        self::GREEN => $resulting[2],
                        self::BLUE => $resulting[3],
                    ]
                ],
                [
                    self::VALUE => [
                        self::RED => $incoming[0],
                        self::GREEN => $incoming[1],
                        self::BLUE => $incoming[2],
                    ],
                ]
            ];
        }
    }

    private static function canBeCreatedFromRGBDataFeeder(): iterable
    {
        yield from [
            // (resulting)[value, alpha, r, g, b, opacity], (incoming)[r, g, b, opacity,]
            [[0xFF00FF, 0xFF, 0x00, 0xFF,], [0xFF, 0x00, 0xFF,]],
            [[0xFF00FF, 0xFF, 0x00, 0xFF,], [0xFF, 0x00, 0xFF,]],
            [[0xFFFFFF, 0xFF, 0xFF, 0xFF,], [0xFF, 0xFF, 0xFF,]],
            [[0x000000, 0x00, 0x00, 0x00,], [0x00, 0x00, 0x00,]],
            [[0x112233, 0x11, 0x22, 0x33,], [0x11, 0x22, 0x33,]],
            [[0x112233, 0x11, 0x22, 0x33,], [0x11, 0x22, 0x33,]],
            [[0x112233, 0x11, 0x22, 0x33,], [0x11, 0x22, 0x33,]],
            [[0xFE2233, 0xFE, 0x22, 0x33,], [0xFE, 0x22, 0x33,]],
            [[0xFE2233, 0xFE, 0x22, 0x33,], [0xFE, 0x22, -0x33,]],
            [[0xFE2233, 0xFE, 0x22, 0x33,], [0xFE, 0x22, -0x33,]],
            [[0xFA2233, 0xFA, 0x22, 0x33,], [-0xFA, 0x22, -0x33,]],
            [[0xFA2200, 0xFA, 0x22, 0x00,], [-0xFA, 0x22, 256,]],
            [[0x000000, 0x00, 0x00, 0x00,], [0, 0, 0,]],
            [[0x000000, 0x00, 0x00, 0x00,], [256, 256, 256,]],
            [[0x000000, 0x00, 0x00, 0x00,], [-256, 256, 256,]],
            [[0x000000, 0x00, 0x00, 0x00,], [256, -256, 256,]],
            [[0x000000, 0x00, 0x00, 0x00,], [256, 256, -256,]],
        ];
    }

    public static function canBeConvertedToStringDataProvider(): iterable
    {
        foreach (self::canBeConvertedToStringDataFeeder() as $item) {
            [$resulting, $incoming] = $item;
            yield [
                [
                    self::RESULT => [
                        self::VALUE => $resulting[0],
                    ]
                ],
                [
                    self::VALUE => [
                        self::RED => $incoming[0],
                        self::GREEN => $incoming[1],
                        self::BLUE => $incoming[2],
                    ],
                ]
            ];
        }
    }

    private static function canBeConvertedToStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)[string], (incoming)[r, g, b,]
            [['rgb(254, 32, 22)'], [254, 32, 22,]],
            [['rgb(254, 32, 22)'], [254, 32, 22,]],
            [['rgb(254, 32, 22)'], [254, 32, 22,]],
            [['rgb(0, 0, 0)'], [0, 0, 0,]],
            [['rgb(17, 34, 51)'], [17, 34, 51,]],
            [['rgb(17, 34, 22)'], [17, 34, 22,]],
            [['rgb(17, 34, 51)'], [17, 34, 51,]],
            [['rgb(254, 34, 51)'], [254, 34, 51,]],
            [['rgb(254, 18, 51)'], [254, 18, -51,]],
            [['rgb(29, 34, 51)'], [29, 34, -51,]],
            [['rgb(254, 34, 51)'], [-254, 34, -51,]],
            [['rgb(254, 34, 0)'], [-254, 34, 256,]],
            [['rgb(0, 0, 0)'], [0, 0, 0,]],
            [['rgb(0, 0, 0)'], [256, 256, 256,]],
            [['rgb(0, 0, 0)'], [-256, 256, 256,]],
            [['rgb(0, 0, 0)'], [256, -256, 256,]],
            [['rgb(0, 0, 0)'], [256, 256, -256,]],
        ];
    }

    public static function canBeCreatedFromDTODataProvider(): iterable
    {
        yield from [
            [RGB::class, new DRGB(0, 0, 0)],
        ];
    }

    public static function canBeCreatedFromStringDataProvider(): iterable
    {
        yield from [
            ['rgb(0, 0, 0)', 0, 0, 0,],
            ['rgba(0, 0, 0, 1.0)', 0, 0, 0,],
            ['rgba(0, 12, 33, 0.333)', 0, 12, 33,],
            ['rgba(0, 0, 1, 1.0)', 0, 0, 1,],
            ['rgb(0, 12, 1)', 0, 12, 1,],
        ];
    }

    #[Test]
    #[DataProvider('canBeCreatedFromDTODataProvider')]
    public function canBeCreatedFromDTO(string $expected, DColor $input): void
    {
        $testee = self::getTesteeFrom($input);
        self::assertEquals($expected, $testee::class);
    }

    private static function getTesteeFrom(mixed $value): IRGBColor
    {
        return RGB::from($value);
    }

    #[Test]
    #[DataProvider('canBeCreatedFromRGBDataProvider')]
    public function canBeCreatedFromRGB(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $rgb = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGB($rgb);
        self::assertSame($result[self::RED], $testee->getRed());
        self::assertSame($result[self::GREEN], $testee->getGreen());
        self::assertSame($result[self::BLUE], $testee->getBlue());
        self::assertSame($result[self::VALUE], $testee->getValue());
    }

    private static function getTesteeFromRGB(array $rgb): IRGBColor
    {
        return
            RGB::fromRGB(
                $rgb[self::RED],
                $rgb[self::GREEN],
                $rgb[self::BLUE],
            );
    }

    #[Test]
    public function canBeModifiedWithRed(): void
    {
        $original = RGB::fromRGB(0x00, 0x00, 0x00);
        $modified = $original->withRed(0xFF);
        self::assertSame(0xFF, $modified->getRed());
        self::assertSame(0x00, $original->getRed());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithGreen(): void
    {
        $original = RGB::fromRGB(0x00, 0x00, 0x00);
        $modified = $original->withGreen(0xFF);
        self::assertSame(0xFF, $modified->getGreen());
        self::assertSame(0x00, $original->getGreen());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    public function canBeModifiedWithBlue(): void
    {
        $original = RGB::fromRGB(0x00, 0x00, 0x00);
        $modified = $original->withBlue(0xFF);
        self::assertSame(0xFF, $modified->getBlue());
        self::assertSame(0x00, $original->getBlue());
        self::assertNotSame($original, $modified);
    }

    #[Test]
    #[DataProvider('canBeConvertedToStringDataProvider')]
    public function canBeConvertedToString(array $expected, array $incoming): void
    {
        $result = $expected[self::RESULT];
        $rgb = $incoming[self::VALUE];
        $testee = self::getTesteeFromRGB($rgb);
        self::assertSame($result[self::VALUE], $testee->toString());
    }

    #[Test]
    public function returnsSelfIfConvertToRGB(): void
    {
        $testee = RGB::fromRGB(0x00, 0x00, 0x00);
        self::assertSame($testee, $testee->to(RGB::class));
    }

    #[Test]
    #[DataProvider('canBeCreatedFromStringDataProvider')]
    public function canBeCreatedFromString(string $color, int $r, int $g, int $b): void
    {
        $testee = RGB::from($color);
        self::assertSame($r, $testee->getRed());
        self::assertSame($g, $testee->getGreen());
        self::assertSame($b, $testee->getBlue());
    }

    #[Test]
    public function canGetColorModel(): void
    {
        $testee = RGB::fromRGB(0x00, 0x00, 0x00);

        self::assertInstanceOf(ModelRGB::class, $testee->getColorModel());
    }

    #[Test]
    public function canToDTO(): void
    {
        $testee = RGB::fromRGB(0x01, 0x02, 0x03);

        $dto = $testee->to(DRGB::class);

        self::assertInstanceOf(DRGB::class, $dto);
        self::assertSame(0.003922, $dto->r);
        self::assertSame(0.007843, $dto->g);
        self::assertSame(0.011765, $dto->b);
        self::assertSame(1.0, $dto->alpha);
    }

    #[Test]
    public function canBeCreatedFromOtherColor(): void
    {
        $colorClass = RGB::class;

        $result = $this->getColorMock($colorClass);

        $color = $this->getColorMock();
        $color->expects(self::once())
            ->method('to')
            ->with($colorClass)
            ->willReturn($result);

        self::assertSame($result, RGB::from($color));
    }

    private function getColorMock(?string $colorClass = null): MockObject&IColor
    {
        return $this->createMock($colorClass ?? IColor::class);
    }
}
