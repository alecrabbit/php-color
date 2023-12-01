<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\ToRGB;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToRGB\ToRGBConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\Color\Unit\Converter\A\Override\AConvertableColorOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ToRGBConverterGenericTest extends TestCase
{
    protected const CONVERTER_TARGET_CLASS = RGB::class;
    protected const CONVERTER_CLASS = ToRGBConverter::class;

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTestee();

        self::assertInstanceOf(self::CONVERTER_CLASS, $testee);
    }

    private static function getTestee(): IConverter
    {
        return new ToRGBConverter();
    }

    #[Test]
    public function hasCorrectTargetClass(): void
    {
        $testee = self::getTestee();

        self::assertEquals(self::CONVERTER_TARGET_CLASS, self::callMethod($testee, 'getTargetClass'));
    }

    #[Test]
    public function throwsOnUnsupportedColor(): void
    {
        $testee = self::getTestee();

        $color = new AConvertableColorOverride();

        $this->expectException(UnsupportedColorConversion::class);
        $this->expectExceptionMessage(
            'Conversion from "' .
            AConvertableColorOverride::class .
            '" to "' .
            self::CONVERTER_TARGET_CLASS
            . '" is not supported by "' .
            self::CONVERTER_CLASS
            . '".'
        );

        $testee->convert($color);
    }


    #[Test]
    public function canConvertFromRGB(): void
    {
        $testee = self::getTestee();
        $color = RGB::fromString('rgb(255,0,0)');

        $result = $testee->convert($color);

        self::assertSame($color, $result);
    }

    #[Test]
    public function canConvertFromHex(): void
    {
        $testee = self::getTestee();
        $color = Hex::fromString('00ff00');

        $result = $testee->convert($color);

        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGB::class, $result);
        self::assertSame(0x00ff00, $result->getValue());
    }

    #[Test]
    public function canConvertFromRGBA(): void
    {
        $testee = self::getTestee();
        $color = RGBA::fromString('rgba(255,0,0,0.5)');

        $result = $testee->convert($color);

        self::assertNotSame($color, $result);
        self::assertInstanceOf(RGB::class, $result);
        self::assertSame(0xff0000, $result->getValue());
    }
}
