<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Converter;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Converter\ToHexConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Color\Hex;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Converter\A\Override\AConvertableColorOverride;
use PHPUnit\Framework\Attributes\Test;

class ToHexConverterTest extends TestCase
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

        $testee->convert(new AConvertableColorOverride());
    }
}
