<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\Converter\IToConverter;
use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Converter\ToHSL\ToHSLConverter;
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
            [To\Hex\ToHexConverter::class, Hex::class],
            [To\Hex\ToHexConverter::class, IHexColor::class],
            [To\RGBA\ToRGBAConverter::class, RGBA::class],
            [To\RGBA\ToRGBAConverter::class, IRGBAColor::class],
            [ToHSLConverter::class, HSL::class],
            [ToHSLConverter::class, IHSLColor::class],
            [To\HSLA\ToHSLAConverter::class, HSLA::class],
            [To\HSLA\ToHSLAConverter::class, IHSLAColor::class],
            [To\RGB\ToRGBConverter::class, RGB::class],
            [To\RGB\ToRGBConverter::class, IRGBColor::class],
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
