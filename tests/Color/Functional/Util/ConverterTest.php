<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\ToHex\ToHexConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLAConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBAConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBConverter;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class ConverterTest extends TestCase
{
    public static function canGetConverterFromClassStringDataProvider(): iterable
    {
        foreach (self::canGetConverterFromClassStringDataFeeder() as $item) {
            yield [
                $item[0],
                $item[1]
            ];
        }
    }

    private static function canGetConverterFromClassStringDataFeeder(): iterable
    {
        yield from [
            // (resulting)class, (incoming)value
            [ToHexConverter::class, Hex::class],
            [ToHexConverter::class, IHexColor::class],
            [ToRGBAConverter::class, RGBA::class],
            [ToRGBAConverter::class, IRGBAColor::class],
            [ToHSLConverter::class, HSL::class],
            [ToHSLConverter::class, IHSLColor::class],
            [ToHSLAConverter::class, HSLA::class],
            [ToHSLAConverter::class, IHSLAColor::class],
            [ToRGBConverter::class, RGB::class],
            [ToRGBConverter::class, IRGBColor::class],
        ];
    }

    #[Test]
    #[DataProvider('canGetConverterFromClassStringDataProvider')]
    public function canGetConverterFromClassString(string $converterClass, string $class): void
    {
        $testee = Converter::to($class);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($converterClass, $testee);
    }

    protected function getTesteeFromClassString(string $class): IToConverter
    {
        return Converter::to($class);
    }
}
