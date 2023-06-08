<?php

declare(strict_types=1);

namespace AlecRabbit\Tests\Unit\Color\Converter\A;

use AlecRabbit\Color\Contract\IConverter;
use AlecRabbit\Color\Exception\UnsupportedColorConversion;
use AlecRabbit\Tests\TestCase\TestCase;
use AlecRabbit\Tests\Unit\Color\Converter\A\Override\AConvertableColorOverride;
use AlecRabbit\Tests\Unit\Color\Converter\A\Override\AConverterOverride;
use PHPUnit\Framework\Attributes\Test;

class AConverterTest extends TestCase
{
    protected const CONVERTER_TARGET_CLASS = '---dummy---';
    protected const CONVERTER_CLASS = AConverterOverride::class;

    #[Test]
    public function canBeCreated(): void
    {
        $testee = self::getTestee();

        self::assertInstanceOf(self::CONVERTER_CLASS, $testee);
    }

    private static function getTestee(): IConverter
    {
        return new AConverterOverride();
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
