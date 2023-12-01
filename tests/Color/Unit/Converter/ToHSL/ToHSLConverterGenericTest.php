<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Color\Unit\Converter\ToHSL;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToHSL\ToHSLConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\HSL;
use AlecRabbit\Color\HSLA;
use AlecRabbit\Tests\Color\Unit\Converter\A\Override\AConvertableColorOverride;
use AlecRabbit\Tests\TestCase\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ToHSLConverterGenericTest extends TestCase
{
    protected const CONVERTER_TARGET_CLASS = HSL::class;
    protected const CONVERTER_CLASS = ToHSLConverter::class;

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTestee();

        self::assertInstanceOf(self::CONVERTER_CLASS, $testee);
    }

    private static function getTestee(): IConverter
    {
        return new ToHSLConverter();
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
    public function canConvertFromHSL(): void
    {
        $testee = self::getTestee();
        $color = HSL::fromString('hsl(0, 0%, 0%)');

        $result = $testee->convert($color);

        self::assertSame($color, $result);
    }

    #[Test]
    public function canConvertFromHSLA(): void
    {
        $testee = self::getTestee();
        $color = HSLA::fromString('hsla(0, 0%, 0%, 1)');

        $result = $testee->convert($color);
        self::assertNotSame($color, $result);
        self::assertInstanceOf(HSL::class, $result);
        self::assertEquals(0, $result->getHue());
        self::assertSame(0.0, $result->getSaturation());
        self::assertEquals(0, $result->getLightness());
    }
}
