<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Converter\ToHSL;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLAConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Converter\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class ToHSLAConverterGenericTest extends TestCase
{
    protected const CONVERTER_TARGET_CLASS = HSLA::class;
    protected const CONVERTER_CLASS = ToHSLAConverter::class;

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTestee();

        self::assertInstanceOf(self::CONVERTER_CLASS, $testee);
    }

    private static function getTestee(): IConverter
    {
        return new ToHSLAConverter();
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
    public function canConvertFromHSLA(): void
    {
        $testee = self::getTestee();
        $color = HSLA::fromString('hsla(0, 0%, 0%, 0.5)');

        $result = $testee->convert($color);

        self::assertSame($color, $result);
    }

    #[Test]
    public function canConvertFromHSL(): void
    {
        $testee = self::getTestee();
        $color = HSL::fromString('hsl(0, 0%, 0%)');

        $result = $testee->convert($color);
        self::assertNotSame($color, $result);
        self::assertInstanceOf(HSLA::class, $result);
        self::assertEquals(0, $result->getHue());
        self::assertSame(0.0, $result->getSaturation());
        self::assertEquals(0, $result->getLightness());
        self::assertEquals(255, $result->getAlpha());
        self::assertSame(1.0, $result->getOpacity());
    }
}
