<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Functional\Color\Converter;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToRGBAConverter;
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
            // (result)[r, g, b, o], (incoming)[h, s, l, o]
            [[0, 0, 0, 0.0], [0, 0, 0, 0]],
            [[0, 0, 0, 0.0], [12, 0, 0, 0]],
            [[0, 0, 0, 0.0], [44, 0, 0, 0]],
            [[0, 0, 0, 0.0], [22, 0, 0, 0]],
            [[0, 0, 0, 0.0], [678, 0, 0, 0]],
            // rgba(140, 96, 55, 0.47) <- hsla(29, 44%, 38%, 0.47)
//            [[140, 96, 55, 0.47], [29, 44, 38, 0.47]],
        ];
    }

    public static function canConvertFromHSLDataProvider(): iterable
    {
        yield from [
            // (result)[r, g, b], (incoming)[h, s, l]
            [[0, 0, 0], [0, 0, 0]],
            [[0, 0, 0], [12, 0, 0]],
            [[0, 0, 0], [44, 0, 0]],
            [[0, 0, 0], [22, 0, 0]],
            [[0, 0, 0], [678, 0, 0]],
        ];
    }

    #[Test]
    public function returnsSameObjectOnConvertFromRGBA(): void
    {
        $testee = self::getTestee();

        $color = RGBA::fromRGBA(0, 0, 0, 0);
        self::assertSame($color, $testee->convert($color));
    }

    protected static function getTestee(): IConverter
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
        [$r, $g, $b, $o] = $expected;

        $color = HSLA::fromHSLA(...$incoming);

        $testee = self::getTestee();
        $result = $testee->convert($color);

        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGBA::class, $result);

        self::assertSame($r, $result->getRed());
        self::assertSame($g, $result->getGreen());
        self::assertSame($b, $result->getBlue());
        self::assertSame($o, $result->getOpacity());
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
