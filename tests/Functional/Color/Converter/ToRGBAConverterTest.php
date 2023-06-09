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
    public static function blackHSLAStringDataProvider(): iterable
    {
        yield from [
            ['hsla(0, 0%, 0%, 0)'],
            ['hsla(12, 0%, 0%, 0)'],
            ['hsla(44, 0%, 0%, 0)'],
            ['hsla(22, 0%, 0%, 0)'],
            ['hsla(678, 0%, 0%, 0)'],
        ];
    }

    public static function blackHSLStringDataProvider(): iterable
    {
        yield from [
            ['hsla(0, 0%, 0%, 0)'],
            ['hsla(12, 0%, 0%, 0)'],
            ['hsla(44, 0%, 0%, 0)'],
            ['hsla(22, 0%, 0%, 0)'],
            ['hsla(678, 0%, 0%, 0)'],
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
    #[DataProvider('blackHSLAStringDataProvider')]
    public function canConvertFromHSLA(string $colorString): void
    {
        $testee = self::getTestee();

        $color = HSLA::fromString($colorString);
        $result = $testee->convert($color);
        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGBA::class, $result);
        self::assertSame(0, $result->getRed());
        self::assertSame(0, $result->getGreen());
        self::assertSame(0, $result->getBlue());
        self::assertSame(0.0, $result->getOpacity());
    }

    #[Test]
    #[DataProvider('blackHSLStringDataProvider')]
    public function canConvertFromHSL(string $colorString): void
    {
        $testee = self::getTestee();

        $color = HSL::fromString($colorString);
        $result = $testee->convert($color);
        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGBA::class, $result);
        self::assertSame(0, $result->getRed());
        self::assertSame(0, $result->getGreen());
        self::assertSame(0, $result->getBlue());
        self::assertSame(1.0, $result->getOpacity());
    }

}
