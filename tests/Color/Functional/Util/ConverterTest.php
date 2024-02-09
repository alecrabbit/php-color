<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Functional\Util;

use AlecRabbit\Color;
use AlecRabbit\Color\Converter\To;
use AlecRabbit\Color\Model\DTO\DHSL;
use AlecRabbit\Color\Model\DTO\DRGB;
use AlecRabbit\Color\Util\Converter;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class ConverterTest extends TestCase
{
    public static function canToDataProvider(): iterable
    {
        yield from [
            [To\ToRGBConverter::class, Color\RGB::class],
            [To\ToAHexConverter::class, Color\AHex::class],
            [To\ToRGBAConverter::class, Color\RGBA::class],
            [To\ToHSLConverter::class, Color\HSL::class],
            [To\ToHSLAConverter::class, Color\HSLA::class],
            [To\ToHex8Converter::class, Color\Hex8::class],
            [To\ToHexConverter::class, Color\Hex::class],
            [To\ToHexConverter::class, Color\Hex::class],
            [To\ToHexConverter::class, Color\Contract\IHexColor::class],
            [To\ToRGBAConverter::class, Color\RGBA::class],
            [To\ToRGBAConverter::class, Color\Contract\IRGBAColor::class],
            [To\ToHSLConverter::class, Color\HSL::class],
            [To\ToHSLConverter::class, Color\Contract\IHSLColor::class],
            [To\ToHSLAConverter::class, Color\HSLA::class],
            [To\ToHSLAConverter::class, Color\Contract\IHSLAColor::class],
            [To\ToRGBConverter::class, Color\RGB::class],
            [To\ToRGBConverter::class, Color\Contract\IRGBColor::class],

            [To\ToRGBAConverter::class, DRGB::class],
            [To\ToHSLAConverter::class, DHSL::class],
        ];
    }

    #[Test]
    #[DataProvider('canToDataProvider')]
    public function canTo(string $expectedClass, string $input): void
    {
        $converter = Converter::to($input);

        self::assertEquals($expectedClass, $converter::class);
    }

}
