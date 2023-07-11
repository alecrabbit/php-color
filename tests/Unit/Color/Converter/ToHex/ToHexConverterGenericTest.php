<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Converter\ToHex;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToHex\ToHexConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Hex;
use AlecRabbit\Color\RGB;
use AlecRabbit\Color\RGBA;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Converter\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class ToHexConverterGenericTest extends TestCase
{
    protected const CONVERTER_TARGET_CLASS = Hex::class;
    protected const CONVERTER_CLASS = ToHexConverter::class;

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTestee();

        self::assertInstanceOf(self::CONVERTER_CLASS, $testee);
    }

    private static function getTestee(): IConverter
    {
        return new ToHexConverter();
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
    public function canConvertFromHex(): void
    {
        $testee = self::getTestee();
        $color = Hex::fromString('ff0000');

        $result = $testee->convert($color);

        self::assertSame($color, $result);
    }

    #[Test]
    public function canConvertFromRGB(): void
    {
        $testee = self::getTestee();
        $color = RGB::fromRGB(0xff, 0, 0);

        $result = $testee->convert($color);

        self::assertNotSame($color, $result);
        self::assertInstanceOf(Hex::class, $result);
        self::assertSame(0xff0000, $result->getValue());
    }

    #[Test]
    public function canConvertFromRGBA(): void
    {
        $testee = self::getTestee();
        $color = RGBA::fromRGBA(0xff, 0, 0);

        $result = $testee->convert($color);

        self::assertNotSame($color, $result);
        self::assertInstanceOf(Hex::class, $result);
        self::assertSame(0xff0000, $result->getValue());
    }
}
