<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color\Contract\IHexColor;
use AlecRabbit\Color\Contract\IHSLAColor;
use AlecRabbit\Color\Contract\IHSLColor;
use AlecRabbit\Color\Contract\IRGBAColor;
use AlecRabbit\Color\Contract\IRGBColor;
use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Color\Util\Color;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ColorMethodToTest extends TestCase
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
            [To\ToHexConverter::class, Hex::class],
            [To\ToHexConverter::class, IHexColor::class],
            [To\ToRGBAConverter::class, RGBA::class],
            [To\ToRGBAConverter::class, IRGBAColor::class],
            [To\ToHSLConverter::class, HSL::class],
            [To\ToHSLConverter::class, IHSLColor::class],
            [To\ToHSLAConverter::class, HSLA::class],
            [To\ToHSLAConverter::class, IHSLAColor::class],
            [To\ToRGBConverter::class, RGB::class],
            [To\ToRGBConverter::class, IRGBColor::class],

            [To\ToHexConverter::class, DRGB::class],
            [To\ToHSLConverter::class, DHSL::class],
        ];
    }

    #[Test]
    #[DataProvider('canGetConverterFromClassStringDataProvider')]
    public function canGetConverterFromClassString(string $converterClass, string $class): void
    {
        $testee = Color::to($class);

        /** @noinspection UnnecessaryAssertionInspection */
        self::assertInstanceOf($converterClass, $testee);
    }
}
