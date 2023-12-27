<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Converter;

use AlecRabbit\Color\Contract\IToConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBAConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ToRGBAConverterTest extends TestCase
{
    public static function canConvertFromHSLADataProvider(): iterable
    {
        yield from [
            // (result)[r, g, b, a], (incoming)[h, s, l, o]
            [[0, 0, 0, 0], [0, 0, 0, 0]],
            [[0, 0, 0, 0], [12, 0, 0, 0]],
            [[0, 0, 0, 0], [44, 0, 0, 0]],
            [[0, 0, 0, 0], [22, 0, 0, 0]],
            [[0, 0, 0, 0], [678, 0, 0, 0]],
            [[140, 95, 54, 119], [29, 0.44, 0.38, 0.47]],
            [[74, 247, 204, 119], [165, 0.92, 0.63, 0.47]],
            [[191, 204, 163, 175], [79, 0.29, 0.72, 0.69]],
        ];
    }

    public static function canConvertFromHSLDataProvider(): iterable
    {
        yield from [
            // (result)[r, g, b], (incoming)[h, s, l]
            [[0, 0, 0], [0, 0, 0]],
            [[0, 0, 0], [12, 0, 0]],
            [[0, 0, 0], [44, 0, 0]],
            [[191, 204, 163], [79, 0.29, 0.72]],
            [[0, 0, 0], [22, 0, 0]],
            [[0, 0, 0], [678, 0, 0]],
            [[74, 247, 204], [165, 0.92, 0.63]],
            [[140, 95, 54], [29, 0.44, 0.38]],
        ];
    }

    #[Test]
    public function returnsSameObjectOnConvertFromRGBA(): void
    {
        $testee = self::getTestee();

        $color = RGBA::fromRGBA(0, 0, 0, 0);
        self::assertSame($color, $testee->convert($color));
    }

    protected static function getTestee(): IToConverter
    {
        return new ToRGBAConverter();
    }

    #[Test]
    public function canConvertFromRGB(): void
    {
        $testee = self::getTestee();

        $color = RGB::fromRGB(0, 0, 0);
        $result = $testee->convert($color);
        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGBA::class, $result);
        self::assertSame(0, $result->getRed());
        self::assertSame(0, $result->getGreen());
        self::assertSame(0, $result->getBlue());
    }

    #[Test]
    public function canConvertFromHex(): void
    {
        $testee = self::getTestee();

        $color = Hex::fromInteger(0);
        $result = $testee->convert($color);
        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGBA::class, $result);
        self::assertSame(0, $result->getRed());
        self::assertSame(0, $result->getGreen());
        self::assertSame(0, $result->getBlue());
    }

    #[Test]
    #[DataProvider('canConvertFromHSLADataProvider')]
    public function canConvertFromHSLA(array $expected, array $incoming): void
    {
        [$r, $g, $b, $a] = $expected;

        $color = HSLA::fromHSLA(...$incoming);

        $testee = self::getTestee();
        $result = $testee->convert($color);

        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGBA::class, $result);

        self::assertSame($r, $result->getRed());
        self::assertSame($g, $result->getGreen());
        self::assertSame($b, $result->getBlue());
        self::assertSame($a, $result->getAlpha());
    }

    #[Test]
    #[DataProvider('canConvertFromHSLDataProvider')]
    public function canConvertFromHSL(array $expected, array $incoming): void
    {
        [$r, $g, $b] = $expected;

        $color = HSL::fromHSL(...$incoming);

        $testee = self::getTestee();
        $result = $testee->convert($color);

        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGBA::class, $result);

        self::assertSame($r, $result->getRed());
        self::assertSame($g, $result->getGreen());
        self::assertSame($b, $result->getBlue());
        self::assertSame(1.0, $result->getOpacity());
    }
}
